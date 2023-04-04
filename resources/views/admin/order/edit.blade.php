@extends('layout.admin', ['title' => 'Редактирование заказа'])

@section('content')
    <h1 class="mb-4">Редактирование заказа</h1>
    <form method="post" action="{{ route('admin.order.update', ['order' => $order->id]) }}">
        @csrf
        @method('PUT')
        <div class="input-group mb-1">
            <span class="input-group-text">Статус заказа</span>
            @php $status = old('status') ?? $order->status ?? 0 @endphp
            <select name="status" class="form-control" title="Статус заказа">
                @foreach ($statuses as $key => $value)
                    <option value="{{ $key }}" @if ($key == $status) selected @endif>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text">Имя, Фамилия</span>
            <input type="text" class="form-control" name="name"
                   required maxlength="255" value="{{ old('name') ?? $order->name ?? '' }}">
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text">Адрес почты</span>
            <input type="email" class="form-control" name="email"
                   required maxlength="255" value="{{ old('email') ?? $order->email ?? '' }}">
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text">Номер телефона</span>
            <input type="text" class="form-control" name="phone"
                   required maxlength="255" value="{{ old('phone') ?? $order->phone ?? '' }}">
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text">Адрес доставки</span>
            <input type="text" class="form-control" name="address"
                   required maxlength="255" value="{{ old('address') ?? $order->address ?? '' }}">
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text">Комментарий</span>
            <textarea class="form-control" name="comment"
                      maxlength="255" rows="2">{{ old('comment') ?? $order->comment ?? '' }}</textarea>
        </div>
        <div class="input-group">
            <button type="submit" class="btn btn-success">Сохранить</button>
        </div>
    </form>
@endsection
