@extends('layout.site', ['title' => 'Оформить заказ'])

@section('content')
    <h1 class="mb-4">Оформить заказ</h1>
    @isset ($profiles)
        @include('cart.select', ['current' => $profile->id ?? 0])
    @endisset
    <form method="post" action="{{ route('cart.save-order') }}" id="checkout">
        @csrf
        <div class="input-group mb-1">
            <span class="input-group-text">Имя, Фамилия</span>
            <input type="text" class="form-control" name="name"
                   required maxlength="255" value="{{ old('name') ?? $profile->name ?? '' }}">
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text">Адрес почты</span>
            <input type="email" class="form-control" name="email"
                   required maxlength="255" value="{{ old('email') ?? $profile->email ?? '' }}">
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text">Номер телефона</span>
            <input type="text" class="form-control" name="phone"
                   required maxlength="255" value="{{ old('phone') ?? $profile->phone ?? '' }}">
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text">Адрес доставки</span>
            <input type="text" class="form-control" name="address"
                   required maxlength="255" value="{{ old('address') ?? $profile->address ?? '' }}">
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text">Комментарий</span>
            <textarea class="form-control" name="comment"
                      maxlength="255" rows="2">{{ old('comment') ?? $profile->comment ?? '' }}</textarea>
        </div>
        <div class="input-group">
            <button type="submit" class="btn btn-success">Оформить</button>
        </div>
    </form>
@endsection
