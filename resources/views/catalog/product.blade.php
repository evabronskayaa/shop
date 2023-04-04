@extends('layout.site')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h1>{{ $product->name }}</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 position-relative">
                            <div class="position-absolute">
                                @if($product->new)
                                    <span class="badge bg-info bg-gradient text-white ml-1">Новинка</span>
                                @endif
                                @if($product->hit)
                                    <span class="badge bg-danger bg-gradient ml-1">Лидер продаж</span>
                                @endif
                                @if($product->sale)
                                    <span class="badge bg-success bg-gradient ml-1">Распродажа</span>
                                @endif
                            </div>
                            @if($product->image)
                                @php $url = url('storage/catalog/product/image/' . $product->image) @endphp
                                <img src="{{ $url }}" alt="" class="img-fluid rounded-1">
                            @else
                                <img src="https://via.placeholder.com/600x300" alt="" class="img-fluid rounded-1">
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-1">
                                <label for="price" class="input-group-text rounded-0">Цена:</label>
                                <input type="text" readonly class="form-control" id="price" value="{{ number_format($product->price, 2, '.', '') }}">
                            </div>
                            <!-- Форма для добавления товара в корзину -->
                            <form action="{{ route('cart.add', ['id' => $product->id]) }}"
                                  method="post" class="input-group add-to-cart">
                                @csrf
                                <label class="input-group-text" for="input-quantity">Количество</label>
                                <input type="number" name="quantity" id="input-quantity" required value="1" min="1"
                                       class="form-control">
                                <button type="submit" class="btn btn-success">
                                    Добавить в корзину
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p class="mt-4 mb-0">{{ $product->content }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            @isset($product->category)
                                Категория:
                                <a href="{{ route('catalog.category', [$product->category->slug]) }}">
                                    {{ $product->category->name }}
                                </a>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
