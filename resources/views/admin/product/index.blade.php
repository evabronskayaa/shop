@extends('layout.admin', ['title' => 'Все товары каталога'])

@section('content')
    <div class="row">
        <div class="col">
            <h1>Все товары</h1>
            <!-- Корневые категории для возможности навигации -->
            <ul>
                @foreach ($roots as $root)
                    <li>
                        <a href="{{ route('admin.product.category', ['category' => $root->id]) }}">
                            {{ $root->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col">
            <a href="{{ route('admin.product.create') }}" class="col btn btn-success mb-5 float-end">
                Создать товар
            </a>
        </div>
    </div>
    <table class="table table-bordered">
        <tr>
            <th scope="col">Наименование</th>
            <th scope="col">Описание</th>
            <th scope="col"><i class="fas fa-edit"></i></th>
            <th scope="col"><i class="fas fa-trash-alt"></i></th>
        </tr>
        @foreach ($products as $product)
            <tr>
                <td>
                    <a href="{{ route('admin.product.show', ['product' => $product->id]) }}">
                        {{ $product->name }}
                    </a>
                </td>
                <td>{{ iconv_substr($product->content, 0, 150) }}</td>
                <td>
                    <a href="{{ route('admin.product.edit', ['product' => $product->id]) }}">
                        <i class="far fa-edit"></i>
                    </a>
                </td>
                <td>
                    <form action="{{ route('admin.product.destroy', ['product' => $product->id]) }}"
                          method="post" onsubmit="return confirm('Удалить этот товар?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                            <i class="far fa-trash-alt text-danger"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $products->links() }}
@endsection
