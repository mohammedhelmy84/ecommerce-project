<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>بيانات العميل</title>
    <style>
        @font-face {
            font-family: 'amiri';
            src: url('{{ public_path('fonts/Amiri-Regular.ttf') }}') format('truetype');
        }

        body {
            font-family: 'amiri', sans-serif;
            direction: rtl;
            text-align: right;
        }
    </style>

</head>

<body>

    <div class="title">بيانات العميل</div>

    <div class="info"><span class="label">الاسم:</span> {{ $customer->name }}</div>
    <div class="info"><span class="label">البريد الإلكتروني:</span> {{ $customer->email ?? 'لا يوجد' }}</div>
    <div class="info"><span class="label">رقم الهاتف:</span> {{ $customer->phone ?? 'لا يوجد' }}</div>
    <div class="info"><span class="label">العنوان:</span> {{ $customer->address ?? 'لا يوجد' }}</div>
    <div class="info"><span class="label">تاريخ الإنشاء:</span> {{ $customer->created_at->format('Y-m-d H:i') }}</div>

</body>

</html>