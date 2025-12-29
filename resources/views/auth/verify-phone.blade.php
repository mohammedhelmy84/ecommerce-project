@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">التحقق من رقم الموبايل</div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label>رقم الموبايل</label>
                            <input type="text" id="phone" class="form-control" placeholder="+201012345678" dir="ltr">
                            <small class="text-muted">مثال: +201012345678</small>
                        </div>

                        <button class="btn btn-primary w-100" onclick="sendOTP()">
                            إرسال كود التفعيل
                        </button>

                        <div id="otpSection" style="display: none;" class="mt-4">
                            <div class="form-group mb-3">
                                <label>كود التفعيل</label>
                                <input type="text" id="otp" class="form-control" placeholder="123456" maxlength="6">
                            </div>
                            <button class="btn btn-success w-100" onclick="verifyOTP()">
                                تحقق
                            </button>
                        </div>

                        <div id="message" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        async function sendOTP() {
            const phone = document.getElementById('phone').value;
            const messageDiv = document.getElementById('message');

            if (!phone || !phone.startsWith('+')) {
                messageDiv.innerHTML = '<div class="alert alert-danger">من فضلك أدخل رقم صحيح بالصيغة الدولية</div>';
                return;
            }

            messageDiv.innerHTML = '<div class="alert alert-info">جاري الإرسال...</div>';

            try {
                const response = await axios.post('/api/send-otp', { phone });

                document.getElementById('otpSection').style.display = 'block';
                messageDiv.innerHTML = '<div class="alert alert-success">✅ تم إرسال الكود: ' + response.data.debug_otp + '</div>';
            } catch (error) {
                messageDiv.innerHTML = '<div class="alert alert-danger">❌ ' +
                    (error.response?.data?.message || 'فشل الإرسال') + '</div>';
            }
        }

            /*
            async function verifyOTP() {
                const phone = document.getElementById('phone').value;
                const otp = document.getElementById('otp').value;
                const messageDiv = document.getElementById('message');

                if (!otp || otp.length !== 6) {
                    messageDiv.innerHTML = '<div class="alert alert-danger">من فضلك أدخل كود مكون من 6 أرقام</div>';
                    return;
                }

                messageDiv.innerHTML = '<div class="alert alert-info">جاري التحقق...</div>';

                try {
                    const response = await axios.post('/api/verify-otp', { phone, otp });

                    messageDiv.innerHTML = '<div class="alert alert-success">✅ تم التحقق بنجاح! جاري التحويل...</div>';

                    setTimeout(() => {
                        window.location.href = "{{ url('register-details') }}";
                    }, 1500);
                } catch (error) {
            messageDiv.innerHTML = '<div class="alert alert-danger">❌ ' +
                (error.response?.data?.message || 'كود خاطئ') + '</div>';
        }
            }
            */

        async function verifyOTP() {
            const phone = document.getElementById('phone').value;
            const otp = document.getElementById('otp').value;
            const messageDiv = document.getElementById('message');

            if (!otp || otp.length !== 6) {
                messageDiv.innerHTML = '<div class="alert alert-danger">من فضلك أدخل كود مكون من 6 أرقام</div>';
                return;
            }

            messageDiv.innerHTML = '<div class="alert alert-info">جاري التحقق...</div>';

            try {
                const response = await axios.post('/api/verify-otp', { phone, otp });

                messageDiv.innerHTML = '<div class="alert alert-success">✅ تم التحقق بنجاح! جاري التحويل...</div>';

                // ✅ إعادة التوجيه بعد نجاح التحقق
                window.location.href = "/register-details"; // أو route Laravel إذا مستخدم route helper
            } catch (error) {
                messageDiv.innerHTML = '<div class="alert alert-danger">❌ ' +
                    (error.response?.data?.message || 'كود خاطئ') + '</div>';
            }
        }

    </script>
@endsection