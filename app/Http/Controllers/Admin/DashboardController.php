<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $ordersCount = Order::count();
        $productsCount = Product::count();
        $categoriesCount = Category::count();
        $salesTotal = Order::where('status', 'paid')->sum('total');

        return view('admin.dashboard', compact(
            'ordersCount',
            'productsCount',
            'categoriesCount',
            'salesTotal'
        ));
    }
}
