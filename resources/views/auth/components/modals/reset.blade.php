<div class="modal fade avenir" id="password-forgotten" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-secondary-gradient rounded-0">

            <div class="d-flex mt-4 px-4 text-light">
                <h1 class="h3 flex-fill avenir-bold text-uppercase">{{ __('Reset') }} <span class="text-primary">{{ __('password') }}</span></h1>
                <a class="close text-white pointer" aria-label="Close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>

            <p class="text-light px-4">
                {{-- TODO: Text should be set within a translation script --}}
                If you forgotten your password, we can send you a e-mail with a link to reset your password. Enter you e-mail address underneath here and we will send you a link if your e-mail address is known in our database.
            </p>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="input-group px-4 d-flex">
                    <input id="email-reset" name="email-reset" type="email" class="input-field flex-fill" placeholder="{{ __('E-mail address') }}" value="{{ old('email-reset') }}" required autocomplete="email" autofocus>
                    <label for="email-reset" class="input-label"><i class="fa fa-envelope"></i></label>
                </div>

                <div class="mx-4 mt-3 mb-4 d-flex align-middle">
                    <button class="btn btn-reset btn-outline-primary btn-outline-thick avenir-bold text-white px-4">
                        {{ __('Send reset link') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
