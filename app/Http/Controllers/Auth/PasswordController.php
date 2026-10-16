<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPasswordReset;
use App\Services\EmailNotificationBuilderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    var $smptEncryption = 'SSL';
    var $smptPort = '465';
    var $smptHost = 'server.encr.co';
    var $mailUsername = 'info@encr.co';
    var $mailPassword = 'Encr.co@ec123';

    public function index(){
        return view('auth.passwords.reset_mail');
    }

    public function sentResetMail(Request $request){

        $validator = Validator::make($request->all(), [
                'email' => 'required|email'
            ]);
        if ($validator->fails()){
            if ($validator->errors()->has('email')){
                return redirect()->back()->withErrors(['email' => 'Please give valid email address']);
            }
            return redirect()->back()->with(['passowrd_error' => 'Something went wrong..!']);
        }
        $mail_status = User::where('email', $request->email)->first();
        if ($mail_status == null){
            return redirect()->back()->withErrors(['email' => 'Can not find account with this email'])->withInput();

        }
        $validated = $validator->validated();

        $token = Str::random(64);
        UserPasswordReset::where('email', $validated['email'])->delete();
        $resetRequest = new UserPasswordReset();
        $resetRequest->email = $validated['email'];
        $resetRequest->token = $token;
        $resetRequest->save();

        $resetLink = route("forgot-password.reset-password", ["token" => $token, "email" => $validated['email']]);

        try {
            app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_password_reset', [
                'custom_email' => $validated['email'],
                'user_name'    => ucwords($mail_status->name),
                'reset_link'   => $resetLink,
            ]);

            return back()->with(['sent_success' => 'Please check your email inbox!', 'sent_email' => $validated['email']]);
        } catch (\Throwable $e) {
            logger()->error('Password reset email failed', [
                'email' => $validated['email'],
                'error' => $e->getMessage(),
            ]);

            return back()->with(['password_error' => 'Please try again...!']);
        }

    }

    public function resetPassword($token,$email){
        $checkToken = UserPasswordReset::where('email', $email)->orderBy('created_at', 'desc')->first();
        if ($checkToken == null){
            return redirect()->route('forgot-password')->with(['password_error' => 'Please request again to reset password']);
        }
        $current_timestamp = Carbon::now()->toDateTimeString();
        if ($current_timestamp > $checkToken->created_at->addHour()){
            return redirect()->route('forgot-password')->with(['password_error' => 'Your password reset session expired...! please try again']);
        }
        return view('auth.passwords.reset_password', ['token' => $token, 'email' => $email]);
    }

    public function resetPasswordSubmit(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'token' => 'required|string|exists:user_password_resets,token',
            'password' => 'required|string',
            'conform_password' => 'required|string|same:password',
        ]);
        if ($validator->fails()){
            if ($validator->errors()->has('email')){
                return redirect()->route('forgot-password')->with(['password_error' => 'Can not identify your account']);
            }
            if ($validator->errors()->has('token')){
                return redirect()->route('forgot-password')->with(['password_error' => 'You clicked link is not valid...! Please try again']);
            }
            if ($validator->errors()->has('password')){
                return redirect()->back()->withErrors(['password' => 'Valid password required...!']);
            }
            if ($validator->errors()->has('conform_password')){
                return redirect()->back()->withErrors(['conform_password' => 'Conform password required and must match to password']);
            }
            return redirect()->back()->with(['password_error' => 'Something went wrong']);
        }
        $validated = $validator->validated();

        $checkToken = UserPasswordReset::where('email', $validated['email'])->orderBy('created_at', 'desc')->first();
        if($checkToken == null){
            return redirect()->back()->with(['password_error' => 'Please request and try again to reset password']);
        }
        $current_timestamp = Carbon::now()->toDateTimeString();
        if ($current_timestamp > $checkToken->created_at->addHour()){
            return redirect()->route('forgot-password')->with(['password_error' => 'Your password reset session expired...! please try again']);
        }
        $user = User::where('email', $validated['email'] )->first();
        $user->password = Hash::make($validated['password']);
        $user->save();

        try {
            app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_password_reset_success', [
                'custom_email' => $validated['email'],
                'user_name'    => ucwords($user->name),
            ]);
        } catch (\Throwable $e) {
            logger()->error('Password reset success email failed', [
                'email' => $validated['email'],
                'error' => $e->getMessage(),
            ]);
        }

        UserPasswordReset::where('email', $validated['email'])->delete();

        Auth::attempt(array('email' => $validated['email'], 'password' => $validated['password']));
        return redirect()->route('home')->with(['success' => 'Dear '.ucwords($user->name).', Your password updated successfully...!']);
    }

}
