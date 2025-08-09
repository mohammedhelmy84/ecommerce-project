@extends('layouts.admin')

@section('title', 'التصنيفات')

@section('content')
    <div class="container">
        <h3>إضافة تصنيف</h3>

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="name">اسم التصنيف</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="slug">الرابط</label>
                <input type="text" name="slug" class="form-control" required>
            </div>

            <button class="btn btn-primary">حفظ</button>
        </form>
    </div>
@endsection