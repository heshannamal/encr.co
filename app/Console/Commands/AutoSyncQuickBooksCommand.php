<?php

namespace App\Console\Commands;

use App\Http\Controllers\QuickBooksController;
use App\Models\QuickbooksToken;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

class AutoSyncQuickBooksCommand extends Command
{
    /**
     * Production QuickBooks automatic sync.
     */
    protected $signature = 'quickbooks:auto-sync';

    protected $description = 'Automatically import unsynced payment records into QuickBooks';

    /**
     * Prevent two manual/scheduled executions from running the entire
     * auto-sync process at the same time.
     */
    private const COMMAND_LOCK_KEY = 'quickbooks:auto-sync:command';

    /**
     * Maximum lifetime of the command lock in seconds.
     * Individual payment exports are also protected inside QuickBooksController.
     */
    private const COMMAND_LOCK_SECONDS = 3600;

    public function handle(QuickBooksController $controller): int
    {
        $commandLock = null;

        try {
            /*
            |--------------------------------------------------------------------------
            | Prevent Concurrent Command Runs
            |--------------------------------------------------------------------------
            |
            | Kernel ->withoutOverlapping() protects scheduled executions, but it
            | does not protect against somebody manually running the same Artisan
            | command while the scheduler is already running.
            |
            | The controller still keeps its payment-specific lock/duplicate check.
            */

            $commandLock = Cache::lock(
                self::COMMAND_LOCK_KEY,
                self::COMMAND_LOCK_SECONDS
            );

            if (!$commandLock->get()) {
                $this->warn(
                    'QuickBooks auto sync is already running. This run was skipped.'
                );

                return self::SUCCESS;
            }

            /*
            |--------------------------------------------------------------------------
            | Load Saved QuickBooks Token
            |--------------------------------------------------------------------------
            */

            $quickbooksToken = QuickbooksToken::find(1);

            if (!$quickbooksToken) {
                $this->error(
                    'QuickBooks token not found. Please connect QuickBooks first.'
                );

                return self::FAILURE;
            }

            if (empty($quickbooksToken->realm_id)) {
                $this->error(
                    'QuickBooks realm ID not found. Please reconnect QuickBooks.'
                );

                return self::FAILURE;
            }

            if (empty($quickbooksToken->refresh_token)) {
                $this->error(
                    'QuickBooks refresh token not found. Please reconnect QuickBooks.'
                );

                return self::FAILURE;
            }

            if (
                empty(config('services.qbo.client_id')) ||
                empty(config('services.qbo.client_secret'))
            ) {
                $this->error(
                    'QuickBooks client ID/client secret is not configured.'
                );

                return self::FAILURE;
            }

            /*
            |--------------------------------------------------------------------------
            | Refresh Access Token When Needed
            |--------------------------------------------------------------------------
            |
            | Do not assume access_token_expires_at is already cast to Carbon.
            | This remains safe even if the model returns it as a string.
            */

            $expiresAt = $this->parseExpiry(
                $quickbooksToken->access_token_expires_at
            );

            if (
                empty($quickbooksToken->access_token) ||
                !$expiresAt ||
                now()->greaterThanOrEqualTo(
                    $expiresAt->copy()->subMinutes(5)
                )
            ) {
                $this->info(
                    'Refreshing QuickBooks access token...'
                );

                $quickbooksToken = $this->refreshQuickBooksToken(
                    $quickbooksToken
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Seed Runtime Credentials
            |--------------------------------------------------------------------------
            |
            | The existing QuickBooksService may read session or cache. Scheduler
            | executions do not come from a browser request, so seed both stores.
            */

            $this->seedRuntimeCredentials(
                $quickbooksToken
            );

            /*
            |--------------------------------------------------------------------------
            | REAL AUTO SYNC
            |--------------------------------------------------------------------------
            */

            $this->info(
                'Starting QuickBooks automatic sync...'
            );

            $originalAccessToken =
                (string) $quickbooksToken->access_token;

            $originalRefreshToken =
                (string) $quickbooksToken->refresh_token;

            $originalRealmId =
                (string) $quickbooksToken->realm_id;

            $result = $controller->AutoSyncToQuickbook();

            if (!is_array($result)) {
                throw new \RuntimeException(
                    'AutoSyncToQuickbook() did not return the expected result array.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Persist Runtime Token Changes
            |--------------------------------------------------------------------------
            |
            | A service method may refresh a token while processing records.
            | The old command always preferred session first, which could write an
            | old session token back over a newer cache token. Prefer whichever
            | runtime token actually changed from the original stored value.
            */

            $runtimeAccessToken =
                $this->resolveRuntimeValue(
                    'quickbooks.access_token',
                    $originalAccessToken
                );

            $runtimeRefreshToken =
                $this->resolveRuntimeValue(
                    'quickbooks.refresh_token',
                    $originalRefreshToken
                );

            $runtimeRealmId =
                $this->resolveRuntimeValue(
                    'quickbooks.realm_id',
                    $originalRealmId
                );

            $updateData = [
                'access_token' =>
                    $runtimeAccessToken,

                'refresh_token' =>
                    $runtimeRefreshToken,

                'realm_id' =>
                    $runtimeRealmId,
            ];

            if (
                $runtimeAccessToken !== ''
                && $runtimeAccessToken !== $originalAccessToken
            ) {
                /*
                 * If QuickBooksService refreshed the access token internally but
                 * does not expose its exact expiry, use Intuit's normal one-hour
                 * access-token window.
                 */
                $updateData['access_token_expires_at'] =
                    now()->addSeconds(3600);
            }

            $quickbooksToken->update(
                $updateData
            );

            /*
            |--------------------------------------------------------------------------
            | Console Summary
            |--------------------------------------------------------------------------
            |
            | Current AutoSyncToQuickbook() returns scanned/imported/skipped/failed.
            | Do not display a fake "Email Sent" value when the controller does not
            | return that field.
            */

            $scanned = (int) ($result['scanned'] ?? 0);
            $imported = (int) ($result['imported'] ?? 0);
            $skipped = (int) ($result['skipped'] ?? 0);
            $failed = (int) ($result['failed'] ?? 0);

            $this->table(
                [
                    'Scanned',
                    'Imported',
                    'Skipped',
                    'Failed',
                ],
                [[
                    $scanned,
                    $imported,
                    $skipped,
                    $failed,
                ]]
            );

            if ($failed > 0) {
                $this->error(
                    'QuickBooks auto sync completed with '
                    . $failed
                    . ' failed payment record(s).'
                );

                return self::FAILURE;
            }

            $this->info(
                'QuickBooks auto sync completed successfully.'
            );

            return self::SUCCESS;

        } catch (Throwable $exception) {
            report($exception);

            $this->error(
                'QuickBooks auto sync failed: '
                . $exception->getMessage()
            );

            return self::FAILURE;

        } finally {
            /*
             * Always release the command-level lock, including validation/token
             * failures. Payment-level locks are released by the controller.
             */
            if ($commandLock) {
                try {
                    $commandLock->release();
                } catch (Throwable $lockException) {
                    report($lockException);
                }
            }
        }
    }

    /**
     * Parse access-token expiry regardless of whether the Eloquent model casts
     * the column to Carbon already.
     */
    private function parseExpiry($value): ?Carbon
    {
        if (empty($value)) {
            return null;
        }

        try {
            return $value instanceof Carbon
                ? $value->copy()
                : Carbon::parse($value);
        } catch (Throwable $exception) {
            report($exception);

            return null;
        }
    }

    /**
     * Seed both session and cache because the existing QuickBooks service can
     * run from HTTP requests as well as scheduler/CLI execution.
     */
    private function seedRuntimeCredentials(
        QuickbooksToken $quickbooksToken
    ): void {
        session([
            'quickbooks.access_token' =>
                $quickbooksToken->access_token,

            'quickbooks.refresh_token' =>
                $quickbooksToken->refresh_token,

            'quickbooks.realm_id' =>
                $quickbooksToken->realm_id,
        ]);

        Cache::forever(
            'quickbooks.access_token',
            $quickbooksToken->access_token
        );

        Cache::forever(
            'quickbooks.refresh_token',
            $quickbooksToken->refresh_token
        );

        Cache::forever(
            'quickbooks.realm_id',
            $quickbooksToken->realm_id
        );
    }

    /**
     * Return the newest runtime value without letting an unchanged/stale session
     * value overwrite a token that the service refreshed in cache.
     */
    private function resolveRuntimeValue(
        string $key,
        string $originalValue
    ): string {
        $sessionValue =
            (string) (session($key) ?? '');

        $cacheValue =
            (string) (Cache::get($key) ?? '');

        if (
            $sessionValue !== ''
            && $sessionValue !== $originalValue
        ) {
            return $sessionValue;
        }

        if (
            $cacheValue !== ''
            && $cacheValue !== $originalValue
        ) {
            return $cacheValue;
        }

        if ($sessionValue !== '') {
            return $sessionValue;
        }

        if ($cacheValue !== '') {
            return $cacheValue;
        }

        return $originalValue;
    }

    /**
     * Refresh the Intuit OAuth access token.
     */
    private function refreshQuickBooksToken(
        QuickbooksToken $quickbooksToken
    ): QuickbooksToken {
        $response = Http::asForm()
            ->timeout(30)
            ->withHeaders([
                'Authorization' =>
                    'Basic '
                    . base64_encode(
                        config('services.qbo.client_id')
                        . ':'
                        . config('services.qbo.client_secret')
                    ),

                'Accept' =>
                    'application/json',
            ])
            ->post(
                'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer',
                [
                    'grant_type' =>
                        'refresh_token',

                    'refresh_token' =>
                        $quickbooksToken->refresh_token,
                ]
            );

        $data = $response->json();

        if (!$response->successful()) {
            /*
             * Do not dump the entire token response into the scheduler console.
             * Return the useful Intuit OAuth message only.
             */
            $message =
                $data['error_description']
                ?? $data['error']
                ?? (
                    'HTTP '
                    . $response->status()
                );

            throw new \RuntimeException(
                'QuickBooks token refresh failed: '
                . $message
            );
        }

        if (empty($data['access_token'])) {
            throw new \RuntimeException(
                'QuickBooks access token was not returned.'
            );
        }

        $newAccessToken =
            (string) $data['access_token'];

        $newRefreshToken =
            (string) (
                $data['refresh_token']
                ?? $quickbooksToken->refresh_token
            );

        $expiresIn = max(
            60,
            (int) ($data['expires_in'] ?? 3600)
        );

        $quickbooksToken->update([
            'access_token' =>
                $newAccessToken,

            'refresh_token' =>
                $newRefreshToken,

            'access_token_expires_at' =>
                now()->addSeconds($expiresIn),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Keep Runtime Stores In Sync
        |--------------------------------------------------------------------------
        */

        session([
            'quickbooks.access_token' =>
                $newAccessToken,

            'quickbooks.refresh_token' =>
                $newRefreshToken,

            'quickbooks.realm_id' =>
                $quickbooksToken->realm_id,
        ]);

        Cache::forever(
            'quickbooks.access_token',
            $newAccessToken
        );

        Cache::forever(
            'quickbooks.refresh_token',
            $newRefreshToken
        );

        Cache::forever(
            'quickbooks.realm_id',
            $quickbooksToken->realm_id
        );

        return $quickbooksToken->fresh();
    }
}
