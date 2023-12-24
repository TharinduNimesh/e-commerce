<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Gender;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function deploy()
    {
        Gender::create([
            'name' => 'Male',
        ]);
        Gender::create([
            'name' => 'Female',
        ]);

        response()->json([
            'message' => 'Deployded successfully.',
        ]);
    }
}
