<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->with('orderItems.product') // إذا استخدمت علاقة orderItems
            ->get();

        return view('orders.my-orders', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }
}
