@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">{{ __('استكمال بيانات التسجيل') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register-details.store') }}">
                            @csrf

                            {{-- عرض رقم الهاتف الذي تم التحقق منه --}}
                            <div class="alert alert-success text-center">
                                ✅ تم التحقق من رقم هاتفك بنجاح: <strong>{{ session('verified_phone_number') }}</strong>
                            </div>

                            {{-- الاسم --}}
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">الاسم الكامل</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required autofocus>
                                    @error('name')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- البريد الإلكتروني --}}
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">البريد الإلكتروني
                                    (اختياري)</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" placeholder="example@mail.com">
                                    @error('email')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- كلمة المرور --}}
                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">كلمة المرور</label>
                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- تأكيد كلمة المرور --}}
                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">تأكيد كلمة
                                    المرور</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required>
                                </div>
                            </div>

                            {{-- المحافظة --}}
                            <div class="row mb-3">
                                <label for="governorate" class="col-md-4 col-form-label text-md-end">المحافظة</label>
                                <div class="col-md-6">
                                    <select id="governorate" class="form-select @error('governorate') is-invalid @enderror"
                                        name="governorate" required>
                                        <option value="">اختر المحافظة</option>
                                        @foreach($governorates as $gov)
                                            <option value="{{ $gov->id }}" {{ old('governorate') == $gov->id ? 'selected' : '' }}>
                                                {{ $gov->name[app()->getLocale()] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('governorate')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- المدينة --}}
                            <div class="row mb-3">
                                <label for="city" class="col-md-4 col-form-label text-md-end">المدينة</label>
                                <div class="col-md-6">
                                    <select id="city" name="city" class="form-select @error('city') is-invalid @enderror"
                                        required>
                                        <option value="">اختر المدينة</option>
                                    </select>
                                    @error('city')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            {{-- العنوان --}}
                            <div class="row mb-3">
                                <label for="address" class="col-md-4 col-form-label text-md-end">العنوان بالتفصيل</label>
                                <div class="col-md-6">
                                    <input id="address" type="text"
                                        class="form-control @error('address') is-invalid @enderror" name="address"
                                        value="{{ old('address') }}" required
                                        placeholder="مثلاً: شارع التحرير، الدور الثالث">
                                    @error('address')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <small class="text-muted">اكتب العنوان او تحديده بواسطة الخريطة</small>
                            </div>

                            {{-- خريطة تحديد الموقع --}}
                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end">تحديد الموقع على الخريطة</label>
                                <div class="col-md-12">
                                    <div id="map" style="height: 300px; border-radius: 10px; border: 1px solid #ddd;"></div>
                                    <input type="hidden" name="latitude" id="latitude">
                                    <input type="hidden" name="longitude" id="longitude">
                                    <small class="text-muted">يمكنك سحب العلامة لتحديد موقعك بدقة أو النقر على
                                        الخريطة.</small>
                                </div>
                            </div>

                            {{-- زر التسجيل --}}
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary px-4">
                                        تسجيل الحساب
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- خريطة Leaflet نفس الموجودة عندك --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            // إصلاح تعارض السحب في Chrome
            document.getElementById('map').style.touchAction = 'auto';
            document.getElementById('map').style.cursor = 'grab';

            var map = L.map('map', {
                center: [30.0444, 31.2357],
                zoom: 13,
                zoomControl: true,
                dragging: true,
                scrollWheelZoom: true,
                doubleClickZoom: true,
                boxZoom: true,
                keyboard: true,
                worldCopyJump: true
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            var marker = L.marker([30.0444, 31.2357], { draggable: true }).addTo(map);

            function updateFields(lat, lon) {
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lon;

                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&accept-language=ar`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.display_name) {
                            document.getElementById('address').value = data.display_name;
                        }
                    });
            }

            marker.on('dragend', function (e) {
                var pos = e.target.getLatLng();
                updateFields(pos.lat, pos.lng);
            });

            map.on('click', function (e) {
                marker.setLatLng(e.latlng);
                updateFields(e.latlng.lat, e.latlng.lng);
            });

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (pos) {
                    var lat = pos.coords.latitude;
                    var lon = pos.coords.longitude;
                    map.setView([lat, lon], 15);
                    marker.setLatLng([lat, lon]);
                    updateFields(lat, lon);
                });
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const locale = "{{ app()->getLocale() }}";
    </script>
    <script>
        $('#governorate').on('change', function () {
            var govId = $(this).val();
            if (govId) {
                $.ajax({
                    url: '{{ route("get.cities") }}',
                    type: 'GET',
                    data: { gov_id: govId },
                    success: function (data) {
                        $('#city').empty().append('<option value="">اختر المدينة</option>');
                        $.each(data, function (key, value) {
                            $('#city').append('<option value="' + value.id + '">' + value.name[locale] + '</option>');
                        });
                    }
                });
            } else {
                $('#city').empty().append('<option value="">اختر المدينة</option>');
            }
        });
    </script>
@endsection