<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\Publisher;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->cart;
        if (auth('sanctum')->check()) {
            $cart = auth('sanctum')->user()->cart;
        }

        $cart = Comic::whereIn('_id', $cart)->get();
        $publishers = Publisher::all();
        $comics = $cart->map(function ($comic) use ($publishers){
            // get publisher from publishers collection
            $publisher = $publishers->where('_id', $comic->publisher)->first();
            $comic->publisher = $publisher;
            return $comic;
        });

        return response()->json([
            'status' => 'success',
            'cart' => $comics,
        ]);
    }
}
