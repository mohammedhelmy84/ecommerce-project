@extends('layouts.app')

@section('title', 'المنتجات')

@section('content')
    <h2 class="mb-4">قائمة المنتجات</h2>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('uploads/products/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 300px !important;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                          <p class="card-text">{{ $product->price }} ج.م</p>
                       @auth
    <form action="{{ route('cart.add') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $product->id }}">
        <button type="submit" class="btn btn-success w-100">🛒 أضف إلى العربة</button>
    </form>
@else
    <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100">
        🔐 سجّل الدخول لإضافة للعربة
    </a>
@endauth
                    </div>
                </div>
            </div>
        @empty
            <p>لا توجد منتجات متاحة.</p>
        @endforelse
    </div>
@endsection
