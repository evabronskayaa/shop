<div class="col-md-4 mb-4">
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">{{ $product->name }}</h3>
        </div>
        <div class="card-body p-0 position-relative">
            @if($product->image)
                @php $url = url('storage/catalog/product/thumb/' . $product->image) @endphp
                <img src="{{ $url }}" class="img-fluid" alt="">
            @else
                <img src="https://via.placeholder.com/300x150" class="img-fluid" alt="">
            @endif
        </div>
        <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('catalog.product', [$product->slug]) }}"
                   class="btn btn-outline-secondary float-end">Смотреть</a>
                <form action="{{ route('cart.add', ['id' => $product->id]) }}"
                      method="post" class="d-inline add-to-cart">
                    @csrf
                    <button type="submit" class="btn btn-outline-success">В корзину</button>
                </form>
        </div>
    </div>
</div>
