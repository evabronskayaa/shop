<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Панель управления' }}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'public/js/site.js', 'public/js/admin.js'])

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/daef3aa53d.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ru-RU.min.js"></script>

    @yield('head')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.index') }}">Панель управления</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.order.index') }}">Заказы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.user.index') }}">Пользователи</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.category.index') }}">Категории</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.product.index') }}">Товары</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.page.index') }}">Страницы</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a onclick="document.getElementById('logout-form').submit(); return false"
                       href="{{ route('logout') }}" class="nav-link">Выйти</a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="post" class="d-none">
                    @csrf
                </form>
            </ul>
        </div>
    </div>
</nav>

<div class="row m-4">
    <div class="col-12">
        @if ($message = session('success'))
            <div class="alert alert-success alert-dismissible mt-0" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
                {{ $message }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible mt-0" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</div>
</body>
</html>

