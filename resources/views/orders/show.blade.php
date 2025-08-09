@extends('layouts.app')

@section('content')
<div class="container">
    <h2>تفاصيل الطلب رقم {{ $order->id }}</h2>
    
    <p><strong>تاريخ:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
    <p><strong>الحالة:</strong> {{ $order->status ?? 'قيد المراجعة' }}</p>
    <p><strong>الإجمالي:</strong> {{ number_format($order->total, 2) }} ج.م</p>

    <hr>
    <h4>معلومات العميل:</h4>
    <p><strong>الاسم:</strong> {{ $order->name }}</p>
    <p><strong>الهاتف:</strong> {{ $order->phone }}</p>
    <p><strong>العنوان:</strong> {{ $order->address }}</p>

    <hr>
    <h4 class="mt-4">المنتجات:</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>المنتج</th>
                <th>الكمية</th>
                <th>السعر</th>
                <th>الإجمالي الفرعي</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>
                        @if ($item->product && $item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="صورة المنتج" width="50" class="me-2">
                        @endif
                        {{ $item->product->name ?? $item->product_name }}
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 2) }} ج.م</td>
                    <td>{{ number_format($item->price * $item->quantity, 2) }} ج.م</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        <a href="#" onclick="window.print()" class="btn btn-secondary">🖨️ طباعة</a>
        <a href="{{ route('orders.my') }}" class="btn btn-primary">🔙 العودة للطلبات</a>
    </div>
</div>
@endsection
