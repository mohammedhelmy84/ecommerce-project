<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "product_id" => $product->id, // أضفنا الـ ID هنا
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => 1,
                "image" => $product->image
            ];

        }

        session()->put('cart', $cart);
        if (Auth::check()) {
            Cart::updateOrCreate(
                ['user_id' => Auth::id()],
                ['cart_data' => $cart]
            );
        }

        return redirect()->route('cart.index')->with('success', 'تمت إضافة المنتج إلى العربة');
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            if (Auth::check()) {
                Cart::updateOrCreate(
                    ['user_id' => Auth::id()],
                    ['cart_data' => session('cart')]
                );
            }

            return redirect()->route('cart.index')->with('success', 'تم تحديث الكمية');
        }
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart');
        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
            if (Auth::check()) {
                Cart::updateOrCreate(
                    ['user_id' => Auth::id()],
                    ['cart_data' => session('cart')]
                );
            }

        }
        return redirect()->route('cart.index')->with('success', 'تم حذف المنتج من العربة');
    }

    public function clear()
    {
        session()->forget('cart');
        if (Auth::check()) {
            Cart::updateOrCreate(
                ['user_id' => Auth::id()],
                ['cart_data' => session('cart')]
            );
        }

        return redirect()->route('cart.index')->with('success', 'تم تفريغ العربة بنجاح');
    }

}
