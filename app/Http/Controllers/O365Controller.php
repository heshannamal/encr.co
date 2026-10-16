<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;

use PhpImap\Mailbox;

class O365Controller extends Controller
{
    // public function callback(Request $request)
    // {
    //     $provider = new GenericProvider([
    //         'clientId'                => config('app.O365_CLIENT_ID'),
    //         'clientSecret'            => config('app.O365_CLIENT_SECRET'),
    //         'redirectUri'             => config('app.O365_REDIRECT_URI'),
    //         'urlAuthorize'            => 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize',
    //         'urlAccessToken'          => 'https://login.microsoftonline.com/common/oauth2/v2.0/token',
    //         'urlResourceOwnerDetails' => '',
    //         'scopes'                  => 'openid profile email offline_access Mail.Read',
    //     ]);

    //     try {
    //         // Get an access token using the authorization code
    //         $accessToken = $provider->getAccessToken('authorization_code', [
    //             'code' => $request->query('code'),
    //         ]);

    //         // Use the access token to interact with the Microsoft Graph API
    //         $graph = new Graph();
    //         $graph->setAccessToken($accessToken->getToken());

    //         // Example: Get the user's profile information
    //         $user = $graph->createRequest('GET', '/me')
    //             ->setReturnType(Model\User::class)
    //             ->execute();

    //         // Process the user data or perform any other required actions
    //         // ...

    //         return 'Authentication successful!';
    //     } catch (IdentityProviderException $e) {
    //         return 'Authentication failed: ' . $e->getMessage();
    //     }
    // }


    public function oauthAuthorize()
    {
        $provider = new GenericProvider([
            'clientId' => '8f86219b-1f18-4179-ad0f-410b8ed0f78c',
            'clientSecret' => '81ae2fab-bf7d-474e-9e75-c858ee09770b',
            'redirectUri' => 'https://encr.co/emails',
            'urlAuthorize' => 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize',
            'urlAccessToken' => 'https://login.microsoftonline.com/common/oauth2/v2.0/token',
            'urlResourceOwnerDetails' => '',
            'scopes' => 'openid profile email imap.access_as_user.all',
        ]);

        $authUrl = $provider->getAuthorizationUrl();

        session()->put('oauth_state', $provider->getState());

        return redirect($authUrl);
    }

    public function oauthCallback(Request $request)
    {
        if ($request->query('state') !== session()->pull('oauth_state')) {
            abort(403, 'Invalid state');
        }

        $provider = new GenericProvider([
            'clientId' => '8f86219b-1f18-4179-ad0f-410b8ed0f78c',
            'clientSecret' => '81ae2fab-bf7d-474e-9e75-c858ee09770b',
            'redirectUri' => 'https://encr.co/emails',
            'urlAuthorize' => 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize',
            'urlAccessToken' => 'https://login.microsoftonline.com/common/oauth2/v2.0/token',
            'urlResourceOwnerDetails' => '',
            'scopes' => 'openid profile email imap.access_as_user.all',
        ]);

        try {
            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $request->query('code'),
            ]);

            $imapHost = '{outlook.office365.com:993/imap/ssl}';
            $username = $accessToken->getClaim('upn');
            $password = $accessToken->getToken();

            $mailbox = new Mailbox($imapHost, $username, $password);

            // Use $mailbox to perform IMAP operations

        } catch (IdentityProviderException $e) {
            abort(500, 'OAuth authentication failed');
        }
    }
}
