<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Governorate;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Otp;
use App\Services\SmsService;

class RegisterController extends Controller
{
    protected $redirectTo = '/';
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->middleware('guest')->except(['sendOtp', 'verifyOtp']);
        $this->smsService = $smsService;
    }

    public function showPhoneForm()
    {
        return view('auth.verify-phone');
    }

  


    public function showDetailsForm()
    {
        // ✅ تحقق من verified_phone_number
        if (!session()->has('verified_phone_number')) {
            return redirect()->route('verify.phone');
        }

        $governorates = Governorate::all();
        return view('auth.register-details', compact('governorates'));
    }

    public function getCities(Request $request)
    {
        $cities = City::where('governorate_id', $request->gov_id)->get();
        return response()->json($cities);
    }

    public function storeDetails(Request $request)
    {
        // ✅ تحقق من verified_phone_number
        if (!session()->has('verified_phone_number')) {
            abort(403, "Phone not verified!");
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|min:6|confirmed',
            'email' => 'nullable|email|unique:users,email',
            'address' => 'required|string|max:255',
            'city' => 'nullable|string|max:100',
            'governorate' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $phone = session('verified_phone_number');
        $isFirstUser = User::count() === 0;

        $user = User::create([
            'name' => $request->name,
            'phone' => $phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'city' => $request->city,
            'governorate' => $request->governorate,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'role' => $isFirstUser ? 'admin' : 'customer',
            'is_admin' => $isFirstUser ? 1 : 0,
            'is_phone_verified' => true
        ]);

        // تنظيف الجلسة
        session()->forget(['verified_phone_number', 'phone_verified_at']);

        auth()->login($user);

        return redirect('/')->with('success', '✅ تم إنشاء الحساب بنجاح');
    }

    protected function create(array $data)
    {
        abort(404);
    }
}