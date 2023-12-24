<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $request->validated();

        // create new user
        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile' => $request->mobile,
            'gender_id' => $request->gender,
            'status_id' => 1
        ]);

        // send welcome email
        MailController::welcome([
            'email'=> $request->email,
            'name'=> "$request->first_name $request->last_name",
        ]);

        return response()->json([
            'message' => 'User registered successfully.',
            'request' => $request->all(),
        ]);
    }

    public function login(LoginRequest $request)
    {
        try {
            $request->validated();

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
                "token" => auth()->user()->createToken("auth_token")->plainTextToken,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
