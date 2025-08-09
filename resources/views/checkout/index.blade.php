@extends('layouts.app')

@section('title', 'المنتجات')

@section('content')
<h2>تأكيد الطلب</h2>

<form method="POST" action="{{ route('checkout.store') }}">
    @csrf

    <div class="mb-3">
        <label>الاسم</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>رقم الهاتف</label>
        <input type="text" name="phone" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>العنوان</label>
        <input type="text" name="address" class="form-control" required>
    </div>

    <h4>محتويات العربة:</h4>
    <ul>
        @php $total = 0; @endphp
        @foreach ($cart as $item)
            @php $subtotal = $item['price'] * $item['quantity']; @endphp
            @php $total += $subtotal; @endphp
            <li>{{ $item['name'] }} - {{ $item['quantity'] }} × {{ $item['price'] }} = {{ $subtotal }}</li>
        @endforeach
    </ul>

    <strong>الإجمالي: {{ $total }} جنيه</strong>

    <button type="submit" class="btn btn-primary mt-3">تأكيد الطلب</button>
</form>
@endsection