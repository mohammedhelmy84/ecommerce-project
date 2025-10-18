<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Twilio\Rest\Client;

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
        $order->status = 'paid';
        $order->save();
    
        // إرسال رسالة WhatsApp
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $from = env('TWILIO_WHATSAPP_FROM');
        $to = 'whatsapp:+2' . $order->phone; // يجب أن يكون مسجّل في Sandbox
        $message = "مرحبًا {$order->name}, تم تأكيد طلبك رقم #{$order->id} بمبلغ {$order->total} ج.م ✅";

        try {
            $client = new Client($sid, $token);
            $client->messages->create($to, [
                'from' => $from,
                'body' => $message
            ]);
        } catch (\Exception $e) {
            \Log::error("WhatsApp Error: " . $e->getMessage());
        }

        return redirect('/')->with('success', 'تم الدفع بنجاح (وهمي) وسيتم إرسال رسالة WhatsApp');
    }
}
