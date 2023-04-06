@extends('layout.site', ['title' => 'Ваши заказы'])

@section('content')
    <h1>Ваши заказы</h1>
    @if($orders->count())
        <table class="table table-bordered">
            <tr>
                <th scope="col">№</th>
                <th scope="col">Дата и время</th>
                <th scope="col">Статус</th>
                <th scope="col">Покупатель</th>
                <th scope="col">Адрес почты</th>
                <th scope="col">Номер телефона</th>
                <th scope="col"><i class="fas fa-eye"></i></th>
            </tr>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                    <td>{{ $statuses[$order->status] }}</td>
                    <td>{{ $order->name }}</td>
                    <td><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></td>
                    <td>{{ $order->phone }}</td>
                    <td>
                        <a href="{{ route('user.order.show', ['order' => $order->id]) }}">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $orders->links() }}
    @else
        <p>Заказов пока нет</p>
    @endif
@endsection
