<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
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
