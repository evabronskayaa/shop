@extends('layout.admin', ['title' => 'Все бренды каталога'])

@section('content')
    <div class="row">
        <h1 class="col">Все бренды каталога</h1>
        <a href="{{ route('admin.brand.create') }}" class="col btn btn-success mb-4 float-end">
            Создать бренд
        </a>
    </div>
    <table class="table table-striped table-hover">
        <tr>
            <th scope="col">Наименование</th>
            <th scope="col">Описание</th>
            <th scope="col"><i class="fas fa-edit"></i></th>
            <th scope="col"><i class="fas fa-trash-alt"></i></th>
        </tr>
        @foreach($brands as $brand)
            <tr>
                <td>
                    <a href="{{ route('admin.brand.show', ['brand' => $brand->id]) }}">
                        {{ $brand->name }}
                    </a>
                </td>
                <td>{{ iconv_substr($brand->content, 0, 150) }}</td>
                <td>
                    <a href="{{ route('admin.brand.edit', ['brand' => $brand->id]) }}">
                        <i class="far fa-edit"></i>
                    </a>
                </td>
                <td>
                    <form action="{{ route('admin.brand.destroy', ['brand' => $brand->id]) }}"
                          method="post">
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
@endsection
