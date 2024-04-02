<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateComicRequest;
use App\Models\Comic;
use App\Models\Publisher;
use Illuminate\Http\Request;

class ComicController extends Controller
{
    public function index()
    {
        $comics = Comic::all();
        $mapped_comics = $comics->map(function ($comic) {
            $publisher = Publisher::find($comic->publisher);
            return [
                '_id' => $comic->_id,
                'name' => $comic->name,
                'images' => $comic->images,
                'price' => $comic->price,
                'has_discount' => $comic->has_discount,
                'discount' => $comic->discount,
                'publisher' => $publisher,
                'issued_at' => $comic->issued_at,
                'created_by' => $comic->created_by,
                'created_at' => $comic->created_at,
                'updated_at' => $comic->updated_at,
            ];
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
