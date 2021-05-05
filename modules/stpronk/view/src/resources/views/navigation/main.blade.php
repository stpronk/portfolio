{{--
  This is a main blade you can load in as example, this will require bootstrap to run.

  -- When this blade is not used within the application, we recommened you remove this blade
  -- and create your own.

  --}}
<nav class="w-100">
    <div id="main-navigation" class="d-flex w-100 bg-light shadow justify-content-between">
        <div id="main-navigation__general" class="d-flex flex-row">
            <a class="px-3 py-2 mt-1 text-dark" href={{ url('/') }}>
                <h3 class="m-0 p-0">
                    {{ env('APP_NAME', 'Laravel') }}
                </h3>
            </a>

            {{ \Stpronk\View\Facades\Navigation::generate('general', 'general') }}
        </div>

        <div id="main-navigation__admin" class="d-flex flex-row">
            @if ( Auth::check() )
                {{ \Stpronk\View\Facades\Navigation::generate('admin', 'general') }}

                <a class="btn btn-light px-2 mx-2 d-flex align-items-center rounded-0" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="px-1">{{ __('Logout') }}</span>
                    <i class="fa fa-sign-out pb-1"></i>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a class="btn btn-light px-2 mx-2 d-flex align-items-center rounded-0" href="{{ route('login') }}">
                    <span class="px-1">{{ __('Login') }}</span>
                    <i class="fa fa-sign-in pb-1"></i>
                </a>
            @endif
        </div>
    </div>

    <div id="sub-menu" class="w-100 bg-secondary shadow">
        {{ \Stpronk\View\Facades\Navigation::generate('submenu', 'submenu')  }}
    </div>

</nav>
