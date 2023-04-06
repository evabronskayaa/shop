@extends('layout.site', ['title' => 'Ваша корзина'])

@section('content')
    @if (count($products))
        @php
            $cartCost = 0;
        @endphp
        <div class="row">
            <h1 class="col">Ваша корзина</h1>
            <form action="{{ route('cart.clear') }}" method="post" class="col">
                @csrf
                <button type="submit" class="btn btn-outline-danger float-end">
                    Очистить корзину
                </button>
            </form>
        </div>
        <table class="table table-bordered">
            <tr>
                <th scope="col">№</th>
                <th scope="col">Наименование</th>
                <th scope="col">Цена</th>
                <th scope="col">Кол-во</th>
                <th scope="col">Стоимость</th>
                <th scope="col"></th>
            </tr>
            @foreach($products as $product)
                @php
                    $itemPrice = $product->price;
                    $itemQuantity =  $product->pivot->quantity;
                    $itemCost = $itemPrice * $itemQuantity;
                    $cartCost = $cartCost + $itemCost;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <a href="{{ route('catalog.product', [$product->slug]) }}">
                            {{ $product->name }}
                        </a>
                    </td>
                    <td>{{ number_format($itemPrice, 2, '.', '') }}</td>
                    <td>
                        <form action="{{ route('cart.minus', ['id' => $product->id]) }}"
                              method="post" class="d-inline">
                            @csrf
                            <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                                <i class="fas fa-minus-square"></i>
                            </button>
                        </form>
                        <span class="mx-1">{{ $itemQuantity }}</span>
                        <form action="{{ route('cart.plus', ['id' => $product->id]) }}"
                              method="post" class="d-inline">
                            @csrf
                            <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                                <i class="fas fa-plus-square"></i>
                            </button>
                        </form>
                    </td>
                    <td>{{ number_format($itemCost, 2, '.', '') }}</td>
                    <td>
                        <form action="{{ route('cart.remove', ['id' => $product->id]) }}"
                              method="post">
                            @csrf
                            <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                                <i class="fas fa-trash-alt text-danger"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <tr>
                <th colspan="4" class="text-right">Итого</th>
                <th>{{ number_format($cartCost, 2, '.', '') }}</th>
                <th></th>
            </tr>
        </table>
        <a href="{{ route('cart.checkout') }}" class="btn btn-success float-end">
            Оформить заказ
        </a>
    @else
        <h1>Ваша корзина</h1>
        <p>Ваша корзина пуста</p>
    @endif
@endsection
