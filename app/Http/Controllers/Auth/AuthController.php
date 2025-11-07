<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required'],
        ]);
        $remember = $request->has('remember'); // لضمان boolean

        if (Auth::attempt($credentials, $remember)) {
            return redirect()->route('products.index');
        }

        return back()->withErrors(['phone' => 'بيانات الدخول غير صحيحة']);
    }

   public function logout(Request $request)
{
    Auth::logout();

    // حذف cookie الخاص بتذكرني
    Cookie::queue(Cookie::forget(Auth::getRecallerName()));

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
}
}
