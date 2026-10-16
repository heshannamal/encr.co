<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Socialite;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Response;

class AzureLoginController extends Controller
{
    public function redirectToAzure()
    {
        return Socialite::driver('azure')
        ->with(["prompt" => "consent"]) // Add prompt=consent parameter
        ->scopes(['openid', 'profile', 'offline_access'])
        ->redirect();
    }

    public function handleAzureCallback(Request $request)
    {
        $user = Socialite::driver('azure')->user();

        // $user contains user information and access token.
        $accessToken = $user->token;
        $UserEmail = $user->email;
        $refreshToken = $user->refreshToken;

        session(['azure_access_token' => $accessToken]);
        session(['azure_refresh_token' => $refreshToken]);
        session(['azure_logged_email' => $UserEmail]);

        if(session()->has('OrganizationID') && !empty(session('OrganizationID'))){
            $OID = session('OrganizationID');
            Session::forget('OrganizationID');
            // dd($OID);
            return redirect()->route('organizations.info', ['id' => $OID]);

        }
        return redirect('/callbackmail'); // Redirect to the home page

    }
    public function logout()
    {
        Session::forget('azure_access_token');
        Session::forget('azure_refresh_token');
        Session::forget('azure_logged_email');

        return redirect()->route('home');

    }


}

