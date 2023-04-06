@extends('layout.admin', ['title' => 'Все категории каталога'])

@section('content')
    <div class="row">
        <h1 class="col">Все категории</h1>
        <a href="{{ route('admin.category.create') }}" class="col btn btn-success mb-4 float-end">
            Создать категорию
        </a>
    </div>
    <table class="table table-bordered">
        <tr>
            <th scope="col">Наименование</th>
            <th scope="col">Описание</th>
            <th scope="col"><i class="fas fa-edit"></i></th>
            <th scope="col"><i class="fas fa-trash-alt"></i></th>
        </tr>
        @include('admin.category.part.tree', ['level' => -1, 'parent' => 0])
    </table>
@endsection
