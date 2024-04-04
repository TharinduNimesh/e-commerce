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

    public function create(Request $request)
    {
        $validated = $request->validate([
            'id' => ['nullable', 'string', 'exists:comics,_id'],
            'cart' => ['nullable', 'array'],
        ]);

        $user = $request->user();

        if ($request->id) {
            $user->push('cart', $validated['id'], true);
        }

        if ($request->cart) {
            $cart = $request->cart;
            // merge array and remove duplicates
            if ($user->cart) {
                $cart = array_unique(array_merge($user->cart, $cart));
            }

            $user->update([
                'cart' => $cart,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'cart' => $user->cart,
        ]);
    }

    public function remove(Request $request)
    {
        $validated = $request->validate([
            'items' => ['required', 'array'],
        ]);

        $user = $request->user();
        $cart = $user->cart;

        if (!$cart) {
            return response()->json([
                'status' => 'success',
                'message' => 'Cart is empty',
            ]);
        }

        $cart = array_diff($cart, $request->items);
        $user->update([
            'cart' => $cart,
        ]);

        return response()->json([
            'status' => 'success',
            'cart' => $user->cart,
        ]);
    }
}
