<?php

namespace App\Notifications;

use App\Models\Order; // مهم
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; // اختياري
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification /* implements ShouldQueue */ // لو حابب تشغّلها في الطابور
{
    use Queueable;

    public function __construct(public Order $order) // نمرر الطلب هنا
    {
        //
    }

    /**
     * قنوات الإرسال
     */
    public function via(object $notifiable): array
    {
        return ['database']; // نخزّن في قاعدة البيانات
    }

    /**
     * البيانات المخزنة في جدول notifications (عمود data)
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title'       => 'طلب جديد',
            'message'     => 'تم إنشاء طلب جديد من العميل: ' . ($this->order->user->name ?? 'عميل'),
            'order_id'    => $this->order->id,
            'total'       => $this->order->total ?? null,
            'status'      => $this->order->status ?? null,
            'created_at'  => $this->order->created_at?->toDateTimeString(),
        ];
    }

    /**
     * في حال أضفت قناة البريد لاحقًا
     */
    public function toArray(object $notifiable): array
    {
        return []; // اختياري
    }
}
