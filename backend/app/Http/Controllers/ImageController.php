<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public static function store($image, $folder)
    {
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));

        $path = "/$folder/" . uniqid() . '.png';
        Storage::disk('public')->put($path, $image, 'public');

        return $path;
    }
}
