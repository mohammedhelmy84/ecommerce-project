@extends('layouts.admin')

@section('title', 'عرض العميل')

@section('content')
    <div class="container mt-4">

        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-person-circle"></i> معلومات العميل</h5>
                <div>
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-right-circle"></i> رجوع
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>الاسم:</strong> {{ $customer->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>البريد الإلكتروني:</strong> {{ $customer->email ?? 'لا يوجد' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>رقم الهاتف:</strong> {{ $customer->phone ?? 'لا يوجد' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>العنوان:</strong> {{ $customer->address ?? 'لا يوجد' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>تاريخ الإنشاء:</strong> {{ $customer->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="{{ route('admin.customers.print', $customer->id) }}" class="btn btn-secondary">
                    <i class="bi bi-file-earmark-pdf"></i> طباعة PDF
                </a>

                <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i> تعديل
                </a>

                <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('هل أنت متأكد من حذف هذا العميل؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> حذف
                    </button>
                </form>
            </div>
        </div>

    </div>
@endsection