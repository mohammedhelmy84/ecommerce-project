@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        التحقق من رقم الهاتف
                    </div>

                    <div class="card-body">

                        {{-- رقم الهاتف --}}
                        <div class="mb-3">
                            <label class="form-label">رقم الهاتف</label>
                            <input id="phone" type="text" class="form-control" placeholder="+201012345678">
                        </div>

                        <div id="recaptcha-container"></div>

                        {{-- إرسال OTP --}}
                        <button class="btn btn-secondary w-100 mb-3" onclick="sendOTP()">
                            إرسال كود التحقق
                        </button>

                        {{-- إدخال الكود --}}
                        <div class="mb-3">
                            <label class="form-label">ادخل كود OTP</label>
                            <input id="otp" type="text" class="form-control" placeholder="123456">
                        </div>

                        {{-- تأكيد الكود --}}
                        <button class="btn btn-success w-100" onclick="verifyOTP()">
                            تأكيد الكود والمتابعة
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Firebase --}}
    <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-auth-compat.js"></script>

    <script>
        // Config الحقيقي الخاص بمشروعك Firebase
        const firebaseConfig = {
            apiKey: "AIzaSyA-euvplvYwDKR3WyBgC24eyJbtcSk8mQs",
            authDomain: "e-commerce-6e5e6.firebaseapp.com",
            projectId: "e-commerce-6e5e6",
            storageBucket: "e-commerce-6e5e6.firebasestorage.app",
            messagingSenderId: "636322492923",
            appId: "1:636322492923:web:cb8168f5499a8e5766db5e",
            measurementId: "G-XR0RXJNR1V"
        };

        firebase.initializeApp(firebaseConfig);
        const auth = firebase.auth();
        let confirmationResult;

        // إرسال OTP
        function sendOTP() {
            const phone = document.getElementById('phone').value.trim();

            if (!phone) {
                alert("يرجى إدخال رقم الهاتف");
                return;
            }

            // تفعيل reCAPTCHA
            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier(
                'recaptcha-container',
                { 'size': 'invisible' }
            );

            auth.signInWithPhoneNumber(phone, window.recaptchaVerifier)
                .then(result => {
                    confirmationResult = result;
                    alert("✅ تم إرسال كود التحقق إلى رقمك");
                })
                .catch(error => {
                    alert("خطأ: " + error.message);
                    console.error(error);
                });
        }

        // التحقق من OTP
        function verifyOTP() {
            const code = document.getElementById('otp').value.trim();

            if (!code) {
                alert("يرجى إدخال كود OTP");
                return;
            }

            confirmationResult.confirm(code)
                .then(result => {
                    const user = result.user;

                    user.getIdToken().then(token => {

                        // أرسل بيانات التحقق للسيرفر
                        fetch("{{ route('verify.phone.confirm') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                phone: document.getElementById('phone').value,
                                idToken: token

                            })
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === "verified") {
                                    window.location.href = "{{ route('register-details') }}";
                                } else {
                                    alert("خطأ أثناء التحقق!");
                                }
                            });
                    });
                })
                .catch(error => {
                    alert("خطأ في كود OTP: " + error.message);
                    console.error(error);
                });
        }
    </script>

@endsection