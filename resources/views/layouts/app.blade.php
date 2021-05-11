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

                {{-- Login/Logout section --}}
                @guest
                    <a class="btn btn-link text-light d-fill" href="{{ route('login') }}">
                        <i class="fa fa-sign-in"></i> {{ __('Login') }}
                    </a>
                @else

                    {{-- Admin nav --}}
                    @if(Auth::user()->is_admin)
                        <div class="d-block pb-5">
                            <span class="text-white text-uppercase avenir-bold pb-2 px-4">
                                Admin Area
                            </span>

                            {{ \Stpronk\View\Facades\Navigation::generateMenu('admin', 'general', [
                                    'ignore_middleware' => true,
                                    'ignore_filters' => true
                                ])  }}
                        </div>
                    @endif
                    {{-- End --- Admin nav --}}

                    <a class="btn btn-link text-light d-fill" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out"></i> {{ __('Logout') }} </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
                {{-- End --- Login/Logout section --}}

            </div>
        </div>

        <div class="flex-fill d-flex flex-column">
            {{-- Top navigation --}}
{{--                {{ \Stpronk\View\Facades\Navigation::generate('submenu', 'submenu')  }}--}}
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
