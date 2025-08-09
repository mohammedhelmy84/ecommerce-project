@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">الدفع</h2>
    <p>المبلغ المطلوب: <strong>{{ $amount }} جنيه</strong></p>

    <form method="POST" action="{{ route('payment.mock.confirm') }}">
        @csrf
        <input type="hidden" name="order_id" value="{{ $orderId }}">
        <button type="submit" class="btn btn-success">إتمام الدفع (وهمي)</button>
    </form>
</div>
@endsection
