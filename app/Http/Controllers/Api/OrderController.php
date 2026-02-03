<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;


class OrderController extends Controller
{
    public function index()
{
    return Order::with('user')->latest()->get();
}

public function store(Request $request)
{
    $data = $request->validate([
        'items' => 'required|array'
    ]);

    $user = $request->user();

    $order = Order::create([
        'user_id' => $user->id,
        'total' => 0,
        'status' => 'pending'
    ]);

    $total = 0;

    foreach ($data['items'] as $item) {
        $product = Product::findOrFail($item['product_id']);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $item['quantity'],
            'price' => $product->price
        ]);

        $total += $product->price * $item['quantity'];
    }

    $order->update(['total' => $total]);

    return response()->json($order->load('items.product'));
}


public function update(Request $request, Order $order)
{
    $request->validate([
        'status' => 'required|string'
    ]);

    $order->update(['status' => $request->status]);

    return response()->json($order);
}


}
