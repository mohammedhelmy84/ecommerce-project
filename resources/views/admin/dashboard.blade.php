@extends('layouts.admin')

@section('title', 'لوحة التحكم')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $ordersCount }}</h3>
                    <p>عدد الطلبات</p>
                </div>
                <div class="icon"><i class="fas fa-shopping-cart"></i></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $productsCount }}</h3>
                    <p>عدد المنتجات</p>
                </div>
                <div class="icon"><i class="fas fa-box"></i></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $categoriesCount }}</h3>
                    <p>عدد التصنيفات</p>
                </div>
                <div class="icon"><i class="fas fa-tags"></i></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ number_format($salesTotal, 2) }} ج.م</h3>
                    <p>إجمالي المبيعات</p>
                </div>
                <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
            </div>
        </div>
    </div>
@endsection
