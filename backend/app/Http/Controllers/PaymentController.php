<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\AddPaymentMethodRequest;
use App\Http\Requests\Payment\UpdatePaymentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Omnipay\Omnipay;
use App\Http\Controllers\PaymentController;
use App\Models\Comic;

class PaymentController extends Controller
{
    private $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true);
    }

    public function pay(Request $request)
    {
        try {
            $response = $this->gateway->purchase([
                'amount' => $request->amount,
                'items' => $request->items,
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => route('payment.success'),
                'cancelUrl' => route('payment.cancel'),
            ])->send();

            return response()->json([
                'status' => 'success',
                'message' => $response->getData(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function checkout(Request $request)
    {
        $user = $request->user();
        
        $items = Comic::whereIn('_id', $request->items)->get();
        $amount = 0;
        $item_formatted = [];

        foreach ($items as $item) {
            $product_price = 0;
            if ($item->has_discount) {
                $product_price = $item->price - ($item->price * $item->discount / 100);
            } else {
                $product_price = $item->price;
            }

            $product = [
                'name' => $item->name,
                'price' => $product_price,
                'description' => $user->_id . ':' . $item->_id,
                'quantity' => 1,
            ];
            array_push($item_formatted, $product);
            $amount += $product_price;
        }

        $request = new Request([
            'amount' => $amount,
            'items' => $item_formatted,
        ]);

        return $this->pay($request);
    }

    public function success(Request $request)
    {
        if (!$request->input('paymentId') || !$request->input('PayerID')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment failed.',
            ]);
        }

        $response = $this->gateway->completePurchase([
            'payer_id' => $request->input('PayerID'),
            'transactionReference' => $request->input('paymentId'),
        ])->send();

        if (!$response->isSuccessful()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment failed.',
                'data' => $response->getData(),
            ]);
        }

        // Do something after payment success
        $data = $response->getData();
        $items = $data['transactions'][0]['item_list']['items'];
        
        $new_items = [];
        $user = null;
        foreach ($items as $item) {
            $user_id = explode(':', $item['description'])[0];
            $comic_id = explode(':', $item['description'])[1];
            if (!$user) {
                $user = User::find($user_id);
            }

            $comic = Comic::find($comic_id);
            $comic->update([
                'buyers' => intval($comic->buyers) + 1,
            ]);

            $new_items[] = $comic_id;
        }
        $vault = $user->vault;
        if ($vault == null) {
            $vault = [];
        }
        $vault = array_merge($vault, $new_items);
        $user->update([
            'vault' => $vault,
            'cart' => [],
        ]);

        return redirect('http://localhost:3000/payment/success');
    }

    public function cancel(Request $request)
    {
        return redirect('http://localhost:3000/payment/cancel');
    }

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

    private function hide($number)
    {
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
