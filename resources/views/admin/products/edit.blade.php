@extends('layouts.admin')

@section('title', 'المنتجات')

@section('content')
    <div class="container">
        <h3>تعديل منتج: {{ $product->name }}</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>اسم المنتج</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>

                   <div class="form-group">
                <label>الوصف</label>
                <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="form-group">
                <label>السعر</label>
                <input type="number" step="0.01" name="price" class="form-control"
                    value="{{ old('price', $product->price) }}" required>
            </div>

              <div class="form-group mb-t">
                <label for="category_id">التصنيف</label>
                <div class="d-flex">
                    <select name="category_id" id="categorySelect" class="form-control me-2" required>
                        <option value="">اختر تصنيف</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label>صورة المنتج الحالية</label><br>
                @if($product->image)
                    <img src="{{ asset('uploads/products/' . $product->image) }}" width="150">
                @else
                    لا توجد صورة
                @endif
            </div>

            <div class="form-group mt-2">
                <label>تحديث الصورة (اختياري)</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button class="btn btn-primary mt-3">تحديث المنتج</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mt-3">رجوع</a>
        </form>
    </div>
@endsection