@extends('layouts.admin')

@section('title', 'لوحة التحكم')

@section('content')
    <div class="container-fluid mt-4">

        <div class="row g-3">
            <div class="col-md-3">
                <div class="card text-white bg-primary p-3">
                    <div>
                        <h5 class="card-title">عدد الطلبات</h5>
                        <p class="card-text fs-4">{{ $ordersCount }}</p>
                    </div>
                    <img src="https://cdn-icons-gif.flaticon.com/8121/8121335.gif" alt="طلبات">
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success p-3">
                    <div>
                        <h5 class="card-title">المبيعات</h5>
                        <p class="card-text fs-4">$5400</p>
                    </div>
                    <img src="https://cdn-icons-gif.flaticon.com/8121/8121323.gif" alt="مبيعات">
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning p-3">
                    <div>
                        <h5 class="card-title">العملاء</h5>
                        <p class="card-text fs-4">350</p>
                    </div>
                    <img src="https://cdn-icons-gif.flaticon.com/8121/8121335.gif" alt="عملاء">
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger p-3">
                    <div>
                        <h5 class="card-title">المرتجعات</h5>
                        <p class="card-text fs-4">15</p>
                    </div>
                    <img src="https://cdn-icons-gif.flaticon.com/8121/8121323.gif" alt="مرتجعات">
                </div>
            </div>
        </div>

        <h3 class="card-header">أحدث الطلبات</h3>
        <div class="table-responsive">
            <table class="table table-striped mb-0 w-100">
                <thead class="table-dark">
                    <tr>
                        <th>رقم الطلب</th>
                        <th>العميل</th>
                        <th>المبلغ</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestOrders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->customer->name ?? '---' }}</td>
                            <td>${{ number_format($order->total, 2) }}</td>
                            <td>
                                @if($order->status == 'completed')
                                    ✅ مكتمل
                                @elseif($order->status == 'pending')
                                    ⏳ قيد المعالجة
                                @elseif($order->status == 'canceled')
                                    ❌ ملغي
                                @else
                                    🔘 {{ $order->status }}
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">لا توجد طلبات بعد</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


    </div>
@endsection