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
    <script>
        window.App={!! json_encode([
        'signedIn' => Auth::check(),
        'user' => Auth::user()
    ])!!};
    </script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('extra-css')

</head>

<body>
    <div id="app">

        @include('includes.navigation')

        <main class="py-4 bg-gray-100">
            <flash message="{{session('flash')}}"></flash>
            @yield('content')
        </main>
    </div>
</body>

</html>