@extends('layout.admin', ['title' => 'Все страницы сайта'])

@section('content')
    <div class="row">
        <h1 class="col">Все страницы сайта</h1>
        <div class="col">
            <a href="{{ route('admin.page.create') }}"  class="col btn btn-success mb-5 float-end">
                Создать страницу
            </a>
        </div>
    </div>
    @if (count($pages))
        <table class="table table-bordered">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Наименование</th>
                <th scope="col">ЧПУ (англ.)</th>
                <th scope="col"><i class="fas fa-edit"></i></th>
                <th scope="col"><i class="fas fa-trash-alt"></i></th>
            </tr>
            @include('admin.page.part.tree', ['level' => -1, 'parent' => 0])
        </table>
    @endif
@endsection
