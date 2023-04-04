@extends('layout.site', ['title' => 'Просмотр заказа'])

@section('content')
    <h1>Данные по заказу № {{ $order->id }}</h1>

    <p>Статус заказа: {{ $statuses[$order->status] }}</p>

    <h3 class="mb-3">Состав заказа</h3>
    <table class="table table-striped table-hover">
        <tr>
            <th scope="col">№</th>
            <th scope="col">Наименование</th>
            <th scope="col">Цена</th>
            <th scope="col">Кол-во</th>
            <th scope="col">Стоимость</th>
        </tr>
        @foreach($order->items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ number_format($item->price, 2, '.', '') }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->cost, 2, '.', '') }}</td>
            </tr>
        @endforeach
        <tr>
            <th scope="col" colspan="4" class="text-right">Итого</th>
            <th scope="col">{{ number_format($order->amount, 2, '.', '') }}</th>
        </tr>
    </table>

    <h3 class="mb-3">Данные покупателя</h3>
    <p>Имя, фамилия: {{ $order->name }}</p>
    <p>Адрес почты: <a href="mailto:{{ $order->email }}">{{ $order->email }}</a></p>
    <p>Номер телефона: {{ $order->phone }}</p>
    <p>Адрес доставки: {{ $order->address }}</p>
    @isset ($order->comment)
        <p>Комментарий: {{ $order->comment }}</p>
    @endisset
@endsection