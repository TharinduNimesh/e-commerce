<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateComicRequest;
use App\Models\Comic;
use App\Models\Publisher;

class ComicController extends Controller
{
    public function index()
    {
        $comics = Comic::orderBy('is_removed', 'asc')->get();
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

    public function update(CreateComicRequest $request, $id)
    {
        $comic = Comic::find($id);
        $images = [];

        foreach ($request->images as $image) {
            // store image in storage if it's new
            if (strpos($image, 'data:image') !== false) {
                $path = ImageController::store($image, 'comics');
                array_push($images, $path);
            } else {
                // remove url path from image
                $image = explode('storage/', $image)[1];
                array_push($images, $image);
            }
        }

        $comic->update([
            'name' => $request->name,
            'description' => $request->description,
            'images' => $images,
            'price' => $request->price,
            'has_discount' => $request->has_discount,
            'discount' => $request->discount,
            'categories' => $request->categories,
            'publisher' => $request->publisher,
            'issued_at' => $request->published_date,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Comic updated successfully',
            'comic' => $comic
        ]);
    }

    public function remove($id)
    {
        $comic = Comic::find($id);

        if ($comic == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Comic not found'
            ], 404);
        }

        $comic->update([
            'is_removed' => true
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Comic deleted successfully'
        ]);
    }
}
