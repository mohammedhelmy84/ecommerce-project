@extends('layouts.admin')

@section('title', 'تعديل عميل')

@section('content')
    <div class="container">
        <h3>تعديل بيانات العميل</h3>

        <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">الاسم</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name', $customer->name) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $customer->email) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">الهاتف</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">العنوان</label>
                <textarea name="address" class="form-control">{{ old('address', $customer->address) }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">تحديث</button>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
@endsection