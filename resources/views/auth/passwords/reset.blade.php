@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 row no-gutters p-0 shadow-lg auth-panel">
                <div class="col-12 col-md-5 bg-secondary-gradient">

                    <div class="d-flex pt-5 px-4  @if (!$errors->any() && !session('status')) pb-4 @endif text-light">
                        <h1 class="h3 flex-fill avenir-bold text-uppercase">{{ __('Reset') }} <span class="text-primary">{{ __('password') }}</span></h1>
                    </div>

                    @include('auth.components.messages')

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="input-group px-4 d-flex">
                            <input id="email" name="email" type="email" class="input-field flex-fill" placeholder="{{ __('E-mail address') }}" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label for="email" class="input-label"><i class="fa fa-envelope"></i></label>
                        </div>

                        <div class="input-group px-4 d-flex border-top-0">
                            <input id="password" name="password" type="password" class="input-field flex-fill" placeholder="{{ __('Password') }}" required>
                            <label for="password" class="input-label"><i class="fa fa-lock"></i></label>
                        </div>

                        <div class="input-group px-4 d-flex border-top-0">
                            <input id="password-confirm" name="password_confirmation" type="password" class="input-field flex-fill" placeholder="{{ __('Confirm password') }}" required>
                            <label for="password-confirm" class="input-label"><i class="fa fa-lock"></i></label>
                        </div>

                        <div class="m-4 pb-1 d-flex align-middle">
                            <button type="submit" class="btn btn-login btn-outline-primary btn-outline-thick avenir-bold px-4">
                                {{ __('Reset password') }}
                            </button>
                        </div>
                    </form>
                </div>
                @include('auth.components.side-panel')
            </div>

            @include('auth.components.footer')
        </div>
    </div>
@endsection

@section('modals')
    @include('auth.components.modals.assignments')
@endsection

