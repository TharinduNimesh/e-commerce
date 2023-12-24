<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function welcome($data)
    {
        Mail::to($data["email"])->queue(new WelcomeMail($data));
    }
}
