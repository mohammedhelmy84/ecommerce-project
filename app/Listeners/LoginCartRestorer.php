<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;

class LoginCartRestorer
{
    public function handle(Login $event): void
    {
        $cart = Cart::where('user_id', $event->user->id)->first();
        if ($cart) {
            Session::put('cart', $cart->cart_data);
        }
    }
}
