@extends('layout.admin')

@section('content')
    <h1>Панель управления</h1>
    <p>Добро пожаловать, {{ auth()->user()->name }}</p>
    <p>Это панель управления для администратора интернет-магазина.</p>
    <a href="{{ route('index') }}">
        <button type="submit" class="btn btn-primary">Выйти</button>
    </a>
@endsection
