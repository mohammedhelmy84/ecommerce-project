@extends('layouts.admin')

@section('title', 'التصنيفات')

@section('content')
    <div class="container">
        <h3>تعديل التصنيف</h3>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="name">اسم التصنيف</label>
                <input type="text" name="name" value="{{ $category->name }}" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="slug">الرابط</label>
                <input type="text" name="slug" value="{{ $category->slug }}" class="form-control" required>
            </div>

            <button class="btn btn-success">تحديث</button>
        </form>
    </div>
@endsection