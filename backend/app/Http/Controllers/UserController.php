<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request)
    {
        $user = request()->user();

        $user->update($request->validated());

        return response()->json([
            'status' => 'success',
            'user' => $user,
        ]);
    }

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
