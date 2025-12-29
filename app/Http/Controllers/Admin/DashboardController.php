<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class DashboardController extends Controller
{
    public function index()
    {
        $ordersCount = Order::count();
        $productsCount = Product::count();
        $categoriesCount = Category::count();
        $salesTotal = Order::where('status', 'paid')->sum('total');
        $notifications = auth()->user()->notifications()->take(5)->get();
        $latestOrders = Order::with('customer')
            ->latest()
            ->take(5)
            ->get();
        return view('admin.dashboard', compact(
            'ordersCount',
            'productsCount',
            'categoriesCount',
            'salesTotal',
            'notifications',
            'latestOrders'
        ));
    }


    public function login()
    {
        return view('admin.auth.login');
    }



    public function logout(Request $request)
    {
        // معرفة هل كان المستخدم أدمن قبل تسجيل الخروج
        $isAdmin = auth()->check() && auth()->user()->role === 'admin';

        Auth::logout();

        Cookie::queue(Cookie::forget(Auth::getRecallerName()));

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // تحديد الوجهة بعد تسجيل الخروج
        if ($isAdmin) {
            return redirect('/admin/login');
        }

        return redirect('/login'); // للعميل
    }

}
