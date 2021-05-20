<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Fonts --}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- Styles --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <livewire:styles />

    @yield('head')

</head>
<body>

    <div id="app" class="d-flex h-100">


        {{-- TODO: Style tag should be removed when ready --- Should find an alternative to the inline style --}}
        <div style="min-width: 200px" class="h-100 bg-secondary shadow-lg">
            <div class="d-flex flex-column justify-content-between h-100 py-4">

                {{-- Profile section --}}
                <div class="text-light text-center pt-4 pb-5">
                    @guest
                        <span class="d-block h3 text-uppercase avenir-medium">Welcome</span>
                    @else
                        <span class="d-block h3 text-uppercase avenir-medium mb-0">{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
                        <span class="d-block avenir">Welcome back!</span>
                    @endguest
                </div>
                {{-- End --- Profile section --}}

                {{ \Stpronk\View\Facades\Navigation::generateMenu('general', 'general', ['filters' => ['general']]) }}

                {{-- Admin nav --}}
                @if(Auth()->check() && Auth::user()->is_admin)
                    <div class="d-block pb-5">
                        <span class="text-white text-uppercase avenir-bold pb-2 px-4">
                            Admin Area
                        </span>

                        {{ \Stpronk\View\Facades\Navigation::generateMenu('admin', 'general', [
                                'ignore_filters' => true
                            ])  }}
                    </div>
                @endif
                {{-- End --- Admin nav --}}
            </div>
        </div>

        <div class="flex-fill d-flex flex-column">
            {{-- Top navigation --}}
{{-- TODO: Style tag should be removed when ready --- Should find an alternative to the inline style --}}
            <div class="w-100 bg-light shadow px-2" style="height: 50px">
                <div class="d-flex flex-row h-100">
                    <div class="flex-fill">
{{-- TODO | Make implementation for breadcrums --}}
                    </div>
                    <div class="h-100">
                        @guest
                            <a class="btn btn-link h-100 rounded-0 d-fill py-2 px-2 mx-2" href="{{ route('login') }}">
                                <i class="fa fa-sign-in"></i> {{ __('Login') }}
                            </a>
                        @else
                            <a class="btn btn-link h-100 px-2 mx-2 d-flex align-items-center rounded-0 dropdown-toggle" href="#{{ auth()->user()->name }}" data-toggle="dropdown">
                                <span class="pl-1 pr-1 text">{{ auth()->user()->name }}</span>
                            </a>

                            <div class="dropdown-menu py-0">
                                {{ \Stpronk\View\Facades\Navigation::generateMenu('user', 'dropdown', ['ignore_middleware' => true]) }}

                                <div class="dropdown-divider my-0"></div>
                                <a class="btn btn-dark rounded-0 d-flex justify-content-between align-items-center px-2" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <span>{{ __("Logout") }}</span>
                                    <i class="fa fa-sign-out pb-1 pr-1"></i>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
            {{-- End --- Top navigation --}}

            {{-- Extension top navigation for assignment --}}
                @if( isset($assignment) )
                    @include('layouts.components.submenu-extension', ['data' => $assignment])
                @endif
            {{-- End --- Extension top navigation for assignment --}}

            {{-- Content Area --}}
                <main class="p-4 overflow-auto flex-fill">
                    @yield('content')
                </main>
            {{-- End --- Content Area --}}
        </div>

    </div>

    {{-- Scripts --}}
    <script src="{{ asset('js/app.js') }}" defer></script>
    <livewire:scripts />

    @yield('scripts')

</body>
</html>
