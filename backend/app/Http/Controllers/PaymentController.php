<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\AddPaymentMethodRequest;
use App\Http\Requests\Payment\UpdatePaymentRequest;
use App\Models\User;

class PaymentController extends Controller
{

    public function index()
    {
        $user = request()->user();
        $payment_methods = $user->payment_methods;

        // filter hidden card number and card type as $payment_methods
        $payment_methods = collect($payment_methods)->map(function ($payment_method) {
            return [
                'id' => $payment_method['id'],
                'payment_type' => $payment_method['payment_type'],
                'card_number' => $this->hide($this->decrypt($payment_method['card_number'])),
            ];
        });

        return response()->json([
            'status' => 'success',
            'payment_methods' => $payment_methods,
        ]);
    }

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
        
        $user = $request->user();

        // Add the payment method
        $payment_method = [
            'id' => uniqid(),
            'payment_type' => $request->payment_type,
            'expiry_date' => $request->expiry_date,
            'cvv' => $this->encrypt($request->cvv),
            'card_number' => $this->encrypt($request->card_number),
        ];

        // push to payment_methods
        $user->push('payment_methods', $payment_method);

        return response()->json([
            'status' => 'success',
            'message' => 'Payment method added successfully.',
        ], 201);
    }

    public function update(UpdatePaymentRequest $request, $id) 
    {
        $user = request()->user();
        $payment_methods = $user->payment_methods;

        // Check if the payment method exists
        if ($payment_methods == null || empty($payment_methods)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment method not found.',
            ], 404);
        }
        $method = null;
        foreach ($payment_methods as $key => $payment_method) {
            if ($payment_method['id'] == $id) {
                $method = $payment_method;
                break;
            }
        }
        if ($method == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment method not found.',
            ], 404);
        }

        // Update the payment method
        $user->raw()->updateOne(
            ['email' => $user->email],
            ['$set' => [
                'payment_methods.$[elem].cvv' => $request->cvv,
                'payment_methods.$[elem].expiry_date' => $request->expiry_date,
            ]],
            ['arrayFilters' => [['elem.id' => $id]]]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Payment method updated successfully.',
            'user' => $user,
            'id' => $id,
            'method' => $method,
        ]);
    }

    public function delete($id)
    {
        $user = request()->user();
        $payment_methods = $user->payment_methods;

        // Check if the payment method exists
        if ($payment_methods == null || empty($payment_methods)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment method not found.',
            ], 404);
        }

        $user->pull('payment_methods', [
            'id' => intval($id),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Payment method deleted successfully.',
        ]);
    }

    private function hide($number) {
        return substr($number, 0, 4) . '****' . substr($number, -2);
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
