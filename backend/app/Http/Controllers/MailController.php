<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function welcome($data)
    {
        Mail::to($data["email"])->queue(new WelcomeMail($data));
    }

    public static function forgotPassword($data)
    {
        Mail::to($data["email"])->send(new ForgotPasswordMail($data));
    }
}
