@php Theme::set('pageName', __('Login')) @endphp

 <div class="login_register_wrap section">
     <div class="container">
         <div class="row justify-content-center">
             <div class="col-xl-6 col-md-10">
                 <div class="login_wrap">
                     <div class="padding_eight_all bg-white card">
                         <div class="row">
                         </div>
                         @if (isset($errors) && $errors->has('confirmation'))
                             <div class="alert alert-danger">
                                 <span>{!! $errors->first('confirmation') !!}</span>
                             </div>
                             <br>
                         @endif
                         <form method="POST" action="{{ route('customer.login.post') }}" class="mt-4 mb-4 ">
                            <div class="form-group col-sm-12 text-center"> 
                                                          <h1 class="mt-4">{{ __('Log In') }}</h1>
                            </div>
                             @csrf
                             <div class="form-group col-sm-12 flex-column d-flex">
                                 <label class="form-control-label text-start">{{ __('Your Email') }}</label>
                                 <input class="input-field-2" name="email" id="txt-email" type="email" value="{{ old('email') }}" placeholder="{{ __('Your Email') }}">
                                 @if ($errors->has('email'))
                                     <span class="text-danger">{{ $errors->first('email') }}</span>
                                 @endif
                             </div>
                             <div class="form-group col-sm-12 flex-column d-flex">
                                 <label class="form-control-label text-start">{{ __('Password') }}</label>
                                 <input class="input-field-2 mx-0" type="password" name="password" id="txt-password" placeholder="{{ __('Password') }}">
                                 @if ($errors->has('password'))
                                     <span class="text-danger mx-0">{{ $errors->first('password') }}</span>
                                 @endif
                             </div>
                             
                             
                             <div class="container">
                                 <div class="row">
                                     <div class = "col-md-6">
                                         
                                         <label class="form-control-label label-1-L mx-0" for="remember-me"><input type="checkbox" name="remember" id="remember-me" value="1">
                                            {{ __('Remember me') }}
                                         </label>
                                         
                                     </div>
                                     <div class = "col-md-6">
                                         <a class="form-control-label label-1-L mx-0 float-right" href="{{ route('customer.password.reset') }}">{{ __('Forgot password?') }}</a>
                                         </div>
                                 </div>
                             </div>
                             
                             
                             <div class="form-group col-sm-12 flex-column d-flex text-center mt-5">
                                 <button type="submit" class="btn btn-primary sing-up">{{ __('Log in') }}</button>
                             </div>
                         </form>

                         <!--<div class="text-center">-->
                         <!--    {!! apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, \Botble\Ecommerce\Models\Customer::class) !!}-->
                         <!--</div>-->

                         <div class="form-note text-center mb-1 py-1"> <a href="{{ route('customer.register') }}">{{ __("Don't Have an Account? Create Account") }}</a></div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- END LOGIN SECTION -->
