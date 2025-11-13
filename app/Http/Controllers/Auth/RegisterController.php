<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Governorate;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /*
    |--------------------------------------------------------------------------
    | 1) صفحة إدخال رقم الموبايل
    |--------------------------------------------------------------------------
    */
    public function showPhoneForm()
    {
        return view('auth.verify-phone');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string'
        ]);

        return response()->json(['status' => 'otp_sent']);
    }

    /*
    |--------------------------------------------------------------------------
    | 2) تأكيد OTP والتخزين في الجلسة
    |--------------------------------------------------------------------------
    */
    public function confirmOtp(Request $request)
    {
        $request->validate([
            'idToken' => 'required|string',
            'phone' => 'required|string'
        ]);

        $factory = (new Factory)->withServiceAccount(env('FIREBASE_CREDENTIALS'));
        $auth = $factory->createAuth();

        // تحقق من idToken
        try {
            $verified = $auth->verifyIdToken($request->idToken);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Firebase verification failed: ' . $e->getMessage()
            ], 400);
        }

        $uid = $verified->claims()->get('sub');

        // جلب بيانات firebase user
        try {
            $firebaseUser = $auth->getUser($uid);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch Firebase user: ' . $e->getMessage()
            ], 400);
        }

        if ($firebaseUser->phoneNumber !== $request->phone) {
            return response()->json([
                'status' => 'error',
                'message' => 'Phone number does not match.'
            ], 400);
        }

        // ✅ حفظ بيانات التحقق في الجلسة
        session([
            'verified_phone_uid' => $uid,
            'verified_phone_number' => $firebaseUser->phoneNumber,
            'verified_phone_token' => $request->idToken
        ]);

        return response()->json(['status' => 'verified']);
    }

    /*
    |--------------------------------------------------------------------------
    | 3) صفحة استكمال البيانات بعد التحقق
    |--------------------------------------------------------------------------
    */
    public function showDetailsForm()
    {
        if (!session()->has('verified_phone_uid')) {
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

    /*
    |--------------------------------------------------------------------------
    | 4) حفظ بيانات المستخدم وإنشاء الحساب
    |--------------------------------------------------------------------------
    */
    public function storeDetails(Request $request)
    {
        if (!session()->has('verified_phone_uid')) {
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

        // بيانات الهاتف من الجلسة
        $firebase_uid = session('verified_phone_uid');
        $phone = session('verified_phone_number');

        $isFirstUser = User::count() === 0;

        // إنشاء المستخدم
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
            'firebase_uid' => $firebase_uid,
            'role' => $isFirstUser ? 'admin' : 'customer', // إذا أول مستخدم يصبح admin
            'is_admin' => $isFirstUser ? 1 : 0,
            'is_phone_verified' => true

        ]);

        // تنظيف الجلسة
        session()->forget([
            'verified_phone_uid',
            'verified_phone_number',
            'verified_phone_token'
        ]);

        auth()->login($user);

        return redirect('/')->with('success', '✅ تم إنشاء الحساب بنجاح');
    }

    /*
    |--------------------------------------------------------------------------
    | إلغاء طريقة create() الافتراضية حتى لا يتم استدعاؤها
    |--------------------------------------------------------------------------
    */
    protected function create(array $data)
    {
        abort(404);
    }
}
