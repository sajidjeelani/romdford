@extends('plugins/ecommerce::orders.master')
@section('title')
    {{ __('Checkout') }}
@stop
@section('content')
@include(Theme::getThemeNamespace() . '::partials/header')
@if (Cart::instance('cart')->count() > 0)
<link rel="stylesheet" href="{{ asset('vendor/core/plugins/payment/css/payment.css') }}?v=1.0.3">
        <script src="{{ asset('vendor/core/plugins/payment/js/payment.js') }}?v=1.0.3"></script>
        <style>

.paypal-logo {
  font-family: Verdana, Tahoma;
  font-weight: bold;
  font-size: 15px;
}

.paypal-logo i:first-child {
  color: #253b80;
}

.paypal-logo i:last-child {
  color: #179bd7;
}

.paypal-button {
  padding: 10px 20px;
  border: 1px solid #FF9933;
  border-radius: 5px;
  background-image: -webkit-linear-gradient(top, #FFF0A8, #F9B421);
  background-image: linear-gradient(to bottom, #FFF0A8, #F9B421);
  margin: 0 auto;
  display: block;
  min-width: 138px;
  position: relative;
}

.paypal-button-title {
  font-size: 12px;
  color: #505050;
  vertical-align: baseline;
  text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.6);
}

.paypal-logo {
  display: inline-block;
  text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.6);
  font-size: 15px;
}

        </style>
        {!! Form::open(['route' => ['public.checkout.process', $token], 'class' => 'checkout-form payment-checkout-form', 'id' => 'checkout-form']) !!}
        <input type="hidden" name="checkout-token" id="checkout-token" value="{{ $token }}">
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
        <div class="container">
            <div class="row">
                <div class="order-1 order-md-2 col-lg-5 col-md-6 right" id="main-checkout-product-info">
                    {{-- <div class="d-block d-sm-none">
                        @include('plugins/ecommerce::orders.partials.logo')
                    </div> --}}
                    <div id="cart-item" class="position-relative">
                    
                        <div class="payment-info-loading" style="display: none;">
                            <div class="payment-info-loading-content">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </div>

                        <!---------------------- RENDER PRODUCTS IN HERE ---------------- -->
                        {!! apply_filters(RENDER_PRODUCTS_IN_CHECKOUT_PAGE, $products) !!}
                        
                        <div class="mt-2 p-2">
                            <div class="row">
                                <div class="col-6">
                                    <p>{{ __('Subtotal') }}:</p>
                                </div>
                                <div class="col-6">
                                    <p class="price-text sub-total-text text-right"> {{ format_price(Cart::instance('cart')->rawSubTotal()) }} </p>
                                </div>
                            </div>
                            
                             @if (Cart::instance('cart')->rawGift() == '0' || Cart::instance('cart')->rawGift() == null)
                             @else
                             <div class="row">
                                <div class="col-6"><p>Gift Wrap</p></div>
                                <div class="col-6">
                                    <p class="price-text sub-total-text text-right">
                                         {{ format_price(Cart::instance('cart')->rawGift()) }}
                                    </p>
                                    </div>
                             </div>
                             @endif
                            
                            @if (session('applied_coupon_code'))
                            <div class="row coupon-information">
                                <div class="col-6">
                                    <p>{{ __('Coupon code') }}:</p>
                                </div>
                                <div class="col-6">
                                    <p class="price-text coupon-code-text"> {{ session('applied_coupon_code') }} </p>
                                </div>
                            </div>
                            @endif
                            @if ($couponDiscountAmount > 0)
                                <div class="row price discount-amount">
                                    <div class="col-6">
                                        <p>{{ __('Coupon code discount amount') }}:</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="price-text total-discount-amount-text"> {{ format_price($couponDiscountAmount) }} </p>
                                    </div>
                                </div>
                            @endif
                            @if ($promotionDiscountAmount > 0)
                                <div class="row">
                                    <div class="col-6">
                                        <p>{{ __('Promotion discount amount') }}:</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="price-text"> {{ format_price($promotionDiscountAmount) }} </p>
                                    </div>
                                </div>
                            @endif
                            @if (!empty($shipping))
                                <div class="row">
                                    <div class="col-6">
                                        <p>{{ __('Shipping fee') }}:</p>
                                    </div>
                                    <div class="col-6 float-right">
                                        <p class="price-text shipping-price-text">{{ format_price($shippingAmount) }}</p>
                                    </div>
                                </div>
                            @endif

                            @if (EcommerceHelper::isTaxEnabled())
                                <div class="row">
                                    <div class="col-6">
                                        <p>{{ __('Tax') }}:</p>
                                    </div>
                                    <div class="col-6 float-right">
                                        <p class="price-text tax-price-text">{{ format_price(Cart::instance('cart')->rawTax()) }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-6">
                                    <p><strong>{{ __('Total') }}</strong>:</p>
                                </div>
                                <div class="col-6 float-right">
                                 
                                 @if (Cart::instance('cart')->rawGift() == '0' || Cart::instance('cart')->rawGift() == null)
                                   <p class="total-text raw-total-text"
                                       data-price="{{ format_price(Cart::instance('cart')->rawTotal(), null, true) }}"> {{ ($promotionDiscountAmount + $couponDiscountAmount - $shippingAmount) > Cart::instance('cart')->rawTotal() ? format_price(0) : format_price(Cart::instance('cart')->rawTotal() - $promotionDiscountAmount - $couponDiscountAmount + $shippingAmount) }} </p>
                               
                             @else
                                    <p class="total-text raw-total-text"
                                       data-price="{{ format_price(Cart::instance('cart')->rawTotal(), null, true) }}"> {{ ($promotionDiscountAmount + $couponDiscountAmount - $shippingAmount) > Cart::instance('cart')->rawTotal() ? format_price(0) : format_price(Cart::instance('cart')->rawTotal()+Cart::instance('cart')->rawGift() - $promotionDiscountAmount - $couponDiscountAmount + $shippingAmount) }} </p>
                               
                             @endif  
                               
                               
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="mt-3 mb-5">
                        @include('plugins/ecommerce::themes.discounts.partials.form')
                        
                    </div>
                </div>
                <div class="col-lg-7 col-md-6 left">
                    {{-- <div class="d-none d-sm-block">
                        @include('plugins/ecommerce::orders.partials.logo')
                    </div> --}}
                    <div class="form-checkout">
                        <form action="{{ route('payments.checkout') }}" method="post" id="checkoutform">
                            @csrf

                            <div>
                                <h5 class="checkout-payment-title">{{ __('Shipping information') }}</h5>
                                <input type="hidden" value="{{ route('public.checkout.save-information', $token) }}" id="save-shipping-information-url">
                                @include('plugins/ecommerce::orders.partials.address-form', compact('sessionCheckoutData'))
                            </div>
                            <br>

                            @if (!is_plugin_active('marketplace'))
                                <div id="shipping-method-wrapper">
                                    <h5 class="checkout-payment-title">{{ __('Shipping method') }}</h5>
                                    <div class="shipping-info-loading" style="display: none;">
                                        <div class="shipping-info-loading-content">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </div>
                                    </div>
                                    @if (!empty($shipping))
                                        <div class="payment-checkout-form">
                                            <input type="hidden" name="shipping_option" value="{{ old('shipping_option', $defaultShippingOption) }}">
                                            <ul class="list-group list_payment_method">
                                                @foreach ($shipping as $shippingKey => $shippingItem)
                                                    @foreach($shippingItem as $subShippingKey => $subShippingItem)
                                                        @include('plugins/ecommerce::orders.partials.shipping-option', [
                                                            'defaultShippingMethod' => $defaultShippingMethod,
                                                            'defaultShippingOption' => $defaultShippingOption,
                                                            'shippingOption'        => $subShippingKey,
                                                            'shippingItem'          => $subShippingItem,
                                                        ])
                                                    @endforeach
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <p style="color: red;font-size: 17px;">{{ __('If Shipping has not been activated to your destination, Please Contact Us!') }}</p>
                                    @endif
                                </div>
                                <br>
                            @endif
                             <h5 class="checkout-payment-title">{{ __('Gift')  }}</h5>
                            @if (Cart::instance('cart')->rawGift() == '0' || Cart::instance('cart')->rawGift() == null) 
                            <div class="w-100 list-group-item mb-5">
                                <a href = "{{ route('public.cart.gift', theme_option('giftprice') ) }}">☐</a> I would like my order to be gift wrapped.  (Additional cost of £{{theme_option('giftprice')}}).

                            </div>
                            @else
                            <div class="w-100 list-group-item mb-5">
                                <a href = "{{ route('public.cart.gift', 'remove' ) }}">☑</a> I would like my order to be gift wrapped.  (Additional cost of £{{theme_option('giftprice')}}).
                            </div>
                            @endif
                            

                            <div>
                                <h5 class="checkout-payment-title">{{ __('Payment method') }}</h5>
                               
                               
                            @if (Cart::instance('cart')->rawGift() == '0' || Cart::instance('cart')->rawGift() == null)
                                <input type="hidden" name="amount" value="{{ ($promotionDiscountAmount + $couponDiscountAmount - $shippingAmount) > Cart::instance('cart')->rawTotal() ? 0 : format_price(Cart::instance('cart')->rawTotal() - $promotionDiscountAmount - $couponDiscountAmount + $shippingAmount, null, true) }}">
                            @else
                                <input type="hidden" name="amount" value="{{ ($promotionDiscountAmount + $couponDiscountAmount - $shippingAmount) > Cart::instance('cart')->rawTotal() ? 0 : format_price(Cart::instance('cart')->rawTotal() + Cart::instance('cart')->rawGift() - $promotionDiscountAmount - $couponDiscountAmount + $shippingAmount, null, true) }}">
                            @endif
                               
                               
                               
                               
                                <input type="hidden" name="currency" value="{{ strtoupper(get_application_currency()->title) }}">
                                <input type="hidden" name="currency_id" value="{{ get_application_currency_id() }}">
                                <input type="hidden" name="callback_url" value="{{ route('public.payment.paypal.status') }}">
                                <input type="hidden" name="return_url" value="{{ \Botble\Payment\Supports\PaymentHelper::getRedirectURL($token) }}">
                                {!! apply_filters(PAYMENT_FILTER_PAYMENT_PARAMETERS, null) !!}
                                <ul class="list-group list_payment_method">
                                    @if (setting('payment_stripe_status') == 1)
                                        <li class="list-group-item">
                                            <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_stripe"
                                                   value="stripe" @if (!setting('default_payment_method') || setting('default_payment_method') == \Botble\Payment\Enums\PaymentMethodEnum::STRIPE) @endif data-toggle="collapse" data-target=".payment_stripe_wrap" data-parent=".list_payment_method">
                                            <label for="payment_stripe" class="text-left">
                                                {{ setting('payment_stripe_name', trans('plugins/payment::payment.payment_via_card')) }}
                                            </label>
                                            <div class="payment_stripe_wrap payment_collapse_wrap collapse @if (!setting('default_payment_method') || setting('default_payment_method') == \Botble\Payment\Enums\PaymentMethodEnum::STRIPE) show @endif">
                                                <div class="card-checkout">
                                                    <div class="form-group">
                                                        <div class="stripe-card-wrapper"></div>
                                                    </div>
                                                    <div class="form-group @if ($errors->has('number') || $errors->has('expiry')) has-error @endif">
                                                        <div class="row">
                                                            <div class="col-sm-9">
                                                                <input placeholder="{{ trans('plugins/payment::payment.card_number') }}"
                                                                       class="form-control" type="text" id="stripe-number" data-stripe="number">
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input placeholder="{{ trans('plugins/payment::payment.mm_yy') }}" class="form-control"
                                                                       type="text" id="stripe-exp" data-stripe="exp">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group @if ($errors->has('name') || $errors->has('cvc')) has-error @endif">
                                                        <div class="row">
                                                            <div class="col-sm-9">
                                                                <input placeholder="{{ trans('plugins/payment::payment.full_name') }}"
                                                                       class="form-control" id="stripe-name" type="text" data-stripe="name">
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input placeholder="{{ trans('plugins/payment::payment.cvc') }}" class="form-control"
                                                                       type="text" id="stripe-cvc" data-stripe="cvc">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="payment-stripe-key" data-value="{{ setting('payment_stripe_client_id') }}"></div>
                                            </div>
                                        </li>
                                    @endif
                                    @if (setting('payment_paypal_status') == 1)
                                        <li class="list-group-item">
                                            <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_paypal"
                                                   @if (setting('default_payment_method') == \Botble\Payment\Enums\PaymentMethodEnum::PAYPAL) @endif
                                                   value="paypal">
                                            <label for="payment_paypal" class="text-left">{{ setting('payment_paypal_name', trans('plugins/payment::payment.payment_via_paypal')) }}</label>
                                        </li>
                                    @endif

                                    {!! apply_filters(PAYMENT_FILTER_ADDITIONAL_PAYMENT_METHODS, null, ['amount' => ($promotionDiscountAmount + $couponDiscountAmount - $shippingAmount) > Cart::instance('cart')->rawTotal() ? 0 : format_price(Cart::instance('cart')->rawTotal() - $promotionDiscountAmount - $couponDiscountAmount + $shippingAmount, null, true), 'currency' => strtoupper(get_application_currency()->title), 'name' => null]) !!}

                                    @if (setting('payment_cod_status') == 1)
                                        <li class="list-group-item">
                                            <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_cod"
                                                   @if (setting('default_payment_method') == \Botble\Payment\Enums\PaymentMethodEnum::COD)  @endif checked
                                                   value="cod" data-toggle="collapse" data-target=".payment_cod_wrap" data-parent=".list_payment_method">
                                            <label for="payment_cod" class="text-left">{{ setting('payment_cod_name', trans('plugins/payment::payment.payment_via_cod')) }}</label>
                                            <div class="payment_cod_wrap payment_collapse_wrap collapse @if (setting('default_payment_method') == \Botble\Payment\Enums\PaymentMethodEnum::COD) show @endif" style="padding: 15px 0;">
                                                {!! clean(setting('payment_cod_description')) !!}
                                            </div>
                                        </li>
                                    @endif
                                    @if (setting('payment_bank_transfer_status') == 1)
                                        <li class="list-group-item">
                                            <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_bank_transfer"
                                                   @if (setting('default_payment_method') == \Botble\Payment\Enums\PaymentMethodEnum::BANK_TRANSFER) checked @endif
                                                   value="bank_transfer" data-toggle="collapse" data-target=".payment_bank_transfer_wrap" data-parent=".list_payment_method">
                                            <label for="payment_bank_transfer" class="text-left">{{ setting('payment_bank_transfer_name', trans('plugins/payment::payment.payment_via_bank_transfer')) }}</label>
                                            <div class="payment_bank_transfer_wrap payment_collapse_wrap collapse @if (setting('default_payment_method') == \Botble\Payment\Enums\PaymentMethodEnum::BANK_TRANSFER) show @endif" style="padding: 15px 0;">
                                                {!! clean(setting('payment_bank_transfer_description')) !!}
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                            <br>

                            <div class="form-group @if ($errors->has('description')) has-error @endif">
                                <label for="description" class="control-label">{{ __('Note') }}</label>
                                <br>
                                <textarea name="description" id="description" rows="3" class="form-control" placeholder="{{ __('Note') }}...">{{ old('description') }}</textarea>
                                {!! Form::error('description', $errors) !!}
                            </div>

                            @if (EcommerceHelper::getMinimumOrderAmount() > Cart::instance('cart')->rawSubTotal())
                                <div class="alert alert-warning">
                                    {{ __('Minimum order amount is :amount, you need to buy more :more to place an order!', ['amount' => format_price(EcommerceHelper::getMinimumOrderAmount()), 'more' => format_price(EcommerceHelper::getMinimumOrderAmount() - Cart::instance('cart')->rawSubTotal())]) }}
                                </div>
                            @endif

                            <div class="form-group">
                                <a class="text-info" href="{{ route('public.cart') }}"><i class="fas fa-long-arrow-alt-left"></i> <span class="d-inline-block back-to-cart">{{ __('Back to cart') }}</span></a>
                                <div class="tacbox">
                                          <input id="agreement" type="checkbox"  name="agreement" required/>
                                          <label for="agreement"> I agree to these <a href="/dev/public/terms-and-conditions">Terms and Conditions</a></label>
                                        </div>
                                <div class="row">
                                    <div class="col-md-6 d-none d-md-block">
                                        <div class="box">
                                            <button class="paypal-button" onclick="paypalClick">
                                                <span class="paypal-button-title">
                                                  Buy now with
                                                </span>
                                                <span class="paypal-logo">
                                                  <i>Pay</i><i>Pal</i>
                                                </span>
                                              </button>
                                        </div>

                                    </div>
                                    <div class="col-md-6 checkout-button-group">
                                        <button id="buttoncheckout" type="submit" value="submit" @if (EcommerceHelper::getMinimumOrderAmount() > Cart::instance('cart')->rawSubTotal()) disabled @endif class="btn payment-checkout-btn payment-checkout-btn-step float-right" data-processing-text="{{ __('Processing. Please wait...') }}" data-error-header="{{ __('Error') }}">
                                            {{ __('Checkout') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="d-block d-md-none back-to-cart-button-group">
                                    <a class="text-info" href="{{ route('public.cart') }}"><i class="fas fa-long-arrow-alt-left"></i> <span class="d-inline-block">{{ __('Back to cart') }}</span></a>
                                </div>
                            </div>
                        </form>

                    </div> <!-- /form checkout -->
                </div>
            </div>
        </div>

        @if (setting('payment_stripe_status') == 1)
            <link rel="stylesheet" href="{{ asset('vendor/core/plugins/payment/libraries/card/card.css') }}">
            <script src="{{ asset('vendor/core/plugins/payment/libraries/card/card.js') }}"></script>
            <script src="{{ asset('https://js.stripe.com/v2/') }}"></script>
        @endif
    @else
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-warning my-5">
                        <span>{!! __('No products in cart. :link!', ['link' => Html::link(route('public.index'), __('Back to shopping'))]) !!}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <script>
        function AddGiftWrap(){
        }
        
        $(document).ready(function() {
            
        $("#checkout-form").submit(function(e) {
          if (!$("#agreement").is(":checked")) {
            alert("Please agree to the terms and conditions");
            e.preventDefault();
            location.reload();

          }
        });
        function paypalClick(){
            var paypalRadio = document.getElementById("payment_paypal");
            // Check the radio input element
            paypalRadio.checked = true;
            var buttonCheckout = document.getElementById("buttoncheckout");
            
            // Check if the button is disabled before clicking
            if (!buttonCheckout.disabled) {
                buttonCheckout.click();
            }
        }
    </script>
    
    
    @include(Theme::getThemeNamespace() . '::partials/footer')
@stop