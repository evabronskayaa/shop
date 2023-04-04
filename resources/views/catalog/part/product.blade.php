<div class="col-md-4 mb-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="mb-0">{{ $product->name }}</h3>
        </div>
        <div class="card-body p-0 position-relative">
            <div class="position-absolute">
                @if($product->new)
                    <span class="badge bg-info bg-gradient text-white">Новинка</span>
                @endif
                @if($product->hit)
                    <span class="badge bg-danger bg-gradient">Лидер продаж</span>
                @endif
                @if($product->sale)
                    <span class="badge bg-success bg-gradient">Распродажа</span>
                @endif
            </div>
            @if($product->image)
                @php $url = url('storage/catalog/product/thumb/' . $product->image) @endphp
                <img src="{{ $url }}" class="img-fluid" alt="">
            @else
                <img src="https://via.placeholder.com/300x150" class="img-fluid" alt="">
            @endif
        </div>
        <div class="card-footer">
            <!-- Форма для добавления товара в корзину -->
            <form action="{{ route('cart.add', ['id' => $product->id]) }}"
                  method="post" class="d-inline add-to-cart">
                @csrf
                <button type="submit" class="btn btn-outline-success">В корзину</button>
            </form>
            <a href="{{ route('catalog.product', [$product->slug]) }}"
               class="btn btn-outline-dark float-end">Смотреть</a>
        </div>
    </div>
</div>
