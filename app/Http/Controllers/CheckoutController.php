<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required',
            'address' => 'required|string',
        ]);

        $cart = session('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'total' => $total,
        ]);

        foreach ($cart as $product_id => $item) {
            $order->items()->create([
                'product_id' => $item['product_id'], // الآن موجود داخل كل عنصر
                'product_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        // حذف العربة
        session()->forget('cart');
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->delete();
        }

        // return redirect()->route('cart.index')->with('success', 'تم إتمام الطلب بنجاح!');
        return redirect()->route('payment.mock', $order->id);

    }
}
