<a class="nav-link"
   href="{{ route('cart.index') }}">
    Корзина
    @if ($positions)
        <span class="position-absolute translate-middle badge bg-success bg-gradient">
            {{ $positions > 99 ? '99+' : $positions }}
        </span>
    @endif
</a>
