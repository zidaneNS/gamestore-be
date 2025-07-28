<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function checkout(Request $request, Product $product)
    {
        $order = Order::create([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'status' => 'pending'
        ]);

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->id,
                'gross_amount' => $product->price
            ),
            'customer_details' => array(
                'name' => $order->user->name,
                'email' => $order->user->email
            )
        );

        $snapToken = Snap::getSnapToken($params);

        return response(array(
            'snapToken' => $snapToken,
        ), 201);
    }
}
