<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Блог') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @filamentStyles
    @livewireStyles
</head>
<body>

<header role="banner">
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-6 social">
                    @guest
                        <div class="row">
                            <a href="{{ route('login') }}">{{ __('Войти') }}</a>
                        </div>
                    @endguest

                    @auth
                        <div class="row">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <input class="btn btn-outline-danger mr-3" type="submit" value="Выйти">
                            </form>
                            <a class="mr-3" href="{{ route('personal', [app()->getLocale()]) }}">{{ __('Профиль') }}</a>
                            @if (auth()->user()->role === \App\Models\User::ROLE_ADMIN)
                                <a class="nav-link" href="{{ route('filament.admin.pages.dashboard') }}">
                                    {{ __('Страница администратора') }}
                                    <span class="sr-only">(current)</span>
                                </a>
                            @endif
                        </div>
                    @endauth
                </div>

                <div class="col-6 search-top d-flex justify-content-end align-items-center">
                    <form action="{{ route('article.search', [app()->getLocale()]) }}" class="search-top-form mr-3" method="GET">
                        <span class="icon fa fa-search"></span>
                        <input type="text" name="query" placeholder="{{ __('form.find') }}">
                    </form>

                    <div class="language-switcher">
                        <a href="{{ url('ru' . '/' . request()->pathWithoutLocale()) }}" class="mr-2 {{ app()->getLocale() === 'ru' ? 'font-bold' : '' }}">ru RU</a>
                        <a href="{{ url('en' . '/' . request()->pathWithoutLocale()) }}" class="{{ app()->getLocale() === 'en' ? 'font-bold' : '' }}">en EN</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container logo-wrap">
        <div class="row pt-5">
            <div class="col-12 text-center">
                <a class="absolute-toggle d-block d-md-none" data-toggle="collapse" href="#navbarMenu" role="button"
                   aria-expanded="false" aria-controls="navbarMenu">
                    <span class="burger-lines"></span>
                </a>
                <h1 class="site-logo"><a href="{{ route('home', [app()->getLocale()]) }}">{{ __('Блог') }}</a></h1>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <div class="container">
            @include('blocks.menu')
        </div>
    </nav>
</header>

@livewireScripts
@filamentScripts

</body>
</html>
