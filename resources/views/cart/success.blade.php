@extends('layout.site', ['title' => 'Заказ размещен'])

@section('content')
    <h1>Заказ размещен</h1>

    <p>Ваш заказ успешно размещен. Наш менеджер скоро свяжется с Вами для уточнения деталей.</p>

    <h2>Ваш заказ</h2>
    <table class="table table-bordered">
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

    <h2>Ваши данные</h2>
    <p>Имя, фамилия: {{ $order->name }}</p>
    <p>Адрес почты: <a href="mailto:{{ $order->email }}">{{ $order->email }}</a></p>
    <p>Номер телефона: {{ $order->phone }}</p>
    <p>Адрес доставки: {{ $order->address }}</p>
    @isset ($order->comment)
        <p>Комментарий: {{ $order->comment }}</p>
    @endisset
@endsection
