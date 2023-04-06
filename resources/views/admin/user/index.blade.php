@extends('layout.admin', ['title' => 'Все пользователи'])

@section('content')
    <h1 class="mb-4">Все пользователи</h1>

    <table class="table table-bordered">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Дата регистрации</th>
            <th scope="col">Имя, фамилия</th>
            <th scope="col">Адрес почты</th>
            <th scope="col">Кол-во заказов</th>
            <th scope="col"><i class="fa-sharp fa-solid fa-lock"></i></th>
        </tr>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                <td>{{ $user->name }}</td>
                <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                <td>{{ $user->orders != null ? $user->orders->count() : 0 }}</td>
                <td>
                    <a href="{{ route('admin.user.ban', ['user' => $user->id]) }}">
                        <i class="fa-sharp fa-solid fa-lock{{ $user->banned ? '' : '-open' }}"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $users->links() }}
@endsection
