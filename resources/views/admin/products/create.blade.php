@extends('layouts.admin')

@section('title', 'المنتجات')

@section('content')
    <div class="container">
        <h3>إضافة منتج جديد</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">اسم المنتج</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="form-group mt-2">
                <label for="description">الوصف</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="form-group mt-2">
                <label for="price">السعر</label>
                <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
            </div>

            <div class="form-group mt-2">
                <label for="category_id">التصنيف</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="0">-- اختر تصنيفًا --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mt-2">
                <label for="image">صورة المنتج</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button class="btn btn-success mt-3">حفظ المنتج</button>
        </form>
    </div>
@endsection