@extends('layouts.admin')

@section('title', 'إضافة عميل جديد')

@section('content')
    <div class="container">
        <h3>إضافة عميل جديد</h3>

        <form action="{{ route('admin.customers.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">الاسم</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">الهاتف</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">العنوان</label>
                <textarea name="address" class="form-control">{{ old('address') }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">حفظ</button>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
@endsection