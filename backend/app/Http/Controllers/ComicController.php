<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateComicRequest;
use App\Models\Comic;
use App\Models\Publisher;

class ComicController extends Controller
{
    public function index()
    {
        $comics = Comic::all();
        $mapped_comics = $comics->map(function ($comic) {
            $publisher = Publisher::find($comic->publisher);
            $comic->publisher = $publisher;
            return $comic;
        });

        return response()->json([
            'status' => 'success',
            'comics' => $mapped_comics
        ]);
    }

    public function show($id)
    {
        $comic = Comic::find($id);

        if ($comic == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Comic not found'
            ], 404);
        }

        $publisher = Publisher::find($comic->publisher);
        $comic->publisher = $publisher;

        return response()->json([
            'status' => 'success',
            'comic' => $comic
        ]);
    }

    public function toggleHide($id)
    {
        $comic = Comic::find($id);

        if ($comic == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Comic not found'
            ], 404);
        }

        $comic->is_hidden = !$comic->is_hidden;
        $comic->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Comic visibility toggled successfully'
        ]);
    }

    public function create(CreateComicRequest $request)
    {
        $data = $request->validated();

        $images = [];
        foreach ($request->images as $image) {
            $path = ImageController::store($image, 'comics');
            array_push($images, $path);
        }

        $comic = Comic::create([
            'name' => $request->name,
            'description' => $request->description,
            'images' => $images,
            'price' => $request->price,
            'has_discount' => $request->has_discount,
            'discount' => $request->discount,
            'categories' => $request->categories,
            'publisher' => $request->publisher,
            'issued_at' => $request->published_date,
            'created_by' => request()->user()->_id,
        ]);

        return response()->json([
            'message' => 'Comic created successfully',
            'comic' => $comic
        ], 201);
    }
}
