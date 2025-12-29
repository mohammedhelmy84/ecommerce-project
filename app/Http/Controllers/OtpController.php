<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp;
use App\Services\SmsService;

class OtpController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function send(Request $request)
    {
        $request->validate(['phone' => 'required|string']);

        $otp = rand(100000, 999999);

        Otp::updateOrCreate(
            ['phone' => $request->phone],
            ['otp' => $otp, 'expires_at' => now()->addMinutes(5)]
        );

        try {
            $this->smsService->sendOTP($request->phone, $otp);
            return response()->json(['status' => 'otp_sent', 'message' => 'تم إرسال الكود']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function verify(Request $request)
    {
        $request->validate(['phone' => 'required|string', 'otp' => 'required|numeric']);

        $otpRecord = Otp::where('phone', $request->phone)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if ($otpRecord) {
            $otpRecord->delete();
            session(['verified_phone_number' => $request->phone, 'phone_verified_at' => now()]);
            return response()->json(['status' => 'verified', 'message' => 'تم التحقق بنجاح']);
        }

        return response()->json(['status' => 'error', 'message' => 'كود خاطئ أو منتهي'], 400);
    }
}