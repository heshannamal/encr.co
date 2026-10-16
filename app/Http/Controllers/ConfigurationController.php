<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use App\Models\SystemConfiguration;
use App\Models\NotificationTemplate;
use App\Models\EmailNotification;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\App;

class ConfigurationController extends Controller
{
    public function get_dashboard_data(Request $request){
        // get database name
        $currentDatabase = DB::connection()->getDatabaseName();
        $databasename = null;
        if ($currentDatabase === "encrec_test") {
            $databasename = 'testing';
        } elseif ($currentDatabase === "encrec_ec") {
            $databasename = 'live';
        } elseif ($currentDatabase === "encrec_backup") {
            $databasename = 'development';
        }else{
            $databasename = 'unavailable';
        }

        //get mode
        $currentMode = SystemConfiguration::getValue('payment_mode', 'sandbox');

        $system_notification_Counts = NotificationTemplate::selectRaw("
                            SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as active_count,
                            COUNT(*) as total_count")->first();
        $email_notification_Counts = EmailNotification::selectRaw("
                            SUM(CASE WHEN active = 1 THEN 1 ELSE 0 END) as active_count,
                            COUNT(*) as total_count")->first();

        if (App::isDownForMaintenance()) {
            $status = 'on'; // System in maintenance
        } else {
            $status = 'off'; // System live
        }
        return view('dashboards.configuration_dashboard', ['system_status' => $status,'databasename' => $databasename, 'currentMode' => $currentMode, 'system_notification_Counts' => $system_notification_Counts, 'email_notification_Counts' => $email_notification_Counts]);
    }
    public function toggleMaintenance(Request $request)
    {
        if (!Gate::check('change system mode')) {
            // User is unauthorized
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'status' => 'required|in:on,off',
            'password' => 'required',
        ]);
        $status = $request->status;
        $user = Auth::user();

        if ($user->id == 1 && Hash::check($request->password, $user->password)) {
            if ($status === 'off') {
                Artisan::call('down', [
                    '--secret' => 'verify-admin-pw' // Optional: allow access via /my-secret-url
                ]);
                return response()->json(['success' => true,'message' => 'System is under maintenance']);
            } else {
                Artisan::call('up');
                return response()->json(['success' => true,'message' => 'System is live']);
            }
        }
        return response()->json(['success' => false, 'message' => 'Incorrect password.']);

    }

    public function get_database_data(Request $request)
    {
        if (!Gate::check('view database configurations')) {
            // User is unauthorized
            abort(403, 'Unauthorized');
        }

        $live_databasename = 'encrec_ec';
        $dev_databasename = 'encrec_backup';
        $test_databasename = 'encrec_test';
        $currentDatabase = DB::connection()->getDatabaseName();

        $databasename = null;
        if ($currentDatabase === "encrec_test") {
            $databasename = 'testing';
        } elseif ($currentDatabase === "encrec_ec") {
            $databasename = 'live';
        } elseif ($currentDatabase === "encrec_backup") {
            $databasename = 'development';
        }

        return view('pages.settings.database.index', ['databasename' => $databasename, 'live_databasename' => $live_databasename, 'dev_databasename' => $dev_databasename, 'test_databasename' => $test_databasename,]);
    }


    public function change_database_data($id)
    {
         if (!Gate::check('change database configurations')) {
            // User is unauthorized
            return response()->json('Unauthorized.', 403);
        }
        if ($id) {
            switchDatabaseConnection($id);

             // Store in cache so it's available globally
            Cache::forever('selected_db', $id);

            return response()->json('Database Changed!');
        }

        return response()->json('Database Change Failed!');
    }
    public function changeDatabaseWithPassword(Request $request)
    {
        if (!Gate::check('change database configurations')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.']);
        }

        $request->validate([
            'database_name' => 'required|in:testing,live,development',
            'password' => 'required',
        ]);

        $user = Auth::user();

        if ($user->id == 1 && !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Incorrect password.']);
        }

        switchDatabaseConnection($request->database_name);
        Cache::forever('selected_db', $request->database_name);

        return response()->json(['success' => true, 'message' => 'Database changed successfully.']);
    }

    public function get_gateway_data(Request $request)
    {


        return view('pages.settings.payment_gateway.index');
    }

    public function showPaymentMode()
    {
        $currentMode = SystemConfiguration::getValue('payment_mode', 'sandbox');

        return view('pages.settings.payment_gateway.index', compact('currentMode'));
    }


    public function updatePaymentMode(Request $request)
    {
        $request->validate([
            'payment_mode' => 'required|in:sandbox,live',
            'password' => 'required'
        ]);

        $user = auth()->user();

        if ($user->id == 1 && !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password confirmation failed.'
            ], 403);
        }

        SystemConfiguration::setValue('payment_mode', $request->payment_mode);

        return response()->json(['success' => true]);
    }
    public function getFolderStructure($path = null)
    {
        $basePath = storage_path('app'); // You can change this to 'storage_path()' or 'storage_path('logs')'

        $structure = $this->scanFolder($basePath . ($path ? DIRECTORY_SEPARATOR . $path : ''), $path ?? '');

        return view('pages.settings.folder_structure.index', ['structure' => $structure]);
    }

    private function scanFolder($fullPath, $relativePath = '')
    {
        $directories = File::directories($fullPath);
        $files = File::files($fullPath); //  Only current directory

        $result = [
            'path' => $relativePath,
            'directories' => [],
            'files' => [],
        ];

        foreach ($directories as $dir) {
            $dirName = basename($dir);
            $result['directories'][] = $this->scanFolder($dir, $relativePath . '/' . $dirName);
        }

        foreach ($files as $file) {
            $result['files'][] = basename($file);
        }

        return $result;
    }


    public function openStorageFile(Request $request)
    {
        $relativePath = $request->query('path'); // Should be raw URL-decoded already by Laravel

        // Normalize path (remove leading slash if any)
        $relativePath = ltrim($relativePath, '/');

        $basePath = storage_path('app'); // or storage_path()

        $fullPath = realpath($basePath . DIRECTORY_SEPARATOR . $relativePath);

        if (!$fullPath || !str_starts_with($fullPath, realpath($basePath))) {
            abort(404, 'File not found or access denied.');
        }

        if (!file_exists($fullPath) || !is_file($fullPath)) {
            abort(404, 'File does not exist.');
        }

        $allowedExtensions = ['txt', 'log', 'json', 'php', 'md', 'html', 'xml', 'csv', 'jpeg', 'jpg', 'png', 'gif'];
        $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExtensions)) {
            abort(403, 'File type not allowed.');
        }

        // If image or binary, show as download or inline image
        if (in_array($ext, ['jpeg', 'jpg', 'png', 'gif'])) {
            return response()->file($fullPath);
        }

        // Otherwise, return as text/plain
        $content = file_get_contents($fullPath);
        return response($content)->header('Content-Type', 'text/plain');
    }


}
