@foreach ($items->where('parent_id', $parent) as $item)
    <li class="nav-item">
        <a class="nav-link" href="{{ route('catalog.category', [$item->slug]) }}">{{ $item->name }}</a>
        @if (count($items->where('parent_id', $item->id)))
            <span class="badge bg-dark bg-gradient">
                <i class="fa fa-plus"></i>
            </span>
            @include('layout.part.branch', ['parent' => $item->id])
        @endif
    </li>
@endforeach
