<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Интернет-магазин' }}</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/daef3aa53d.js" crossorigin="anonymous"></script>
    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js', 'public/js/site.js'])
    @yield('head')
</head>
<body>
<nav class=" container navbar navbar-expand-md navbar-white">
    <a class="navbar-brand" href="{{ route('catalog.index') }}">Каталог</a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav m-auto me-auto">
            <form action="{{ route('catalog.search') }}" class="d-flex">
                <input class="form-control me-2" type="search" name="query" placeholder="Поиск по каталогу"
                       aria-label="Search">
                <button class=" btn btn-outline-primary" type="submit" id="button-addon2">Искать</button>
            </form>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item" id="top-basket">
                @include('cart.part.cart')
            </li>
            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @endif

                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('user.index') }}">
                            Личный кабинет
                        </a>

                        @if (auth()->user()->admin)
                            <a class="dropdown-item" href="{{ route('admin.index') }}">
                                Панель управления
                            </a>
                        @endif

                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row mt-4">
        <div class="col ms-auto">
            <div id="sidebar-offcanvas" class="sidebar-inplace offcanvas-md offcanvas-start"
                 aria-labelledby="sidebar-offcanvas-label">
                <div class="offcanvas-body">
                    <div class="sidebar w-100">
                        @include('layout.part.roots')
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 d-none p-4 ms-1 d-md-block">
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
</div>
</body>
</html>
