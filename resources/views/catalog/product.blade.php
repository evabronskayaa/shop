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
                            @if($product->image)
                                @php $url = url('storage/catalog/product/image/' . $product->image) @endphp
                                <img src="{{ $url }}" alt="" class="img-fluid rounded-1">
                            @else
                                <img src="https://via.placeholder.com/600x300" alt="" class="img-fluid rounded-1">
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="col-12">
                                <p class="mt-4 mb-0">{{ $product->content }}</p>
                            </div>

                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="input-group mb-1">
                            <label for="price" class="input-group-text">Цена:</label>
                            <input type="text" readonly class="form-control" id="price" value="{{ number_format($product->price, 2, '.', '') }}">
                        </div>
                        <!-- Форма для добавления товара в корзину -->
                        <form action="{{ route('cart.add', ['id' => $product->id]) }}"
                              method="post" class="add-to-cart">
                            <div  class="input-group">
                                <label class="input-group-text" for="input-quantity">Количество</label>
                                <input type="number" name="quantity" id="input-quantity" required value="1" min="1"
                                       class="form-control">
                            </div>
                            @csrf

                            <button type="submit" class="btn btn-success mt-2">
                                Добавить в корзину
                            </button>
                        </form>
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
