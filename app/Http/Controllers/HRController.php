<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DateTimeZone;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\LeaveType;
use App\Models\LeaveTypes;
use App\Models\LeaveGroup;
use App\Models\UserFile;
use App\Models\UserGroup;
use App\Models\UserLayout;
use App\Models\UserRole;
use App\Models\ColumnLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HRController extends Controller
{
    public function Employee_Managment(Request $request)
    {
        $users = User::with('roles', 'userGroupDetails')->orderBy('name')->where('active', 1)->get();

        // $userRoles = UserRole::orderBy('user_role_name')->get();
        $userRoles = Role::orderBy('name')->where('active', 1)->get();

        $userGroups = UserGroup::orderBy('user_group_name')->get();

        $userLayout = UserLayout::where('user_id', Auth::user()->id)->first();

        $columnLayout = ColumnLayout::where('interface_id', 12)->where('user_id', Auth::user()->id)->first();

        return view('pages.hr_module.Employee_Managment.index', ['users' => $users, 'userLayout' => $userLayout, 'userRoles' => $userRoles, 'userGroups' => $userGroups, 'columnLayout' => $columnLayout]);
    }

    public function Attendance_Managment(Request $request)
    {
        return view('pages.hr_module.Attendance_Managment.index');
    }

    public function Leave_managment(Request $request)
    {
        return view('pages.hr_module.Leave_Managment.index');
    }

    // old leave types view (leave group old)
    /* public function Leave_types(Request $request)
    {
        $leaveTypes = LeaveType::where('active', 1)->get();
        return view('pages.hr_module.Leave_Managment.leave_types', compact('leaveTypes'));
    }*/

    // new leave type view
    public function Leave_types(Request $request)
    {
        $leaveTypes = LeaveType::where('active', 1)->get();
        return view('pages.hr_module.Leave_Managment.leave_type', compact('leaveTypes'));
    }

    // new leave group view
    public function Leave_groups()
    {
        $leaveGroups = LeaveGroup::with('leaveGroupItems.leaveType')->where('active', 1)->get();
        $masterTypes = LeaveType::where('active', 1)->get();
        return view('pages.hr_module.Leave_Managment.leave_groups', compact('leaveGroups', 'masterTypes'));
    }

    // hr dashboard view
    public function HR_dashboard(Request $request)
    {
        return view('pages.hr_module.Dashboard.dashboard');
    }

    // get leave balance for a user
    public function getLeaveBalance($userId)
    {
        $user = \App\Models\User::with([
            'userDetails.leaveType.leaveGroupItems.leaveType'
        ])->findOrFail($userId);

        $leaveGroup = optional($user->userDetails)->leaveType;

        if (!$leaveGroup) {
            return response()->json([
                'success' => false,
                'message' => 'No leave group assigned to this user.'
            ]);
        }

        $balances = [];

        foreach ($leaveGroup->leaveGroupItems as $item) {
            $leaveTypeName = $item->leaveType->name;  // e.g. "Annual", "Medical"
            $allocated     = (float) $item->leave_days;

            // Fetch all approved leaves for this user matching this leave type name
            // user_leaves.leave_type stores lowercase e.g. "annual"
            $approvedLeaves = \App\Models\UserLeave::where('user_id', $userId)
                ->where('status', 1)
                ->where('active', 1)
                ->whereRaw('LOWER(leave_type) = ?', [strtolower($leaveTypeName)])
                ->get();

            $used = $approvedLeaves->sum(function ($leave) {
                if ($leave->type == 0) return 0.5;   // half day
                if ($leave->type == 1) return 1;      // one day
                if ($leave->type == 3) return 0;      // short leave — no day deduction
                if ($leave->type == 2) {              // multiple days
                    $start = \Carbon\Carbon::parse($leave->start_date);
                    $end   = \Carbon\Carbon::parse($leave->end_date);
                    return $start->diffInDays($end) + 1;
                }
                return 0;
            });

            $balances[] = [
                'leave_type_name' => $leaveTypeName,
                'allocated'       => $allocated,
                'used'            => $used,
                'remaining'       => max(0, $allocated - $used),
            ];
        }

        return response()->json([
            'success'    => true,
            'user_id'    => $userId,
            'user_name'  => $user->name,
            'group_name' => $leaveGroup->name,
            'balances'   => $balances,
        ]);
    }

    public function employee_summary_table_data(Request $request)
    {
        // $users = User::get();
        $users = User::with('userDetails')->orderBy('active', 'desc')->get();
        return response()->json($users);
    }
    public function employee_view($user_id)
    {
        $user = User::findOrFail($user_id);
        return view('pages.hr_module.Employee_Managment.view', ['user' => $user]);
    }
    public function employee_view_project($user_id) {
        $user = User::findOrFail($user_id);
        return view('pages.hr_module.Employee_Managment.view_employee_profile_project', ['user' => $user]);
    }
    public function employee_edit($user_id)
    {
        $user = User::findOrFail($user_id);
        // $leaveTypes = LeaveType::where('active', 1)->get();
        $leaveGroups = LeaveGroup::where('active', 1)->get();
        $nationalities = [
            'Afghan',
            'Albanian',
            'Algerian',
            'American',
            'Andorran',
            'Angolan',
            'Argentine',
            'Armenian',
            'Australian',
            'Austrian',
            'Azerbaijani',
            'Bahamian',
            'Bahraini',
            'Bangladeshi',
            'Barbadian',
            'Belarusian',
            'Belgian',
            'Belizean',
            'Beninese',
            'Bhutanese',
            'Bolivian',
            'Bosnian',
            'Botswanan',
            'Brazilian',
            'British',
            'Bulgarian',
            'Burkinabe',
            'Burmese',
            'Burundian',
            'Cambodian',
            'Cameroonian',
            'Canadian',
            'Cape Verdean',
            'Chadian',
            'Chilean',
            'Chinese',
            'Colombian',
            'Comoran',
            'Congolese',
            'Costa Rican',
            'Croatian',
            'Cuban',
            'Cypriot',
            'Czech',
            'Danish',
            'Djiboutian',
            'Dominican',
            'Dutch',
            'Ecuadorian',
            'Egyptian',
            'Emirati',
            'Equatorial Guinean',
            'Eritrean',
            'Estonian',
            'Ethiopian',
            'Fijian',
            'Filipino',
            'Finnish',
            'French',
            'Gabonese',
            'Gambian',
            'Georgian',
            'German',
            'Ghanaian',
            'Greek',
            'Grenadian',
            'Guatemalan',
            'Guinean',
            'Guyanese',
            'Haitian',
            'Honduran',
            'Hungarian',
            'Icelander',
            'Indian',
            'Indonesian',
            'Iranian',
            'Iraqi',
            'Irish',
            'Israeli',
            'Italian',
            'Jamaican',
            'Japanese',
            'Jordanian',
            'Kazakh',
            'Kenyan',
            'Kuwaiti',
            'Lao',
            'Latvian',
            'Lebanese',
            'Liberian',
            'Libyan',
            'Lithuanian',
            'Luxembourger',
            'Macedonian',
            'Malagasy',
            'Malawian',
            'Malaysian',
            'Malian',
            'Maltese',
            'Mauritanian',
            'Mauritian',
            'Mexican',
            'Moldovan',
            'Monacan',
            'Mongolian',
            'Montenegrin',
            'Moroccan',
            'Mozambican',
            'Namibian',
            'Nepalese',
            'New Zealander',
            'Nicaraguan',
            'Nigerian',
            'Norwegian',
            'Omani',
            'Pakistani',
            'Palestinian',
            'Panamanian',
            'Papua New Guinean',
            'Paraguayan',
            'Peruvian',
            'Polish',
            'Portuguese',
            'Qatari',
            'Romanian',
            'Russian',
            'Rwandan',
            'Salvadoran',
            'Samoan',
            'Saudi',
            'Scottish',
            'Senegalese',
            'Serbian',
            'Sierra Leonean',
            'Singaporean',
            'Slovak',
            'Slovenian',
            'Somali',
            'South African',
            'South Korean',
            'Spanish',
            'Sri Lankan',
            'Sudanese',
            'Surinamese',
            'Swazi',
            'Swedish',
            'Swiss',
            'Syrian',
            'Taiwanese',
            'Tajik',
            'Tanzanian',
            'Thai',
            'Togolese',
            'Tunisian',
            'Turkish',
            'Turkmen',
            'Ugandan',
            'Ukrainian',
            'Uruguayan',
            'Uzbek',
            'Venezuelan',
            'Vietnamese',
            'Welsh',
            'Yemeni',
            'Zambian',
            'Zimbabwean'
        ];
        // List of Languages
        $languages = [
            'English',
            'Spanish',
            'French',
            'German',
            'Italian',
            'Portuguese',
            'Russian',
            'Chinese',
            'Japanese',
            'Korean',
            'Hindi',
            'Arabic',
            'Turkish',
            'Dutch',
            'Greek',
            'Polish',
            'Hebrew',
            'Swedish',
            'Norwegian',
            'Danish',
            'Finnish',
            'Hungarian',
            'Czech',
            'Slovak',
            'Ukrainian',
            'Malay',
            'Bengali',
            'Tamil',
            'Telugu',
            'Urdu',
            'Persian',
            'Thai',
            'Indonesian',
            'Filipino',
            'Vietnamese',
            'Romanian',
            'Swahili',
            'Sinhala'
        ];
        // Country List with Codes
        $countries = [
            ['name' => 'Afghanistan', 'code' => 'AF'],
            ['name' => 'Albania', 'code' => 'AL'],
            ['name' => 'Algeria', 'code' => 'DZ'],
            ['name' => 'Andorra', 'code' => 'AD'],
            ['name' => 'Angola', 'code' => 'AO'],
            ['name' => 'Argentina', 'code' => 'AR'],
            ['name' => 'Australia', 'code' => 'AU'],
            ['name' => 'Austria', 'code' => 'AT'],
            ['name' => 'Bangladesh', 'code' => 'BD'],
            ['name' => 'Belgium', 'code' => 'BE'],
            ['name' => 'Brazil', 'code' => 'BR'],
            ['name' => 'Canada', 'code' => 'CA'],
            ['name' => 'China', 'code' => 'CN'],
            ['name' => 'Denmark', 'code' => 'DK'],
            ['name' => 'Egypt', 'code' => 'EG'],
            ['name' => 'Finland', 'code' => 'FI'],
            ['name' => 'France', 'code' => 'FR'],
            ['name' => 'Germany', 'code' => 'DE'],
            ['name' => 'India', 'code' => 'IN'],
            ['name' => 'Indonesia', 'code' => 'ID'],
            ['name' => 'Italy', 'code' => 'IT'],
            ['name' => 'Japan', 'code' => 'JP'],
            ['name' => 'Malaysia', 'code' => 'MY'],
            ['name' => 'Mexico', 'code' => 'MX'],
            ['name' => 'Netherlands', 'code' => 'NL'],
            ['name' => 'New Zealand', 'code' => 'NZ'],
            ['name' => 'Nigeria', 'code' => 'NG'],
            ['name' => 'Norway', 'code' => 'NO'],
            ['name' => 'Pakistan', 'code' => 'PK'],
            ['name' => 'Philippines', 'code' => 'PH'],
            ['name' => 'Portugal', 'code' => 'PT'],
            ['name' => 'Russia', 'code' => 'RU'],
            ['name' => 'Saudi Arabia', 'code' => 'SA'],
            ['name' => 'South Africa', 'code' => 'ZA'],
            ['name' => 'South Korea', 'code' => 'KR'],
            ['name' => 'Spain', 'code' => 'ES'],
            ['name' => 'Sri Lanka', 'code' => 'LK'],
            ['name' => 'Sweden', 'code' => 'SE'],
            ['name' => 'Switzerland', 'code' => 'CH'],
            ['name' => 'Thailand', 'code' => 'TH'],
            ['name' => 'Turkey', 'code' => 'TR'],
            ['name' => 'United Arab Emirates', 'code' => 'AE'],
            ['name' => 'United Kingdom', 'code' => 'GB'],
            ['name' => 'United States', 'code' => 'US'],
            ['name' => 'Vietnam', 'code' => 'VN'],
        ];
        // departments list
        $departmentsNames = ['Admin', 'Marketing', 'Design', 'Management', 'Development', 'Production', 'Accounts', 'HR'];

        $timezoneset = DateTimeZone::listIdentifiers();
        if ($user->userDetails->country) {

            $timezoneset = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $user->userDetails->country);
        }

        // $leaveGroups = LeaveGroup::where('active', 1)->get()
        //     ->map(fn($lt) => ['id' => $lt->id, 'name' => $lt->name])
        //     ->toArray();

        // Get saved languages (assuming stored as JSON array in DB)
        $savedLanguages = json_decode($user->userDetails->Languages ?? '[]', true);
        return view('pages.hr_module.Employee_Managment.edit', compact('user', 'nationalities', 'languages', 'savedLanguages', 'countries', 'timezoneset', 'leaveGroups', 'departmentsNames'));
    }

    private $allowedDocTypes = [
        'verificationDocument',
        'appointmentLetterDocument',
        'contractDocument',
        'ndaDocument',
    ];

    public function uploadFiles(Request $request)
    {
        $userId  = $request->input('user_id');
        $docType = $request->input('doc_type', 'verificationDocument');

        if (!$userId) {
            return response()->json(["error" => "User ID is required"], 400);
        }
        if (!in_array($docType, $this->allowedDocTypes)) {
            return response()->json(["error" => "Invalid document type"], 400);
        }

        $uploadedFiles = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName   = time() . '_' . $file->getClientOriginalName();
                $folderPath = "uploads/user/user_{$userId}/{$docType}";

                Storage::disk('public')->makeDirectory($folderPath);

                $filePath = $file->storeAs($folderPath, $fileName, 'public');

                $userFile = UserFile::create([
                    'user_id'   => $userId,
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                    'doc_type'  => $docType,
                ]);

                $fullPath  = storage_path("app/public/{$filePath}");
                $mimeType  = mime_content_type($fullPath);
                $encoded   = base64_encode(file_get_contents($fullPath));

                $uploadedFiles[] = [
                    "id"      => $userFile->id,
                    "name"    => $userFile->file_name,
                    "size"    => round(filesize($fullPath) / 1024, 2) . " KB",
                    "content" => "data:$mimeType;base64,$encoded",
                ];
            }
        }

        return response()->json(["files" => $uploadedFiles]);
    }

    public function getUserFiles($userId, $docType)
    {
        if (!in_array($docType, $this->allowedDocTypes)) {
            return response()->json(["error" => "Invalid document type"], 400);
        }

        $files = UserFile::where('user_id', $userId)
            ->where('doc_type', $docType)
            ->get();

        $fileData = $files->map(function ($file) {
            $filePath = storage_path("app/public/{$file->file_path}");
            if (!file_exists($filePath)) return null;

            $mimeType = mime_content_type($filePath);
            $encoded  = base64_encode(file_get_contents($filePath));

            return [
                "id"      => $file->id,
                "name"    => $file->file_name,
                "size"    => round(filesize($filePath) / 1024, 2) . " KB",
                "content" => "data:$mimeType;base64,$encoded",
            ];
        })->filter()->values();

        return response()->json(["files" => $fileData]);
    }

    public function deleteFile(Request $request)
    {
        $file = UserFile::find($request->input('id'));

        if (!$file) {
            return response()->json(["success" => false, "message" => "File not found"], 404);
        }

        if (Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }

        $file->delete();

        return response()->json(["success" => true]);
    }

    public function get_groups(Request $request)
    {
        $user_Id = $request->input('userId');
        $user = User::findOrFail($user_Id);
        // $userRoles = $user->getRoleNames(); // Returns an array of role names
        $userRoles = $user->roles()->select('id', 'name')->get();
        $userRoleNames = $userRoles->pluck('name')->toArray();
        $userPermissions = $user->getAllPermissions(); // Returns a collection of permissions

        // Get all active roles except the ones the user already has
        $Roles = Role::orderBy('name')
            ->where('active', 1)
            ->whereNotIn('name', $userRoleNames) // Exclude assigned roles
            ->get();
        // dd($userRoles);
        return response()->json([
            'success' => true,
            'groups' => $Roles, // List of all available groups
            'userGroups' => $userRoles, // Groups assigned to the user
            'permissions' => $userPermissions->pluck('name')->toArray() // Permissions assigned to the user
        ]);
    }
}
