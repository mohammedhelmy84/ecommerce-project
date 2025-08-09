@extends('layouts.admin')

@section('title', 'المنتجات')

@section('content')
<div class="container">
    <h3>قائمة المنتجات</h3>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">إضافة منتج جديد</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>الصورة</th>
                <th>الاسم</th>
                <th>السعر</th>
                <th>تاريخ الإضافة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>
                    @if($product->image)
                        <img src="{{ asset('uploads/products/' . $product->image) }}" width="60" height="60" alt="صورة المنتج">
                    @else
                        لا يوجد
                    @endif
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ number_format($product->price, 2) }} ج.م</td>
                <td>{{ $product->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">تعديل</a>

                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">حذف</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">لا توجد منتجات حاليًا.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
