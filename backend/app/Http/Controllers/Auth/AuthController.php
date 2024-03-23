<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Http\Controllers\NewsletterController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        // create new user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile' => $request->mobile,
            'gender' => $request->gender,
            'status' => "Active",
            "role" => "Customer",
        ]);

        // Subscribe to newsletter
        NewsletterController::subscribe($request);

        // send welcome email
        MailController::welcome([
            'email' => $request->email,
            'name' => "$request->first_name $request->last_name",
        ]);

        return response()->json([
            'message' => 'User registered successfully.',
            'request' => $user,
        ]);
    }

    public function login(LoginRequest $request)
    {
        // check login credentials
        $logged_in = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if (!$logged_in) {
            return response()->json([
                "error" => "Invalid Login Credentials"
            ], 401);
        }

        return response()->json([
            'message' => "Login successfull",
            "user" => auth()->user(),
            "token" => request()->user()->createToken("auth_token")->plainTextToken,
        ]);
    }
}
