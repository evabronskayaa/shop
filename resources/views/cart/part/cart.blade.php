<a class="nav-link"
   href="{{ route('cart.index') }}">
    Корзина
    @if ($positions)
        <span class="text-primary">
            ({{ $positions > 99 ? '99+' : $positions }})
        </span>
    @endif
</a>
