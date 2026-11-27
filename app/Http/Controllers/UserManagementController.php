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
use App\Services\Users\AccountProtection;
use App\Services\Users\ProfilePictureService;
use App\Http\Requests\Users\StoreEmployeeRequest;
use Illuminate\Support\Facades\DB;

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

    public function create(\App\Http\Requests\Users\StoreUserRequest $request, \App\Services\Users\ProfilePictureService $pictures)
    {
        $data = $request->validated();
        $roles = Role::whereIn('id', $data['new_user_role_id'])->get();
        app(AccountProtection::class)->assertCanAssign($request->user(), $roles);
        $path = $request->hasFile('new_profile_pic')
            ? $pictures->upload($request->file('new_profile_pic'))
            : 'assets/img/organization/default.png';

        \Illuminate\Support\Facades\DB::transaction(function () use ($data, $roles, $path): void {
            $user = new User();
            $user->name = $data['new_name'];
            $user->email = $data['new_email'];
            $user->password = Hash::make($data['new_password']);
            $user->role_id = json_encode($data['new_user_role_id']);
            $user->user_group_id = $data['new_user_group_id'];
            $user->profile_pic = $path;
            $user->active = 1;
            $user->save();
            $user->assignRole($roles);
        });

        return redirect()->back()->withSuccess('User Saved Successfully!');
    }

    public function uploadPofilePicture(Request $request)
    {
        return app(\App\Services\Users\ProfilePictureService::class)->upload($request->file('new_profile_pic'));
    }

    public function sortByAlphabet($id)
    {
        $users = User::with('userRoleDetails', 'userGroupDetails')->where('name', 'LIKE', $id . '%')->where('active', 1)->orderBy('name')->get();
        return json_encode($users);
    }

    public function delete($id)
    {
        $this->authorize('delete users');
        $user = User::findOrFail($id);
        app(AccountProtection::class)->assertCanDeactivate(auth()->user(), $user);
        $user->active = 0;
        $user->update();

        return redirect()->route('users')->withSuccess('User Deleted Successfully!');
    }

    public function edit($userId)
    {
        $this->authorize('edit users');
        $user = User::findOrFail($userId);
        return json_encode($user);
    }

    public function update(\App\Http\Requests\Users\UpdateUserRequest $request, \App\Services\Users\ProfilePictureService $pictures)
    {
        $data = $request->validated();
        $user = User::findOrFail($data['user_id']);
        $roles = Role::whereIn('id', $data['edit_user_role_id'])->get();
        $protection = app(AccountProtection::class);
        $protection->assertCanEdit($request->user(), $user);
        $protection->assertCanAssign($request->user(), $roles);
        abort_if($protection->privileged($user) && ! $roles->contains(fn ($role) => $role->name === 'Super Admin') && $user->hasRole('Super Admin'), 403);
        $path = $request->hasFile('edit_profile_pic')
            ? $pictures->upload($request->file('edit_profile_pic'))
            : $user->profile_pic;

        \Illuminate\Support\Facades\DB::transaction(function () use ($data, $user, $roles, $path): void {
            $user->name = $data['edit_name'];
            $user->role_id = json_encode($data['edit_user_role_id']);
            $user->user_group_id = $data['edit_user_group_id'];
            $user->profile_pic = $path;

            if (($data['change_login_details'] ?? null) === 'on') {
                $user->email = $data['edit_email'];
                if (! empty($data['edit_password'])) {
                    $user->password = Hash::make($data['edit_password']);
                }
            }

            $user->save();
            $user->syncRoles($roles);
        });

        return redirect()->route('users')->withSuccess('Users Updated Successfully!');
    }

    public function updatePofilePicture(Request $request)
    {
        return app(\App\Services\Users\ProfilePictureService::class)->upload($request->file('edit_profile_pic'));
    }

    public function layout(Request $request)
    {
        if (UserLayout::where('user_id', Auth::user()->id)->first()) {
            $userLayout = UserLayout::where('user_id', Auth::id())->findOrFail($request->layout_id);
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
        $this->authorize('add users');
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

        $nationalities = config('employee_reference.nationalities');

        $languages = config('employee_reference.languages');

        $countries = config('employee_reference.countries');

        $departmentsNames = config('employee_reference.departments');

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
    public function employee_store(StoreEmployeeRequest $request, ProfilePictureService $pictures)
    {
        $roles = Role::whereIn('id', $request->input('user_roles') ?? [])->get();
        app(AccountProtection::class)->assertCanAssign($request->user(), $roles);

        $profilePicPath = $request->hasFile('profile_picture')
            ? $pictures->upload($request->file('profile_picture'))
            : 'assets/img/user/default.png';

        DB::transaction(function () use ($request, $roles, $profilePicPath): void {
            $user = new User();
            $user->name = trim($request->first_name.' '.$request->last_name);
            $user->email = $request->login_email;
            $user->password = Hash::make($request->password);
            $user->role_id = json_encode($request->input('user_roles') ?? []);
            $user->profile_pic = $profilePicPath;
            $user->active = 1;
            $user->save();
            $user->syncRoles($roles);

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
            'leavetype_id'      => $request->leave_group_id
                ?: LeaveGroup::where('active', 1)
                ->orderBy('id')
                ->value('id'),
        ]);

        });

        return redirect()->route('HR.Employee_Managment')
            ->with('success', 'Employee created successfully.');
    }
}
