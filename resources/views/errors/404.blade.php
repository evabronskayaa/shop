@extends('layout.site', ['title' => 'Страница не найдена'])

@section('head')
    @vite('public/sass/404.scss')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mt-4 mb-4">
                <div class="card-header">
                    <h1>Страница не найдена</h1>
                </div>

            </div>
        </div>
    </div>
@endsection
