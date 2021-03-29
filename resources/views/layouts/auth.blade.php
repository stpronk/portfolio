<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">

    @yield('head')

</head>
<body>
<div id="app">
    <main class="p-4 w-100">
        @yield('content')
    </main>
</div>

@yield('modals')

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>

{{-- Scripts that are not avaible yet but soon to come --}}
{{-- <script src="{{ asset('js/auth.js') }}" defer></script> --}}

@yield('scripts')

</body>
</html>
