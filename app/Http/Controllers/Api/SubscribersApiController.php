<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SubscribeLog;
use Exception;
use App\Services\EmailNotificationBuilderService;

class SubscribersApiController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'platform' => 'required|string|max:100',
                'email' => 'required|email|max:255',
                'name' => 'nullable|string|max:100',

                'logo' => 'nullable|url|starts_with:http://,https://|max:500',
                'logo_height' => 'nullable|integer|min:20|max:90',
                'footer_logo' => 'nullable|url|starts_with:http://,https://|max:500',
                'footer_logo_height' => 'nullable|integer|min:16|max:60',
                'footer_web_url' => 'nullable|url|starts_with:http://,https://|max:255',
                'footer_web_address' => 'nullable|string|max:100',
                'footer_facebook_url' => 'nullable|url|starts_with:http://,https://|max:255',
                'footer_facebook_name' => 'nullable|string|max:100',
                'footer_instagram_url' => 'nullable|url|starts_with:http://,https://|max:255',
                'footer_instagram_name' => 'nullable|string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors'  => $validator->errors(),
                ], 422);
            }

            $subscribe = new SubscribeLog();
            $subscribe->platform = $request->platform;
            $subscribe->email = $request->email;
            $subscribe->note = $request->has('note') ? $request->note : NULL;
            $subscribe->type = $request->has('type') ? $request->type : NULL;
            $subscribe->team_store_id = $request->has('team_store_id') ? $request->team_store_id : NULL;

            $subscribe->parent_name = $request->has('parent_name') && !empty($request->parent_name) ? $request->parent_name : NULL;
            $subscribe->parent_cell = $request->has('parent_cell') && !empty($request->parent_cell) ? $request->parent_cell : NULL;
            $subscribe->player_name = $request->has('player_name') && !empty($request->player_name) ? $request->player_name : NULL;
            $subscribe->player_grade = $request->has('player_grade') && !empty($request->player_grade) ? $request->player_grade : NULL;
            $subscribe->player_rec = $request->has('player_rec') && !empty($request->player_rec) ? $request->player_rec : NULL;
            $subscribe->player_position = $request->has('player_position') && !empty($request->player_position) ? $request->player_position : NULL;
            $subscribe->player_years = $request->has('player_years') && !empty($request->player_years) ? $request->player_years : NULL;
            $subscribe->player_high_school = $request->has('player_high_school') && !empty($request->player_high_school) ? $request->player_high_school : NULL;
            $subscribe->player_youth_rec = $request->has('player_youth_rec') && !empty($request->player_youth_rec) ? $request->player_youth_rec   : NULL;
            $subscribe->player_club = $request->has('player_club') && !empty($request->player_club) ? $request->player_club : NULL;
            $subscribe->other_comments = $request->has('other_comments') && !empty($request->other_comments) ? $request->other_comments : NULL;

            $logo = $request->filled('logo') ? $request->logo : NULL;
            $logo_height = $request->filled('logo_height') ? (int) $request->logo_height : NULL;

            $footer_logo = $request->filled('footer_logo') ? $request->footer_logo : NULL;
            $footer_logo_height = $request->filled('footer_logo_height') ? (int) $request->footer_logo_height : NULL;

            $footer_web_url = $request->filled('footer_web_url') ? $request->footer_web_url : NULL;
            $footer_web_address = $request->filled('footer_web_address') ? $request->footer_web_address : NULL;

            $footer_facebook_url = $request->filled('footer_facebook_url') ? $request->footer_facebook_url : NULL;
            $footer_facebook_name = $request->filled('footer_facebook_name') ? $request->footer_facebook_name : NULL;

            $footer_instagram_url = $request->filled('footer_instagram_url') ? $request->footer_instagram_url : NULL;
            $footer_instagram_name = $request->filled('footer_instagram_name') ? $request->footer_instagram_name : NULL;

            $subscribe->save();


            try {
                $storeUrl = null;
                if (!empty($subscribe->team_store_id)) {
                    $storeUrl = route('store.overview', ['id' => $subscribe->team_store_id]);
                }

                $sent = app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_subscriber_notification', [
                    'data'                  => $subscribe,
                    'store_url'             => $storeUrl,
                    'logo'                  => $logo,
                    'logo_height'           => $logo_height,
                    'footer_logo'           => $footer_logo,
                    'footer_logo_height'    => $footer_logo_height,
                    'footer_web_url'        => $footer_web_url,
                    'footer_web_address'    => $footer_web_address,
                    'footer_facebook_url'   => $footer_facebook_url,
                    'footer_facebook_name'  => $footer_facebook_name,
                    'footer_instagram_url'  => $footer_instagram_url,
                    'footer_instagram_name' => $footer_instagram_name,
                ]);

                if (!$sent) {
                    logger()->warning('Subscriber notification email was not sent.', [
                        'subscribe_id' => $subscribe->id,
                    ]);
                }
            } catch (\Throwable $mailError) {
                logger()->error('Subscriber notification email failed: ' . $mailError->getMessage(), [
                    'subscribe_id' => $subscribe->id,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Subscription saved successfully.',
                'data' => $subscribe,
            ], 201);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
