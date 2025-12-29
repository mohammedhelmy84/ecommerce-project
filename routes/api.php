<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Otp;
use App\Services\SmsService;

Route::post('/send-otp', function (Request $request) {
    try {
        $phone = $request->input('phone');

        if (!$phone) {
            return response()->json(['status' => 'error', 'message' => 'Phone required'], 400);
        }

        $otp = rand(100000, 999999);

        Otp::updateOrCreate(
            ['phone' => $phone],
            ['otp' => $otp, 'expires_at' => now()->addMinutes(5)]
        );

        // إرسال SMS
        try {
            $smsService = app(SmsService::class);
            $smsService->sendOTP($phone, $otp);
        } catch (\Exception $e) {
            \Log::error('SMS Error: ' . $e->getMessage());
        }

        return response()->json([
            'status' => 'otp_sent',
            'message' => 'تم إرسال الكود',
            'debug_otp' => $otp // للتجربة
        ]);

    } catch (\Exception $e) {
        \Log::error('OTP Error: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

Route::post('/verify-otp', function (Request $request) {
    $phone = $request->input('phone');
    $otp = $request->input('otp');

    $otpRecord = Otp::where('phone', $phone)
        ->where('otp', $otp)
        ->where('expires_at', '>', now())
        ->first();

    if ($otpRecord) {
        $otpRecord->delete();

        session([
            'verified_phone_number' => $phone,
            'phone_verified_at' => now()
        ]);

        return response()->json([
            'status' => 'verified',
            'message' => 'تم التحقق بنجاح'
        ]);
    }

    return response()->json([
        'status' => 'error',
        'message' => 'كود خاطئ أو منتهي'
    ], 400);
})->middleware('web');

