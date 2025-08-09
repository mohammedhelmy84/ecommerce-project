<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class PaymentController extends Controller
{
    // عرض صفحة الدفع الوهمية
    public function mockPage($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('payment.mock', [
            'amount' => $order->total,
            'orderId' => $order->id,
        ]);
    }

    // تأكيد الدفع
    public function mockConfirm(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->status = 'paid'; // غيّر الحالة إلى مدفوع
        $order->save();

        return redirect('/')->with('success', 'تم الدفع بنجاح (وهمي)');
    }
}
