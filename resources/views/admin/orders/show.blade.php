@extends('layouts.admin')

@section('title', 'الطلبات')

@section('content')
<div class="container">
    {{-- ✅ رسالة النجاح --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
        </div>
    @endif

    {{-- ✅ زر الرجوع --}}
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mb-3">← رجوع إلى الطلبات</a>

    <h3>تفاصيل الطلب #{{ $order->id }}</h3>
    <p><strong>اسم العميل:</strong> {{ $order->user->name ?? 'زائر' }}</p>
    <p><strong>الهاتف:</strong> {{ $order->phone }}</p>
    <p><strong>العنوان:</strong> {{ $order->address }}</p>
    <p><strong>الإجمالي:</strong> {{ number_format($order->total, 2) }} ج.م</p>
    <p><strong>الحالة الحالية:</strong> {{ $order->status ?? 'قيد المراجعة' }}</p>

    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="mb-4">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label>تغيير الحالة:</label>
            <select name="status" class="form-control" required>
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>تم الدفع</option>
                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>تم التوصيل</option>
            </select>
        </div>
        <button class="btn btn-primary mt-2">تحديث</button>
    </form>

    <h5>المنتجات</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>المنتج</th>
                <th>الكمية</th>
                <th>السعر</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 2) }} ج.م</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
