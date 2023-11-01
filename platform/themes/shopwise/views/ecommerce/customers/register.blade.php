@php Theme::set('pageName', __('Sign up')) @endphp

<!-- START LOGIN SECTION -->
<div class="login_register_wrap section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-10">
                <div class="login_wrap">
                    <div class="padding_eight_all bg-white">
                        <div class="pt-5 pl-5">
                            <h3>{{ __('Register') }}</h3>
                        </div>
                        <form method="POST" action="{{ route('customer.register.post') }}" class="mt-5 mb-5 mr-5 ml-5">
                            @csrf
                            <div class="form-group">
                                <input class="form-control" name="name" id="txt-name" type="text" value="{{ old('name') }}" placeholder="{{ __('Your Name') }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="email" id="txt-email" type="email" value="{{ old('email') }}" placeholder="{{ __('Your Email') }}">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="number" id="txt-number" type="number" value="{{ old('number') }}" placeholder="{{ __('Your Phone Number') }}">
                                @if ($errors->has('number'))
                                    <span class="text-danger">{{ $errors->first('number') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="password" name="password" id="txt-password" placeholder="{{ __('Password') }}">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="password" name="password_confirmation" id="txt-password-confirmation" placeholder="{{ __('Password Confirmation') }}">
                                @if ($errors->has('password_confirmation'))
                                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>
                            <div class="login_footer form-group ml-5 mt-4 mb-4">
                                <div class="chek-form">
                                    <div class="custome-checkbox">
                                        <input type="hidden" name="agree_terms_and_policy" value="0">
                                        <input class="form-check-input" type="checkbox" name="agree_terms_and_policy" id="terms-policy" value="1">
                                        <label class="form-check-label" for="terms-policy"><span>{{ __('I agree to terms & Policy.') }}</span></label>
                                    </div>
                                    @if ($errors->has('agree_terms_and_policy'))
                                        <span class="text-danger">{{ $errors->first('agree_terms_and_policy') }}</span>
                                    @endif
                                </div>
                            </div>
                            @if (setting('enable_captcha') && is_plugin_active('captcha'))
                                {!! Captcha::display() !!}
                            @endif
                            <div class="form-group">
                                <button type="submit" class="btn btn-fill-out btn-block">{{ __('Sign up') }}</button>
                            </div>
                        </form>


                        <div class="form-note text-center">{{ __('Already have an account?') }} <a href="{{ route('customer.login') }}">{{ __('Log in') }}</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END LOGIN SECTION -->