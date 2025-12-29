<?php

namespace App\Services;

use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;

class SmsService
{
    protected $client;

    public function __construct()
    {
        $basic = new Basic(
            config('services.vonage.key'),
            config('services.vonage.secret')
        );

        $this->client = new Client($basic);
    }

    public function sendOTP($phoneNumber, $otp)
    {
        try {
            $message = new SMS(
                $phoneNumber,                              // To
                config('services.vonage.from'),            // From
                "كود التفعيل الخاص بك: {$otp}"           // Message
            );

            $response = $this->client->sms()->send($message);

            $current = $response->current();

            if ($current->getStatus() == 0) {
                return $current->getMessageId();
            } else {
                throw new \Exception('Vonage Error: ' . $current->getStatus());
            }

        } catch (\Exception $e) {
            \Log::error('Vonage SMS Error: ' . $e->getMessage());
            throw new \Exception('فشل إرسال الرسالة: ' . $e->getMessage());
        }
    }
}