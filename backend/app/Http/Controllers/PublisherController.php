<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePublisherRequest;
use App\Models\Comic;
use App\Models\Publisher;
use Illuminate\Support\Facades\Storage;

class PublisherController extends Controller
{
    public function index()
    {
        $publishers = Publisher::all();

        return response()->json([
            'status' => 'success',
            'publishers' => $publishers
        ]);
    }

    public function create(CreatePublisherRequest $request)
    {
        // get image from base64
        $logo = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->logo));

        // store image in storage
        $path = '/publisher/' . uniqid() . '.png';
        Storage::disk('public')->put($path, $logo, 'public');

        // check if image was stored
        if (!Storage::disk('local')->exists('/public' . $path)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to store image'
            ], 500);
        }

        // store in database
        $publisher = Publisher::create([
            'name' => $request->name,
            'logo' => $path
        ]);

        return response()->json([
            'status' => 'success',
            'publisher' => $publisher
        ]);
    }

    public function show($id)
    {
        $publisher = Publisher::find($id);

        if (!$publisher) {
            return response()->json([
                'status' => 'error',
                'message' => 'Publisher not found'
            ], 404);
        }
        
        $comics = Comic::where('publisher', $id)->limit(4)->get();
        $publisher->comics = $comics;

        return response()->json([
            'status' => 'success',
            'publisher' => $publisher
        ]);
    }
}
