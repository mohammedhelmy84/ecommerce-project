@extends('layouts.admin')

@section('title', 'لوحة التحكم')

@section('content')
          <div class="container-fluid mt-4">

            <div class="row g-3">
                <div class="col-md-3">
                    <div class="card text-white bg-primary p-3">
                        <div>
                            <h5 class="card-title">عدد الطلبات</h5>
                            <p class="card-text fs-4">120</p>
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
                        <img src="https://cdn-icons-gif.flaticon.com/8121/8121363.gif" alt="مبيعات">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning p-3">
                        <div>
                            <h5 class="card-title">العملاء</h5>
                            <p class="card-text fs-4">350</p>
                        </div>
                        <img src="https://cdn-icons-gif.flaticon.com/8121/8121350.gif" alt="عملاء">
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
                        <tr>
                            <td>#1001</td>
                            <td>محمد أحمد</td>
                            <td>$200</td>
                            <td>✅ مكتمل</td>
                        </tr>
                        <tr>
                            <td>#1002</td>
                            <td>سارة علي</td>
                            <td>$150</td>
                            <td>⏳ قيد المعالجة</td>
                        </tr>
                        <tr>
                            <td>#1003</td>
                            <td>أحمد محمد</td>
                            <td>$300</td>
                            <td>❌ ملغي</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
@endsection
