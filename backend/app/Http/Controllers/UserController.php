<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Gender;
use App\Models\Newsletter;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public static function subscribe(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:newsletter,email'],
        ]);

        $newsletter = Newsletter::create([
            'email' => $request->email,
        ]);

        return response()->json([
            'message' => 'Subscribed to newsletter successfully.',
            'newsletter' => $newsletter,
        ]);
    }
}
