<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ColumnLayout;
use App\Models\User;
use App\Models\UserGroup;
use App\Models\UserLayout;
use App\Models\UserRole;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use DateTimeZone;
use DateTime;
use App\Models\LeaveGroup;

class UserManagementController extends Controller
{
    public function index()
    {
        if (auth()->user()->can('manage user')) {
            $users = User::with('roles', 'userGroupDetails')->orderBy('name')->where('active', 1)->get();

            // $userRoles = UserRole::orderBy('user_role_name')->get();
            $userRoles = Role::orderBy('name')->where('active', 1)->get();

            $userGroups = UserGroup::orderBy('user_group_name')->get();

            $userLayout = UserLayout::where('user_id', Auth::user()->id)->first();

            $columnLayout = ColumnLayout::where('interface_id', 12)->where('user_id', Auth::user()->id)->first();

            return view('pages.users.users.index', ['users' => $users, 'userLayout' => $userLayout, 'userRoles' => $userRoles, 'userGroups' => $userGroups, 'columnLayout' => $columnLayout]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function create(Request $request)
    {
        // dd(json_encode($request->new_user_role_id));
        if ($request->has('new_profile_pic')) {
            $logoImagePath = self::uploadPofilePicture($request);
        } else {
            $logoImagePath = "assets/img/organization/default.png";
        }
        $mail_status = User::where('email', $request->new_email)->first();
        if ($mail_status != null) {
            return redirect()->back()->withError('This email address already registered! | email: ' . $request->new_email);
        }
        $user = new User();
        $user->name = $request->new_name;
        $user->email = $request->new_email;
        $user->password = Hash::make($request->new_password);
        // $user->role_id = $request->new_user_role_id;
        $user->role_id = json_encode($request->new_user_role_id);
        $user->user_group_id = $request->new_user_group_id;
        $user->profile_pic = $logoImagePath;
        $user->active = 1;
        $user->save();

        // $role = Role::find($request->new_user_role_id);
        $role = Role::whereIn('id', $request->new_user_role_id)->get();
        $user->assignRole($role);

        return redirect()->back()->withSuccess('User Saved Successfully!');
    }

    public function uploadPofilePicture(Request $request)
    {
        $file = $request->file('new_profile_pic');

        $destinationPath = 'assets/img/user';

        $file->move($destinationPath, $file->getClientOriginalName());

        return $destinationPath . '/' . $file->getClientOriginalName();
    }

    public function sortByAlphabet($id)
    {
        $users = User::with('userRoleDetails', 'userGroupDetails')->where('name', 'LIKE', $id . '%')->where('active', 1)->orderBy('name')->get();
        return json_encode($users);
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->active = 0;
        $user->update();

        return redirect()->route('users')->withSuccess('User Deleted Successfully!');
    }

    public function edit($userId)
    {
        $user = User::find($userId);
        return json_encode($user);
    }

    public function update(Request $request)
    {
        if ($request->has('edit_profile_pic')) {
            $logoImagePath = self::updatePofilePicture($request);
        } else {
            $logoImagePath = $request->edit_old_profile_pic;
        }

        $user = User::find($request->user_id);
        $user->name = $request->edit_name;
        //        $user->email = $request->edit_email;
        $user->role_id = json_encode($request->edit_user_role_id);
        $user->user_group_id = $request->edit_user_group_id;
        $user->profile_pic = $logoImagePath;

        //set username password
        if (isset($request->change_login_details) && $request->change_login_details == 'on') {
            $mail_status = User::where('email', $request->edit_email)->where('id', '!=', $request->user_id)->first();
            if ($mail_status != null) {
                return redirect()->back()->withError('This email address already registered! | email: ' . $request->edit_email);
            }
            if (isset($request->edit_password) && isset($request->edit_conform_password) && $request->edit_password !== $request->edit_conform_password) {
                return redirect()->back()->withError('Password conformation does not matched!');
            }
            $user->email = $request->edit_email;
            $user->password = isset($request->edit_password) ? Hash::make($request->edit_password) : $user->password;
        }

        $user->update();

        $role = Role::whereIn('id', $request->edit_user_role_id)->get();
        // $role = Role::find($request->edit_user_role_id);
        $user->syncRoles($role);

        return redirect()->route('users')->withSuccess('Users Updated Successfully!');
    }

    public function updatePofilePicture(Request $request)
    {
        $file = $request->file('edit_profile_pic');

        $destinationPath = 'assets/img/user';

        $file->move($destinationPath, $file->getClientOriginalName());

        return $destinationPath . '/' . $file->getClientOriginalName();
    }

    public function layout(Request $request)
    {
        if (UserLayout::where('user_id', Auth::user()->id)->first()) {
            $userLayout = UserLayout::find($request->layout_id);
            $userLayout->profile_pic = $request->profile_pic ?? NULL;
            $userLayout->name = $request->name ?? NULL;
            $userLayout->email = $request->email ?? NULL;
            $userLayout->user_role_name = $request->user_role_name ?? NULL;
            $userLayout->user_group_name = $request->user_group_name ?? NULL;
            $userLayout->action = $request->action ?? NULL;
            $userLayout->created = $request->created_at ?? NULL;
            $userLayout->updated = $request->updated_at ?? NULL;
            $userLayout->m_number = $request->mobile ?? NULL;
            $userLayout->department = $request->department ?? NULL;
            $userLayout->employment_status = $request->employment_status ?? NULL;
            $userLayout->job_title = $request->job_title ?? NULL;
            $userLayout->w_number = $request->w_number ?? NULL;
            $userLayout->address = $request->address ?? NULL;
            $userLayout->about = $request->about ?? NULL;
            $userLayout->city = $request->city ?? NULL;
            $userLayout->country = $request->country ?? NULL;
            $userLayout->postal_code = $request->postal_code ?? NULL;
            $userLayout->timezone = $request->timezone ?? NULL;
            $userLayout->joined_date = $request->joined_date ?? NULL;
            $userLayout->marital_status = $request->marital_status ?? NULL;
            $userLayout->gender = $request->gender ?? NULL;
            $userLayout->nationality = $request->nationality ?? NULL;
            $userLayout->languages = $request->languages ?? NULL;
            $userLayout->private_email = $request->private_email ?? NULL;
            $userLayout->update();

            $successMsg = "Updated";
        } else {
            $userLayout = new UserLayout();
            $userLayout->user_id = Auth::user()->id;
            $userLayout->profile_pic = 1;
            $userLayout->name = 1;
            $userLayout->email = 1;
            $userLayout->user_role_name = 1;
            $userLayout->user_group_name = 1;
            $userLayout->action = 1;
            $userLayout->created = $request->created_at;
            $userLayout->updated = $request->updated_at;
            $userLayout->m_number = $request->mobile;
            $userLayout->department = $request->department;
            $userLayout->employment_status = $request->employment_status;
            $userLayout->job_title = $request->job_title;
            $userLayout->w_number = $request->w_number;
            $userLayout->address = $request->address;
            $userLayout->about = $request->about;
            $userLayout->city = $request->city;
            $userLayout->country = $request->country;
            $userLayout->postal_code = $request->postal_code;
            $userLayout->timezone = $request->timezone;
            $userLayout->joined_date = $request->joined_date;
            $userLayout->marital_status = $request->marital_status;
            $userLayout->gender = $request->gender;
            $userLayout->nationality = $request->nationality;
            $userLayout->languages = $request->languages;
            $userLayout->private_email = $request->private_email;
            $userLayout->save();

            $successMsg = "Saved";
        }

        return json_encode($successMsg);
    }

    // SHOW PERMISSION PAGE
    public function employee_permission($user_id)
    {
        $user = \App\Models\User::findOrFail($user_id);
        return view('pages.hr_module.Employee_Managment.permission', compact('user'));
    }

    //  SHOW CREATE FORM 
    public function newemployee()
    {
        // $timezoneset = DateTimeZone::listIdentifiers();
        $timezoneset = collect(DateTimeZone::listIdentifiers())->mapWithKeys(function ($tz) {
            $offset = (new DateTimeZone($tz))->getOffset(new DateTime('now', new DateTimeZone('UTC')));
            $hours   = intdiv(abs($offset), 3600);
            $minutes = (abs($offset) % 3600) / 60;
            $sign    = $offset >= 0 ? '+' : '-';
            $label   = sprintf('%s (UTC%s%02d:%02d)', $tz, $sign, $hours, $minutes);
            return [$tz => $label];
        })->toArray();

        $userRoles = Role::orderBy('name')->where('active', 1)->get();

        $leaveGroups = LeaveGroup::where('active', 1)->get()
            ->map(fn($lt) => ['id' => $lt->id, 'name' => $lt->name])
            ->toArray();

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
            'Zimbabwean',
        ];

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

        $countries = [
            ['name' => 'Afghanistan',            'code' => 'AF'],
            ['name' => 'Albania',                'code' => 'AL'],
            ['name' => 'Algeria',                'code' => 'DZ'],
            ['name' => 'Andorra',                'code' => 'AD'],
            ['name' => 'Angola',                 'code' => 'AO'],
            ['name' => 'Argentina',              'code' => 'AR'],
            ['name' => 'Australia',              'code' => 'AU'],
            ['name' => 'Austria',                'code' => 'AT'],
            ['name' => 'Bangladesh',             'code' => 'BD'],
            ['name' => 'Belgium',                'code' => 'BE'],
            ['name' => 'Brazil',                 'code' => 'BR'],
            ['name' => 'Canada',                 'code' => 'CA'],
            ['name' => 'China',                  'code' => 'CN'],
            ['name' => 'Denmark',                'code' => 'DK'],
            ['name' => 'Egypt',                  'code' => 'EG'],
            ['name' => 'Finland',                'code' => 'FI'],
            ['name' => 'France',                 'code' => 'FR'],
            ['name' => 'Germany',                'code' => 'DE'],
            ['name' => 'India',                  'code' => 'IN'],
            ['name' => 'Indonesia',              'code' => 'ID'],
            ['name' => 'Italy',                  'code' => 'IT'],
            ['name' => 'Japan',                  'code' => 'JP'],
            ['name' => 'Malaysia',               'code' => 'MY'],
            ['name' => 'Mexico',                 'code' => 'MX'],
            ['name' => 'Netherlands',            'code' => 'NL'],
            ['name' => 'New Zealand',            'code' => 'NZ'],
            ['name' => 'Nigeria',                'code' => 'NG'],
            ['name' => 'Norway',                 'code' => 'NO'],
            ['name' => 'Pakistan',               'code' => 'PK'],
            ['name' => 'Philippines',            'code' => 'PH'],
            ['name' => 'Portugal',               'code' => 'PT'],
            ['name' => 'Russia',                 'code' => 'RU'],
            ['name' => 'Saudi Arabia',           'code' => 'SA'],
            ['name' => 'South Africa',           'code' => 'ZA'],
            ['name' => 'South Korea',            'code' => 'KR'],
            ['name' => 'Spain',                  'code' => 'ES'],
            ['name' => 'Sri Lanka',              'code' => 'LK'],
            ['name' => 'Sweden',                 'code' => 'SE'],
            ['name' => 'Switzerland',            'code' => 'CH'],
            ['name' => 'Thailand',               'code' => 'TH'],
            ['name' => 'Turkey',                 'code' => 'TR'],
            ['name' => 'United Arab Emirates',   'code' => 'AE'],
            ['name' => 'United Kingdom',         'code' => 'GB'],
            ['name' => 'United States',          'code' => 'US'],
            ['name' => 'Vietnam',                'code' => 'VN'],
        ];

        $departmentsNames = ['Admin', 'Marketing', 'Design', 'Management', 'Development', 'Production', 'Accounts', 'HR'];

        return view('pages.users.users.createnew', compact(
            'timezoneset',
            'userRoles',
            'leaveGroups',
            'nationalities',
            'languages',
            'countries',
            'departmentsNames'
        ));
    }

    //  HANDLE CREATE FORM SUBMISSION
    public function employee_store(Request $request)
    {
        // dd($request->all());

        // ── 1. Validate ─────────────────────────────────────────────
        $request->validate([
            'first_name'            => 'required|string|max:255',
            'login_email'           => 'required|email|unique:users,email',
            'password'              => 'required|string|min:5',
            'password_confirmation' => 'required|same:password',
            'user_roles'            => 'nullable|array',
        ], [
            'login_email.unique'           => 'This email address is already registered.',
            'password_confirmation.same'   => 'Passwords do not match.',
        ]);

        // ── 2. Profile picture ───────────────────────────────────────
        $profilePicPath = 'assets/img/user/default.png';
        if ($request->hasFile('profile_picture')) {
            $file            = $request->file('profile_picture');
            $fileName        = time() . '_' . $file->getClientOriginalName();
            $destinationPath = 'assets/img/user';
            $file->move($destinationPath, $fileName);
            $profilePicPath  = $destinationPath . '/' . $fileName;
        }

        // ── 3. Create User ───────────────────────────────────────────
        // Combine first + last name — this fixes the "name cannot be null" error
        $fullName = trim($request->first_name . ' ' . $request->last_name);

        $user = User::create([
            'name'        => $fullName,
            'email'       => $request->login_email,
            'password'    => Hash::make($request->password),
            'role_id'     => json_encode($request->user_roles ?? []),
            'profile_pic' => $profilePicPath,
            'active'      => 1,
        ]);

        // ── 4. Assign Spatie roles ───────────────────────────────────
        if ($request->filled('user_roles')) {
            $roles = Role::whereIn('id', $request->user_roles)->get();
            $user->assignRole($roles);
        }

        // ── 5. Create UserDetails ────────────────────────────────────
        $user->userDetails()->create([
            // ── Header fields ──────────────────────────────
            'job_title'         => $request->job_title,
            'm_number'          => $request->official_phone,
            'timezone'          => $request->timezone,

            // ── Personal Details ───────────────────────────
            'dob'               => $request->dob ?: null,
            'Marital_Status'    => $request->marital_status,
            'Gender'            => $request->gender,
            'Nationality'       => $request->nationality,
            'Languages'         => $request->languages
                ? json_encode($request->languages)
                : null,

            // ── Contact Details ────────────────────────────
            'address'           => $request->address,
            'country'           => $request->country,
            'city'              => $request->city, 
            'postal_code'       => $request->postal_code,
            'Private_Email'     => $request->private_email,
            'w_number'          => $request->phone_number,

            // ── Job Details ────────────────────────────────
            'Employment_Status' => $request->employment_status,
            'joined_date'       => $request->joined_date ?: null,
            'Department'        => $request->department,
            'leavetype_id'      => $request->leave_type_id
                ?: LeaveGroup::where('active', 1)
                ->orderBy('id')
                ->value('id'),
        ]);

        return redirect()->route('HR.Employee_Managment')
            ->with('success', 'Employee created successfully.');
    }
}
