<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddPaymentMethodRequest;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(AddPaymentMethodRequest $request)
    {
        // Check if the payment method with card number already exists
        $is_exists = User::where('payment_methods.card_number', $this->encrypt($request->card_number))->exists();
        if ($is_exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment method already exists.',
            ], 409);
        }

        // Add the payment method
        $payment_method = [
            'payment_type' => $request->payment_type,
            'expiry_date' => $request->expiry_date,
            'cvv' => $this->encrypt($request->cvv),
            'card_number' => $this->encrypt($request->card_number),
        ];

        // push to payment_methods
        $request->user()->push('payment_methods', $payment_method);

        return response()->json([
            'status' => 'success',
            'message' => 'Payment method added successfully.',
        ], 201);
    }

    private function encrypt($data)
    {
        // Perform encryption logic here
        $encrypted = openssl_encrypt($data, 'AES-256-CBC', env('APP_ENCRYPTION_KEY'), 0, env('APP_ENCRYPTION_VI_16'));
        return $encrypted;
    }

    private function decrypt($data)
    {
        // Perform decryption logic here
        $decypted = openssl_decrypt($data, 'AES-256-CBC', env('APP_ENCRYPTION_KEY'), 0, env('APP_ENCRYPTION_VI_16'));
        return $decypted;
    }
}
