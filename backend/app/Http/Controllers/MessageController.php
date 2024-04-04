<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMessageRequest;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function create(SendMessageRequest $request) 
    {
        $data = $request->validated();

        Message::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Message sent successfully',
        ]);
    }
}
