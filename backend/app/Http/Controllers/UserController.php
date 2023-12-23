<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\Gender;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function create(RegisterUserRequest $request)
    {
        $request->validated();

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'=> $request->last_name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
            'mobile'=> $request->mobile,
            'gender_id' => $request->gender,
            'status_id' => 1
        ]);

        return response()->json([
            'message' => 'User registered successfully.',
            'request' => $request->all(),
        ]);
    }

    public function deploy() {
        Gender::create([
            'name'=> 'Male',
        ]);
        Gender::create([
            'name'=> 'Female',
        ]);

        response()->json([
            'message'=> 'Deployded successfully.',
        ]);
    }
}
