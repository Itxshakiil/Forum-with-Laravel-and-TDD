<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title',config('app.name', 'Laravel Forum')) </title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('extra-css')

</head>

<body>
    <div id="app">
        <nav class="bg-gray-300 text-gray-900">
            <div class="container justify-between flex p-4">
                <div>
                    <a class="navbar-brand mr-4" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <a class="nav-link mr-4" href="{{ route('threads.index') }}">{{ __('All Threads') }}</a>
                    <a class="nav-link mr-4" href="{{ route('threads.create') }}">{{ __('Create Threads') }}</a>
                    <a class="nav-link mr-4"
                        href="{{ route('threads.index') }}?popular=1">{{ __('Popular Threads') }}</a>
                    @auth
                    <a class="nav-link mr-4"
                        href="{{ route('threads.index') }}?by={{auth()->user()->name}}">{{ __('My Threads') }}</a>
                    @endauth
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto flex md:justify-between">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item mr-4">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown mr-4">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span
                                    class="ml-2 p-1 w-2 h-2 border-gray-800 inline-block border-b-2 border-l-2"
                                    style="transform:rotate(-45deg);"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right  hidden" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile.show',Auth::user()) }}">
                                    {{ __('My Profile') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 bg-gray-100">
            <flash message="{{session('flash')}}"></flash>
            @yield('content')
        </main>
    </div>
</body>

</html>