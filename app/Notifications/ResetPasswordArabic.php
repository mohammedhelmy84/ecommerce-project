<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordArabic extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
                    ->subject('إعادة تعيين كلمة المرور')
                    ->greeting('مرحباً!')
                    ->line('لقد استلمنا طلب إعادة تعيين كلمة المرور لحسابك.')
                    ->action('إعادة تعيين كلمة المرور', $url)
                    ->line('إذا لم تطلب إعادة تعيين كلمة المرور، تجاهل هذه الرسالة.');
    }
}
