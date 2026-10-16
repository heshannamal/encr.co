<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class MailController extends Controller
{
    /**
     * Display a mail Client
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $email = Auth::user()->mail_server_email;
        $email = Auth::user()->email_password;


        return view('pages.maillEmbed.index');
    }

    public function returnMmail(){
         return view('webmailsetup');
    }

    public function compose(){
        return view('pages.mail.compose');
    }

    public function inbox(){
        return view('pages.mail.inbox');
    }

    public function important(){
        return view('pages.mail.important');
    }

    public function sent(){
        return view('pages.mail.sent');
    }

    public function view(){
        return view('pages.mail.view');
    }
}
