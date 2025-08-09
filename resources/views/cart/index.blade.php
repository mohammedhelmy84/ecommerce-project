@extends('layouts.app')

@section('content')
    <h2>عربة التسوق</h2>
    @if(session('cart'))
        <form action="{{ route('cart.clear') }}" method="POST" class="mb-3">
            @csrf
            <button type="submit" class="btn btn-danger">🗑️ تفريغ العربة</button>
        </form>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('cart'))
        <table class="table">
            <thead>
                <tr>
                    <th>صورة</th>
                    <th>الاسم</th>
                    <th>السعر</th>
                    <th>الكمية</th>
                    <th>الإجمالي</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0 @endphp
                @foreach(session('cart') as $id => $details)
                    @php $total += $details['price'] * $details['quantity'] @endphp
                    <tr>
                        <td><img src="{{ $details['image'] }}" width="50" /></td>
                        <td>{{ $details['name'] }}</td>
                        <td>{{ $details['price'] }}</td>
                        <td>
                            <form action="{{ route('cart.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <input type="number" name="quantity" value="{{ $details['quantity'] }}" class="form-control"
                                    style="width: 70px; display:inline-block;">
                                <button type="submit" class="btn btn-sm btn-primary">تحديث</button>
                            </form>
                        </td>
                        <td>{{ $details['price'] * $details['quantity'] }}</td>
                        <td>
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4"><strong>الإجمالي</strong></td>
                    <td><strong>{{ $total }}</strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <a href="{{ route('checkout.index') }}" class="btn btn-success">إتمام الطلب</a>

    @else
        <p>العربة فارغة</p>
    @endif
@endsection