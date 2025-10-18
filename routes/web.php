<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use Twilio\Rest\Client;



//cart
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});

//products
Route::get('/', [ProductController::class, 'index'])->name('products.index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//orsers
Route::get('/my-orders', [OrderController::class, 'myOrders'])
    ->middleware('auth')
    ->name('orders.my');
Route::get('/orders/{order}', [OrderController::class, 'show'])
    ->middleware('auth')
    ->name('orders.show');


//checkout
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');


//payment
Route::get('/payment/mock/{orderId}', [PaymentController::class, 'mockPage'])->name('payment.mock');
Route::post('/payment/mock/confirm', [PaymentController::class, 'mockConfirm'])->name('payment.mock.confirm');

//admin
Route::prefix('admin')->middleware(['auth', 'is_admin'])->name('admin.')->group(function () {
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products/create', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}/update', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}/delete', [AdminProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/create', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}/update', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}/delete', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.readAll');
    Route::get('/notifications/latest', [NotificationController::class, 'latest'])
        ->name('notifications.latest');
    //customers
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers/create', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/show/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::get('/customers/{customer}/update', [CustomerController::class, 'update'])->name('customers.update');
    Route::get('/customers/{customer}/delete', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::get('/customers/{customer}/print', [CustomerController::class, 'print'])->name('customers.print');


});




Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// test

Route::get('/test-whatsapp', function() {
    $sid = env('TWILIO_SID');
    $token = env('TWILIO_TOKEN');
    $from = env('TWILIO_WHATSAPP_FROM');
    
    $to = 'whatsapp:+201016440812'; // ضع رقمك مع كود الدولة
    $message = "هذه رسالة تجريبية من Laravel باستخدام Twilio Sandbox!";

    try {
        $client = new Client($sid, $token);
        $client->messages->create($to, [
            'from' => $from,
            'body' => $message
        ]);
        return "تم إرسال الرسالة بنجاح ✅";
    } catch (\Exception $e) {
        return "حدث خطأ: " . $e->getMessage();
    }
});

// test