<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DateTimeZone;
use Illuminate\Http\Request;
use App\Models\UserDetails;
use App\Models\User;
use App\Models\UserLeave;
use App\Models\LeaveType;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Webpatser\Countries\Countries;
use Carbon\Carbon;
use App\Services\EmailNotificationBuilderService;
use Illuminate\Support\Facades\DB;


class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     * this is user profile edit by himself
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $userInfo = Auth::user();
        $userRoles = $userInfo->roles()->select('id', 'name')->get();
        $timezoneset = DateTimeZone::listIdentifiers();
        if ($userInfo->userDetails->country) {

            $timezoneset = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $userInfo->userDetails->country);
        }
        $countries = ['AF' => 'Afghanistan', 'AX' => 'Åland Islands', 'AL' => 'Albania', 'DZ' => 'Algeria', 'AS' => 'American Samoa', 'AD' => 'Andorra', 'AO' => 'Angola', 'AI' => 'Anguilla', 'AQ' => 'Antarctica', 'AG' => 'Antigua and Barbuda', 'AR' => 'Argentina', 'AM' => 'Armenia', 'AW' => 'Aruba', 'AU' => 'Australia', 'AT' => 'Austria', 'AZ' => 'Azerbaijan', 'BS' => 'Bahamas', 'BH' => 'Bahrain', 'BD' => 'Bangladesh', 'BB' => 'Barbados', 'BY' => 'Belarus', 'BE' => 'Belgium', 'BZ' => 'Belize', 'BJ' => 'Benin', 'BM' => 'Bermuda', 'BT' => 'Bhutan', 'BO' => 'Bolivia, Plurinational State of', 'BQ' => 'Bonaire, Sint Eustatius and Saba', 'BA' => 'Bosnia and Herzegovina', 'BW' => 'Botswana', 'BV' => 'Bouvet Island', 'BR' => 'Brazil', 'IO' => 'British Indian Ocean Territory', 'BN' => 'Brunei Darussalam', 'BG' => 'Bulgaria', 'BF' => 'Burkina Faso', 'BI' => 'Burundi', 'CV' => 'Cabo Verde', 'KH' => 'Cambodia', 'CM' => 'Cameroon', 'CA' => 'Canada', 'KY' => 'Cayman Islands', 'CF' => 'Central African Republic', 'TD' => 'Chad', 'CL' => 'Chile', 'CN' => 'China', 'CX' => 'Christmas Island', 'CC' => 'Cocos (Keeling) Islands', 'CO' => 'Colombia', 'KM' => 'Comoros', 'CG' => 'Congo', 'CD' => 'Congo, Democratic Republic of the', 'CK' => 'Cook Islands', 'CR' => 'Costa Rica', 'CI' => 'Côte d\'Ivoire', 'HR' => 'Croatia', 'CU' => 'Cuba', 'CW' => 'Curaçao', 'CY' => 'Cyprus', 'CZ' => 'Czech Republic', 'DK' => 'Denmark', 'DJ' => 'Djibouti', 'DM' => 'Dominica', 'DO' => 'Dominican Republic', 'EC' => 'Ecuador', 'EG' => 'Egypt', 'SV' => 'El Salvador', 'GQ' => 'Equatorial Guinea', 'ER' => 'Eritrea', 'EE' => 'Estonia', 'ET' => 'Ethiopia', 'FK' => 'Falkland Islands (Malvinas)', 'FO' => 'Faroe Islands', 'FJ' => 'Fiji', 'FI' => 'Finland', 'FR' => 'France', 'GF' => 'French Guiana', 'PF' => 'French Polynesia', 'TF' => 'French Southern Territories', 'GA' => 'Gabon', 'GM' => 'Gambia', 'GE' => 'Georgia', 'DE' => 'Germany', 'GH' => 'Ghana', 'GI' => 'Gibraltar', 'GR' => 'Greece', 'GL' => 'Greenland', 'GD' => 'Grenada', 'GP' => 'Guadeloupe', 'GU' => 'Guam', 'GT' => 'Guatemala', 'GG' => 'Guernsey', 'GN' => 'Guinea', 'GW' => 'Guinea-Bissau', 'GY' => 'Guyana', 'HT' => 'Haiti', 'HM' => 'Heard Island and McDonald Islands', 'VA' => 'Holy See', 'HN' => 'Honduras', 'HK' => 'Hong Kong', 'HU' => 'Hungary', 'IS' => 'Iceland', 'IN' => 'India', 'ID' => 'Indonesia', 'IR' => 'Iran (Islamic Republic of)', 'IQ' => 'Iraq', 'IE' => 'Ireland', 'IM' => 'Isle of Man', 'IL' => 'Israel', 'IT' => 'Italy', 'JM' => 'Jamaica', 'JP' => 'Japan', 'JE' => 'Jersey', 'JO' => 'Jordan', 'KZ' => 'Kazakhstan', 'KE' => 'Kenya', 'KI' => 'Kiribati', 'KP' => 'Korea (Democratic People\'s Republic of)', 'KR' => 'Korea (Republic of)', 'KW' => 'Kuwait', 'KG' => 'Kyrgyzstan', 'LA' => 'Lao People\'s Democratic Republic', 'LV' => 'Latvia', 'LB' => 'Lebanon', 'LS' => 'Lesotho', 'LR' => 'Liberia', 'LY' => 'Libya', 'LI' => 'Liechtenstein', 'LT' => 'Lithuania', 'LU' => 'Luxembourg', 'MO' => 'Macao', 'MK' => 'Macedonia (the former Yugoslav Republic of)', 'MG' => 'Madagascar', 'MW' => 'Malawi', 'MY' => 'Malaysia', 'MV' => 'Maldives', 'ML' => 'Mali', 'MT' => 'Malta', 'MH' => 'Marshall Islands', 'MQ' => 'Martinique', 'MR' => 'Mauritania', 'MU' => 'Mauritius', 'YT' => 'Mayotte', 'MX' => 'Mexico', 'FM' => 'Micronesia (Federated States of)', 'MD' => 'Moldova (Republic of)', 'MC' => 'Monaco', 'MN' => 'Mongolia', 'ME' => 'Montenegro', 'MS' => 'Montserrat', 'MA' => 'Morocco', 'MZ' => 'Mozambique', 'MM' => 'Myanmar', 'NA' => 'Namibia', 'NR' => 'Nauru', 'NP' => 'Nepal', 'NL' => 'Netherlands', 'NC' => 'New Caledonia', 'NZ' => 'New Zealand', 'NI' => 'Nicaragua', 'NE' => 'Niger', 'NG' => 'Nigeria', 'NU' => 'Niue', 'NF' => 'Norfolk Island', 'MP' => 'Northern Mariana Islands', 'NO' => 'Norway', 'OM' => 'Oman', 'PK' => 'Pakistan', 'PW' => 'Palau', 'PS' => 'Palestine, State of', 'PA' => 'Panama', 'PG' => 'Papua New Guinea', 'PY' => 'Paraguay', 'PE' => 'Peru', 'PH' => 'Philippines', 'PN' => 'Pitcairn', 'PL' => 'Poland', 'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Qatar', 'RE' => 'Réunion', 'RO' => 'Romania', 'RU' => 'Russian Federation', 'RW' => 'Rwanda', 'BL' => 'Saint Barthélemy', 'SH' => 'Saint Helena, Ascension and Tristan da Cunha', 'KN' => 'Saint Kitts and Nevis', 'LC' => 'Saint Lucia', 'MF' => 'Saint Martin (French part)', 'PM' => 'Saint Pierre and Miquelon', 'VC' => 'Saint Vincent and the Grenadines', 'WS' => 'Samoa', 'SM' => 'San Marino', 'ST' => 'Sao Tome and Principe', 'SA' => 'Saudi Arabia', 'SN' => 'Senegal', 'RS' => 'Serbia', 'SC' => 'Seychelles', 'SL' => 'Sierra Leone', 'SG' => 'Singapore', 'SX' => 'Sint Maarten (Dutch part)', 'SK' => 'Slovakia', 'SI' => 'Slovenia', 'SB' => 'Solomon Islands', 'SO' => 'Somalia', 'ZA' => 'South Africa', 'GS' => 'South Georgia and the South Sandwich Islands', 'SS' => 'South Sudan', 'ES' => 'Spain', 'LK' => 'Sri Lanka', 'SD' => 'Sudan', 'SR' => 'Suriname', 'SJ' => 'Svalbard and Jan Mayen', 'SZ' => 'Swaziland', 'SE' => 'Sweden', 'CH' => 'Switzerland', 'SY' => 'Syrian Arab Republic', 'TW' => 'Taiwan, Province of China', 'TJ' => 'Tajikistan', 'TZ' => 'Tanzania, United Republic of', 'TH' => 'Thailand', 'TL' => 'Timor-Leste', 'TG' => 'Togo', 'TK' => 'Tokelau', 'TO' => 'Tonga', 'TT' => 'Trinidad and Tobago', 'TN' => 'Tunisia', 'TR' => 'Turkey', 'TM' => 'Turkmenistan', 'TC' => 'Turks and Caicos Islands', 'TV' => 'Tuvalu', 'UG' => 'Uganda', 'UA' => 'Ukraine', 'AE' => 'United Arab Emirates', 'GB' => 'United Kingdom', 'US' => 'United States', 'UY' => 'Uruguay', 'UZ' => 'Uzbekistan', 'VU' => 'Vanuatu', 'VE' => 'Venezuela, Bolivarian Republic of', 'VN' => 'Viet Nam', 'WF' => 'Wallis and Futuna', 'EH' => 'Western Sahara', 'YE' => 'Yemen', 'ZM' => 'Zambia', 'ZW' => 'Zimbabwe'];
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
            'Swahili'
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
        $timezoneset = DateTimeZone::listIdentifiers();
        if ($userInfo->userDetails->country) {

            $timezoneset = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $userInfo->userDetails->country);
        }

        // Get saved languages (assuming stored as JSON array in DB)
        $savedLanguages = json_decode($userInfo->userDetails->Languages ?? '[]', true);

        return view('profile.edit', compact('userInfo', 'timezoneset', 'countries', 'nationalities', 'languages', 'savedLanguages', 'userRoles'));
    }

    public function updateprofile(Request $request)
    {
        $userId = $request->has('userId') ? $request->userId : Auth::id();
        $user = User::findOrFail($userId);
        if ($request->modal == 'user') {

            $colunm = $request->colunm;
            $user->$colunm = $request->value;
            $user->update();
            return response()->json(['succcess' => 'updated !'], 200);
        } elseif ($request->modal == 'userdetails') {
            $user = UserDetails::find($user->userDetails->id);
            $colunm = $request->colunm;
            $user->$colunm = is_array($request->value) ? json_encode($request->value) : $request->value;
            $user->update();
            return response()->json(['succcess' => 'updated !'], 200);
        }
    }

    public function getTimezones(Request $request)
    {
        $countryCode = $request->input('country');
        $timezones = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $countryCode);

        return response()->json(['timezones' => $timezones]);
    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // $user = Auth::user();
        $userId = $request->input('user_id') ?? Auth::id();
        $user = User::findOrFail($userId);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'assets/img/user/' . $fileName;

            // Move the file to the desired directory
            $file->move('assets/img/user', $fileName);

            // Optionally, delete the old profile picture if it exists
            if ($user->profile_pic && File::exists($user->profile_pic)) {
                File::delete($user->profile_pic);
            }

            // Update the user's profile picture path in the database
            $user->profile_pic = $filePath;
            $user->save();

            return response()->json(['success' => true, 'file_path' => asset($filePath)]);
        }

        return response()->json(['success' => false], 400);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ], [
            'new_password.confirmed' => 'The new password and confirmation password do not match.',
        ]);

        $user = Auth::user();


        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Old password is incorrect']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        Auth::logout();

        return redirect()->route('login')->with('status', 'Password changed successfully. Please log in with your new password.');
    }

    public function userchangePassword(Request $request)
    {
        $rules = [
            'new_password' => 'required|confirmed',
        ];

        if (Auth::user()->id != 1) {
            $rules['old_password'] = 'required';
        }

        $request->validate($rules, [
            'new_password.confirmed' => 'The new password and confirmation password do not match.',
        ]);

        $user = User::where('id', $request->user_id)->first();
        if (!(Auth::user()->id == 1)) {
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'Old password is incorrect']);
            }
        }


        $user->password = Hash::make($request->new_password);
        $user->save();


        return redirect()->back()->with('status', 'Password changed successfully.');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        if (auth()->user()->id == 1) {
            return back()->withErrors(['not_allow_profile' => __('You are not allowed to change data for a default user.')]);
        }

        auth()->user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        if (auth()->user()->id == 1) {
            return back()->withErrors(['not_allow_password' => __('You are not allowed to change the password for a default user.')]);
        }

        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }

    public function LeaveManage(Request $request)
    {
        $user = Auth::user();
        // Initialize message and leave counts
        $countMessage = null;
        $remainingAnnualLeaves = null;
        $remainingMedicalLeaves = null;
        $remainingCasualLeaves = null;
        $messageClass = 'text-success';

        // Check if user has leave type set
        if (!$user->userDetails || !$user->userDetails->leaveType) {
            $countMessage = 'Leave type not set.';
            $messageClass = 'text-danger'; // Error class
            $remainingAnnualLeaves = 0;
            $remainingMedicalLeaves = 0;
            $remainingCasualLeaves = 0;
        }
        // Check if user has a join date set
        elseif (!$user->userDetails->joined_date) {
            $countMessage = 'User join date not set.';
            $messageClass = 'text-danger'; // Error class
            $remainingAnnualLeaves = 0;
            $remainingMedicalLeaves = 0;
            $remainingCasualLeaves = 0;
        }
        // If both join date and leave type are set, calculate the remaining leaves
        else {
            // Get the user's annual and medical, casual leave balance
            $userAnnualLeaves = $user->userDetails->leaveType->annual;
            $userMedicalLeaves = $user->userDetails->leaveType->medical;
            $userCasualLeaves = $user->userDetails->leaveType->casual;

            // Calculate the user's leave taken (using the `calculateLeaveDays` method)
            $leaveData = $this->calculateLeaveDays($user->id);  // returns array like ['annualLeaveCount' => 1, 'medicalLeaveCount' => 0, 'casualLeaveCount' => 2]

            // If leave data is an array, extract the counts
            $annualLeaveTaken = $leaveData['annualLeaveCount'] ?? 0;
            $medicalLeaveTaken = $leaveData['medicalLeaveCount'] ?? 0;
            $casualLeaveTaken = $leaveData['casualLeaveCount'] ?? 0;

            // Calculate remaining leaves
            $remainingAnnualLeaves = $userAnnualLeaves - $annualLeaveTaken;
            $remainingMedicalLeaves = $userMedicalLeaves - $medicalLeaveTaken;
            $remainingCasualLeaves = $userCasualLeaves - $casualLeaveTaken;

            // Build the countMessage for Annual Leaves
            if ($remainingAnnualLeaves < 0) {
                $remainingAnnualLeaves = 0;
            }
            if ($remainingMedicalLeaves < 0) {
                $remainingMedicalLeaves = 0;
            }
            if ($remainingCasualLeaves < 0) {
                $remainingCasualLeaves = 0;
            }
        }

        $pendingReq = UserLeave::where('user_id', $user->id)
            ->where('status', 0)
            ->where('active', 1)
            ->count();
        $approvedReq = UserLeave::where('user_id', $user->id)
            ->where('status', 1)
            ->where('active', 1)
            ->count();
        $rejectedReq = UserLeave::where('user_id', $user->id)
            ->where('status', 2)
            ->where('active', 1)
            ->count();
        $allReq = UserLeave::where('user_id', $user->id)
            ->where('active', 1)
            ->count();

        return view('profile.leave_index', ['pendingReq' => $pendingReq, 'approvedReq' => $approvedReq, 'rejectedReq' => $rejectedReq, 'allReq' => $allReq, 'remainingAnnualLeaves' => $remainingAnnualLeaves, 'remainingMedicalLeaves' => $remainingMedicalLeaves, 'remainingCasualLeaves' => $remainingCasualLeaves, 'countMessage' => $countMessage, 'messageClass' => $messageClass]);
    }

    public function checkLeaveConflict(Request $request)
    {
        $fromDate = $request->input('from');
        $toDate = $request->input('to');
        $type = $request->input('type');
        $fromTime = $request->input('from_time');
        $toTime = $request->input('to_time');
        if ($type == 0) {
            $toDate = $request->input('from');
        } elseif ($type == 1) {
            $toDate = $request->input('from');
        }

        // Guard: if dates are missing, return no conflict rather than crashing
        if (empty($fromDate) || !preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $fromDate)) {
            return response()->json(['success' => true, 'message' => 'No conflicts found.']);
        }

        // Convert input dates into 'mm/dd/yyyy' format
        $fromDateFormatted = \Carbon\Carbon::createFromFormat('m/d/Y', $fromDate)->format('m/d/Y');
        $toDateFormatted = $toDate ? \Carbon\Carbon::createFromFormat('m/d/Y', $toDate)->format('m/d/Y') : null;

        // Base query
        $conflictingLeavesQuery = UserLeave::where('active', 1)->where('status', 1)
            ->where(function ($query) use ($fromDateFormatted, $toDateFormatted) {
                $query->whereRaw("STR_TO_DATE(start_date, '%m/%d/%Y') BETWEEN STR_TO_DATE(?, '%m/%d/%Y') AND STR_TO_DATE(?, '%m/%d/%Y')", [$fromDateFormatted, $toDateFormatted])
                    ->orWhereRaw("STR_TO_DATE(end_date, '%m/%d/%Y') BETWEEN STR_TO_DATE(?, '%m/%d/%Y') AND STR_TO_DATE(?, '%m/%d/%Y')", [$fromDateFormatted, $toDateFormatted])
                    ->orWhereRaw(
                        "STR_TO_DATE(start_date, '%m/%d/%Y') <= STR_TO_DATE(?, '%m/%d/%Y')
                                AND STR_TO_DATE(end_date, '%m/%d/%Y') >= STR_TO_DATE(?, '%m/%d/%Y')",
                        [$fromDateFormatted, $toDateFormatted]
                    ); // Handles full containment case
            });

        // Add short leave time conflict check
        if ($type == 3 && $fromTime && $toTime) {
            $conflictingLeavesQuery->where(function ($query) use ($fromTime, $toTime) {
                $query->where('type', 3)
                    ->where(function ($q) use ($fromTime, $toTime) {
                        $q->whereBetween('short_from_time', [$fromTime, $toTime])
                            ->orWhereBetween('short_to_time', [$fromTime, $toTime])
                            ->orWhere(function ($subQ) use ($fromTime, $toTime) {
                                $subQ->where('short_from_time', '<=', $fromTime)
                                    ->where('short_to_time', '>=', $toTime);
                            });
                    });
            });
        }

        // Modify query based on leave type conditions
        $conflictingLeavesQuery->where(function ($query) {
            $query->where(function ($q) {
                $q->where('type', 0) // Half day
                    ->where(function ($subQuery) {
                        $subQuery->where('day_type', 0) // Morning
                            ->orWhere('day_type', 1); // Evening
                    })
                    ->whereNull('end_date'); // End date should not be set
            })
                ->orWhere(function ($q) {
                    $q->where('type', 1) // One-day leave
                        ->whereNull('end_date'); // End date should not be set
                })
                ->orWhere(function ($q) {
                    $q->where('type', 2) // Multiple days leave
                        ->whereNotNull('end_date'); // End date should be set
                });
        });

        // Get results
        $conflictingLeaves = $conflictingLeavesQuery->get();

        if ($conflictingLeaves->isEmpty()) {
            return response()->json(['success' => true, 'message' => 'No conflicts found.']);
        } else {
            $message = '';
            foreach ($conflictingLeaves as $leave) {
                // Get leave dates
                $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', $leave->start_date)->format('m/d/Y');
                $endDate = $leave->end_date ? \Carbon\Carbon::createFromFormat('m/d/Y', $leave->end_date)->format('m/d/Y') : 'N/A';

                // Define leave type message
                // $leaveTypeMsg = ($leave->type == 0) ? 'Half-Day (' . ($leave->day_type == 0 ? 'Morning' : 'Evening') . ')'
                //                : (($leave->type == 1) ? 'One-Day Leave' : 'Multiple-Day Leave');
                switch ($leave->type) {
                    case 0:
                        $leaveTypeMsg = 'Half-Day (' . ($leave->day_type == 0 ? 'Morning' : 'Evening') . ')';
                        break;
                    case 1:
                        $leaveTypeMsg = 'One-Day Leave';
                        break;
                    case 2:
                        $leaveTypeMsg = 'Multiple-Day Leave';
                        break;
                    case 3:
                        $leaveTypeMsg = 'Short Leave (' . $leave->short_from_time . ' - ' . $leave->short_to_time . ')';
                        break;
                    default:
                        $leaveTypeMsg = 'Unknown';
                }

                // Define status color
                $statusColor = ($leave->status == 1) ? 'red' : '#d9b62f';
                $statusText = ($leave->status == 1) ? 'Approved' : 'Pending';

                // Append message
                $message .= "<p style='color: $statusColor; font-size:12px;margin-bottom:unset'>{$leave->userDetails->name} takes $leaveTypeMsg from $startDate" .
                    ($leave->type == 2 ? " to $endDate" : "") . " ($statusText)</p>";
            }
            return response()->json(['success' => false, 'message' => $message]);
        }
    }

    public function calculateLeaveDays($userId)
    {
        // Get the user's join date
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $currentDate = Carbon::now(); // Get the current date
        $currentMonth = $currentDate->month; // Get the current month
        $currentDay = $currentDate->day; // Get the current day
        $joinDate = Carbon::createFromFormat('m/d', '02/13'); // Example join date (MM/DD)

        if ($currentMonth < $joinDate->month || ($currentMonth == $joinDate->month && $currentDay > $joinDate->day)) {
            // If current month is less than join month, use the previous year as start
            $currentYearStart = $currentDate->copy()->month($joinDate->month)->day($joinDate->day); // Start date: current year join month and day - 1 year
            $currentYearEnd = $currentDate->copy()->month($joinDate->month)->day($joinDate->day)->addYear(); // End date: current year join month and day + 1 year


        } else {
            // If current month is greater than or equal to join month, use the current year as start
            $currentYearStart = $currentDate->copy()->month($joinDate->month)->day($joinDate->day)->subYear(); // Start date: current year join month and day - 1 year
            $currentYearEnd = $currentDate->copy()->month($joinDate->month)->day($joinDate->day); // End date: current year join month and day

        }

        // Get leave data (annual, medical, casual and multiple-day)
        $leaveData = UserLeave::where('user_id', $userId)
            ->where('active', 1)
            ->where('status', 1)
            ->whereBetween(
                DB::raw('STR_TO_DATE(start_date, "%m/%d/%Y")'), // Convert the varchar to date format
                [$currentYearStart, $currentYearEnd]
            )
            ->get();
        // dd($currentYearStart, $currentYearEnd,$leaveData); // Check start and end dates

        $annualLeaveCount = 0;
        $medicalLeaveCount = 0;
        $casualLeaveCount = 0;

        // Loop through the leaves and calculate leave days based on the type
        foreach ($leaveData as $leave) {
            if ($leave->leave_type == 'annual') {
                $annualLeaveCount += $this->calculateLeaveTypeDays($leave);
            } elseif ($leave->leave_type == 'medical') {
                $medicalLeaveCount += $this->calculateLeaveTypeDays($leave);
            } elseif ($leave->leave_type == 'casual') {
                $casualLeaveCount += $this->calculateLeaveTypeDays($leave);
            }
        }

        return [
            'annualLeaveCount' => $annualLeaveCount,
            'medicalLeaveCount' => $medicalLeaveCount,
            'casualLeaveCount' => $casualLeaveCount,
        ];
    }

    // Function to calculate leave days for each leave type
    private function calculateLeaveTypeDays($leave)
    {
        if ($leave->type == 0) {
            // Half-day leave (type 0)
            return 0.5;
        } elseif ($leave->type == 1) {
            // Full-day leave (type 1)
            return 1;
        } elseif ($leave->type == 2) {
            // Multiple-day leave (type 2): Calculate days between start_date and end_date
            $startDate = Carbon::parse($leave->start_date);
            $endDate = Carbon::parse($leave->end_date);
            return $startDate->diffInDays($endDate) + 1; // Include both start and end days
        } elseif ($leave->type == 3) {
            // Short leave (type 3): Assuming short leave counts as 0.25 day
            return 0.25;
        }
        return 0;
    }

    /**
     * Create a new leave request.
     * If is_covering is set, save covering details and do NOT deduct balance.
     */
    public function LeaveCreate(Request $request)
    {
        $user = Auth::user();
        $userLeave = new UserLeave;
        $userLeave->user_id = $user->id;
        $userLeave->title = $request->employee_leave_title;
        $userLeave->leave_type = $request->leave_type;

        $dayTypeLabels = [
            'half_day'      => 'Half Day',
            'one_day'       => 'One Day',
            'multiple_days' => 'Multiple Days',
            'short_leave'   => 'Short Leave',
            'covering'      => 'Covering Day',
        ];

        $formatDate = fn($d) => $d ? \Carbon\Carbon::parse($d)->format('m/d/Y') : '—';

        if ($request->employee_leave_type == 'half_day') {
            $userLeave->start_date = $request->half_day_leave;
            $userLeave->day_type = $request->employee_leave_half_day_time;
            $userLeave->type = 0;
            $dates = $formatDate($request->half_day_leave);
        } elseif ($request->employee_leave_type == 'one_day') {
            $userLeave->start_date = $request->one_day_leave;
            $userLeave->type = 1;
            $dates = $formatDate($request->one_day_leave);
        } elseif ($request->employee_leave_type == 'multiple_days') {
            $userLeave->start_date = $request->multiple_days_leave_from;
            $userLeave->end_date = $request->multiple_days_leave_to;
            $userLeave->type = 2;
            $dates = $formatDate($request->multiple_days_leave_from) . ' to ' . $formatDate($request->multiple_days_leave_to);
        } elseif ($request->employee_leave_type == 'short_leave') {
            $userLeave->start_date = $request->short_leave_date;
            $userLeave->short_from_time = $request->short_leave_from;
            $userLeave->short_to_time = $request->short_leave_to;
            $userLeave->type = 3;
            $dates = $formatDate($request->short_leave_date) . ' (' . $request->short_leave_from . ' - ' . $request->short_leave_to . ')';
        } else {
            $dates = '—';
        }

        $userLeave->request_note = $request->employee_leave_note;

        // ── Covering Day ──────────────────────────────────────────
        if ($request->filled('is_covering')) {
            $userLeave->title             = $request->covering_title;
            $userLeave->request_note      = $request->covering_reason;
            $userLeave->covering_leave_date = $request->covering_leave_date;
            $userLeave->covering_cover_date = $request->covering_cover_date;
            $userLeave->type              = 4;
            $userLeave->leave_type        = 'covering';
            $userLeave->save();

            app(EmailNotificationBuilderService::class)->sendEmailFromTemplate(
                'key_email_leave_request_admin',
                [
                    'employeeName'  => $user->name,
                    'employeeEmail' => $user->email,
                    'title'         => $userLeave->title,
                    'leaveType'     => 'Covering',
                    'dayType'       => 'Covering Day',
                    'dates'         => $formatDate($request->covering_leave_date),
                    'coveringDates' => $formatDate($request->covering_cover_date),
                    'requestNote'   => $userLeave->request_note,
                ]
            );

            return redirect()->back()->with('success', 'Covering day submitted!');
        }
        // ── END Covering Day ──────────────────────────────────────

        $userLeave->save();

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate(
            'key_email_leave_request_admin',
            [
                'employeeName'  => $user->name,
                'employeeEmail' => $user->email,
                'title'         => $userLeave->title,
                'leaveType'     => $userLeave->leave_type,
                'dayType'       => $dayTypeLabels[$request->employee_leave_type] ?? '—',
                'dates'         => $dates,
                'coveringDates' => null,
                'requestNote'   => $userLeave->request_note,
            ]
        );


        return redirect()->back()->with('success', 'Leave Created Successfully!');
    }

    /**
     * Update an existing (pending) leave request.
     */
    public function LeaveUpdate(Request $request, $id)
    {
        $leave = UserLeave::where('id', $id)           // ← was EmployeeLeave
            ->where('user_id', auth()->id())
            ->where('status', 0)          // only pending
            ->firstOrFail();

        $leave->title        = $request->employee_leave_title;
        $leave->request_note = $request->employee_leave_note;
        $leave->leave_type   = $request->leave_type;

        $type = $request->employee_leave_type;

        if ($type === 'half_day') {
            $leave->type       = 0;
            $leave->start_date = $request->half_day_leave;   // already m/d/Y
            $leave->end_date   = null;
            $leave->day_type   = $request->employee_leave_half_day_time;
        } elseif ($type === 'one_day') {
            $leave->type       = 1;
            $leave->start_date = $request->one_day_leave;    // already m/d/Y
            $leave->end_date   = null;
        } elseif ($type === 'multiple_days') {
            $leave->type       = 2;
            $leave->start_date = $request->multiple_days_leave_from;
            $leave->end_date   = $request->multiple_days_leave_to;
        } elseif ($type === 'short_leave') {
            $leave->type            = 3;
            $leave->start_date      = $request->short_leave_date;
            $leave->end_date        = null;
            $leave->short_from_time = $request->short_leave_from;
            $leave->short_to_time   = $request->short_leave_to;
        }
        $leave->save();
        return redirect()->back()->with('success', 'Leave updated successfully!');
    }

    /**
     * Withdraw an existing (pending) leave request.
     */
    public function LeaveWithdraw($id)
    {
        $leave = UserLeave::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 0)   // only pending can be withdrawn
            ->firstOrFail();

        $leave->active = 0;
        $leave->save();

        return response()->json(['success' => true, 'message' => 'Leave withdrawn successfully.']);
    }

    public function GetTableData($status_id, $u_id)
    {
        if ($status_id == 3) {
            // If status is 3, show all records regardless of the status
            $UserLeave = UserLeave::where('user_id', $u_id)
                ->where('active', 1)
                ->get();
        } else {
            // Otherwise, filter by status_id
            $UserLeave = UserLeave::where('user_id', $u_id)
                ->where('status', $status_id)
                ->where('active', 1)
                ->get();
        }

        return response()->json($UserLeave); // Return JSON response
    }

    public function GetTableDataAll(Request $request)
    {

        $UserLeaves = UserLeave::where('active', 1)
            ->with('userDetails.userDetails')
            ->get();

        return response()->json($UserLeaves); // Return JSON response
    }

    public function getLeaveRequestDetails(Request $request)
    {
        $leaveRequest = UserLeave::with('userDetails.userDetails')
            ->find($request->leave_id);

        if (!$leaveRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Leave request not found.'
            ], 404);
        }

        $leaveTypeLabel = 'Unknown';
        $leaveDays = [];
        $dayTypeLabel = null;

        switch ($leaveRequest->type) {
            case 0:
                $leaveTypeLabel = 'Half Day';
                if ($leaveRequest->start_date) {
                    $leaveDays[] = Carbon::parse($leaveRequest->start_date)->format('d/m/Y');
                }
                $dayTypeLabel = $leaveRequest->day_type === 1 ? 'Evening' : 'Morning';
                break;
            case 1:
                $leaveTypeLabel = 'One Day';
                if ($leaveRequest->start_date) {
                    $leaveDays[] = Carbon::parse($leaveRequest->start_date)->format('d/m/Y');
                }
                $dayTypeLabel = 'One Day';
                break;
            case 2:
                $leaveTypeLabel = 'Multiple Days';
                if ($leaveRequest->start_date && $leaveRequest->end_date) {
                    $startDate = Carbon::parse($leaveRequest->start_date);
                    $endDate = Carbon::parse($leaveRequest->end_date);
                    while ($startDate <= $endDate) {
                        $leaveDays[] = $startDate->format('d/m/Y');
                        $startDate->addDay();
                    }
                } elseif ($leaveRequest->start_date) {
                    $leaveDays[] = Carbon::parse($leaveRequest->start_date)->format('d/m/Y');
                }
                $dayTypeLabel = 'Multiple Days';
                break;
            case 3:
                $leaveTypeLabel = 'Short Leave';
                if ($leaveRequest->start_date) {
                    $leaveDays[] = Carbon::parse($leaveRequest->start_date)->format('d/m/Y');
                }
                $dayTypeLabel = 'Short Leave';
                break;
            case 4:
                $leaveTypeLabel = 'Covering Day';
                if ($leaveRequest->covering_leave_date) {
                    $leaveDays[] = Carbon::parse($leaveRequest->covering_leave_date)->format('d/m/Y');
                } elseif ($leaveRequest->start_date) {
                    $leaveDays[] = Carbon::parse($leaveRequest->start_date)->format('d/m/Y');
                }
                $dayTypeLabel = 'Covering Day';
                break;
        }

        $employee = optional($leaveRequest->userDetails);
        $employeeDetails = optional($employee->userDetails);

        $leaveResponse = [
            'id' => $leaveRequest->id,
            'user_id' => $leaveRequest->user_id,
            'employee_name' => $employee->name,
            'employee_email' => $employee->email,
            'employee_status' => $employeeDetails->Employment_Status,
            'employee_department' => $employeeDetails->Department,
            'employee_job_title' => $employeeDetails->job_title,
            'employee_joined_date' => $employeeDetails->joined_date,
            'total_leave_days' => count($leaveDays),
            'type' => $leaveRequest->type,
            'leave_type' => $leaveTypeLabel,
            'leave_category' => $leaveRequest->leave_type,
            'day_type' => $leaveRequest->day_type,
            'day_type_label' => $dayTypeLabel,
            'leave_days' => $leaveDays,
            'start_date' => $leaveRequest->start_date,
            'end_date' => $leaveRequest->end_date,
            'covering_leave_date' => $leaveRequest->covering_leave_date,
            'covering_cover_date' => $leaveRequest->covering_cover_date,
            'short_from_time' => $leaveRequest->short_from_time,
            'short_to_time' => $leaveRequest->short_to_time,
            'request_title' => $leaveRequest->title,
            'leave_reason' => $leaveRequest->request_note,
            'note' => $leaveRequest->note,
            'approve_by' => $leaveRequest->approve_by,
            'status' => $leaveRequest->status,
            'active' => $leaveRequest->active,
            'created_at' => $leaveRequest->created_at,
            'updated_at' => $leaveRequest->updated_at,
        ];

        return response()->json([
            'success' => true,
            'leave' => $leaveResponse,
        ]);
    }

    /**
     * Update the status of a leave request (approve or reject).
     * Sends an email notification to the leave owner about the status update.
     */
    public function updateLeaveStatus(Request $request)
    {
        $dayTypeLabels = [
            0 => 'Half Day',
            1 => 'One Day',
            2 => 'Multiple Days',
            3 => 'Short Leave',
            4 => 'Covering Day',
        ];

        // Find the leave request by ID
        $leaveRequest = UserLeave::find($request->leave_id);
        $statusLabel = '';

        // Build dates based on leave type
        $coveringDates = null;

        if ($leaveRequest->type == 4) {
            // Covering Day: leave date and cover date as two separate values
            $dates = $leaveRequest->covering_leave_date
                ? \Carbon\Carbon::parse($leaveRequest->covering_leave_date)->format('m/d/Y')
                : '—';

            $coveringDates = $leaveRequest->covering_cover_date
                ? \Carbon\Carbon::parse($leaveRequest->covering_cover_date)->format('m/d/Y')
                : '—';
        } else {
            // Normal leaves: use start_date and end_date
            $startDate = $leaveRequest->start_date
                ? \Carbon\Carbon::parse($leaveRequest->start_date)->format('m/d/Y')
                : '—';
            $endDate = $leaveRequest->end_date
                ? \Carbon\Carbon::parse($leaveRequest->end_date)->format('m/d/Y')
                : null;

            $dates = ($endDate && $endDate !== $startDate)
                ? "$startDate to $endDate"
                : $startDate;
        }

        if ($leaveRequest) {
            $user = Auth::user();

            if ($request->status === 'approved') {
                $leaveRequest->status = 1;
                $leaveRequest->approve_by = $user->id;
                $statusLabel = 'Approved';
            } elseif ($request->status === 'rejected') {
                $leaveRequest->status = 2;
                $leaveRequest->approve_by = $user->id;
                $statusLabel = 'Rejected';
            }

            app(EmailNotificationBuilderService::class)->sendEmailFromTemplate(
                'key_email_leave_status_update',
                [
                    'user_leave_id' => $leaveRequest->id,
                    'employeeName'  => $leaveRequest->user->name,
                    'employeeEmail' => $leaveRequest->user->email,
                    'title'         => $leaveRequest->title,
                    'leaveType'     => $leaveRequest->leave_type,
                    'dayType'       => $dayTypeLabels[$leaveRequest->type] ?? '—',
                    'dates'         => $dates,
                    'coveringDates' => $coveringDates,
                    'requestNote'   => $leaveRequest->request_note,
                    'status'        => $statusLabel,
                    'rejectReason'  => $request->reject_reason ?? null,
                ]
            );

            $leaveRequest->save();

            return response()->json([
                'success' => true,
                'message' => 'Leave request status updated successfully.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Leave request not found.',
        ], 404);
    }

    public function LeaveTypeCreate(Request $request)
    {
        $request->validate([
            'employee_leave_title' => 'required|string|max:50',
            'Annual_Leaves' => 'required|integer|min:0',
            'Medical_Leaves' => 'required|integer|min:0',
            'Casual_Leaves' => 'required|integer|min:0',
        ]);

        LeaveType::create([
            'name' => $request->employee_leave_title,
            'annual' => $request->Annual_Leaves,
            'medical' => $request->Medical_Leaves,
            'casual' => $request->Casual_Leaves,
            'active' => 1, // Default active status
        ]);

        return redirect()->back()->with('success', 'Leave type created successfully!');
    }

    public function updateLeaveType(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'employee_leave_title' => 'required|string|max:255',
            'Annual_Leaves' => 'required|integer|min:0',
            'Medical_Leaves' => 'required|integer|min:0',
            'Casual_Leaves' => 'required|integer|min:0',
        ]);

        // Find the leave type by ID
        $leaveType = LeaveType::find($request->leave_type_id);

        // Check if the leave type exists
        if (!$leaveType) {
            return redirect()->back()->with('error', 'Leave Type not found.');
        }

        // Update the leave type's attributes
        $leaveType->name = $request->employee_leave_title;
        $leaveType->annual = $request->Annual_Leaves;
        $leaveType->medical = $request->Medical_Leaves;
        $leaveType->casual = $request->Casual_Leaves;

        // Save the changes to the database
        $leaveType->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Leave Type updated successfully.');
    }

    public function deleteLeaveType($id)
    {
        // Find the leave type by ID
        $leaveType = LeaveType::find($id);

        // Check if the leave type exists
        if (!$leaveType) {
            return response()->json(['error' => 'Leave Type not found.'], 404);
        }

        // Update the 'active' column to 0 to deactivate it
        $leaveType->active = 0;
        $leaveType->save();

        // Return success response
        return response()->json(['success' => 'Leave Type deactivated successfully.']);
    }
}
