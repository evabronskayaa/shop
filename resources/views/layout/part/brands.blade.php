<div class="nav-header p-1 mb-1">Популярные бренды</div>
<ul class="nav nav-pills flex-column mb-3">
    @foreach($items as $item)
        <li class="nav-item">
            <a class="nav-link" href="{{ route('catalog.brand', [$item->slug]) }}">{{ $item->name }}<span
                    class="position-absolute translate-middle badge bg-success bg-gradient">{{ $item->products_count }}</span></a>
        </li>
    @endforeach
</ul>
