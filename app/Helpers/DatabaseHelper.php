<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

if (!function_exists('switchDatabaseConnection')) {
    function switchDatabaseConnection($connectionName = null)
    {
        $connections = [
            'testing' => [
                'driver' => 'mysql',
                'host' => env('DB_HOST_TESTING', '127.0.0.1'),
                'port' => env('DB_PORT_TESTING', '3306'),


                'database' => env('DB_DATABASE_TESTING', 'encrec_test'),
                'username' => env('DB_USERNAME_TESTING', 'encrec_test'),
                'password' => env('DB_PASSWORD_TESTING', 'encrec_test'),


                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ],
            'development' => [
                'driver' => 'mysql',
                'host' => env('DB_HOST_DEV', '127.0.0.1'),
                'port' => env('DB_PORT_DEV', '3306'),


                'database' => env('DB_DATABASE_DEV', 'encrec_backup'),
                'username' => env('DB_USERNAME_DEV', 'encrec_backup'),
                'password' => env('DB_PASSWORD_DEV', 'encrec_backup'),


                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ],
            'live' => [
                'driver' => 'mysql',
                'host' => env('DB_HOST_LIVE', '127.0.0.1'),
                'port' => env('DB_PORT_LIVE', '3306'),


                'database' => env('DB_DATABASE_LIVE', 'encrec_ec'),
                'username' => env('DB_USERNAME_LIVE', 'encrec_ec'),
                'password' => env('DB_PASSWORD_LIVE', 'encrec_ec'),


                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ],
        ];

        // Fallback to default if nothing provided or cache missing
        if (!$connectionName || !isset($connections[$connectionName])) {
            // Use the default Laravel DB connection
            DB::setDefaultConnection(config('database.default'));
            return;
        }

        // Apply dynamic connection
        Config::set("database.connections.dynamic", $connections[$connectionName]);
        DB::purge('dynamic');
        DB::setDefaultConnection('dynamic');
    }
}

