@php Theme::set('pageName', __('Shopping Cart')); @endphp

<div class="section bg-white cart_section">
    <div class="container">
        @if (Cart::instance('cart')->count() > 0)
            @if (session()->has('success_msg'))
                <div class="alert alert-success">
                    <span>{{ session('success_msg') }}</span>
                </div>
            @endif

            @if (session()->has('error_msg'))
                <div class="alert alert-warning">
                    <span>{{ session('error_msg') }}</span>
                </div>
            @endif

            @if (isset($errors) && count($errors->all()) > 0)
                <div class="alert alert-warning">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div class="">
                @php
                    $product;
                @endphp
                <form method="post" action="{{ route('public.cart.update') }}">
                    @csrf
                    <div class="row ">
                        <div class="col-12">
                            <div class="container mt-3">
                                <ul class="nav nav-tabs bg-white">
                                    <li class="nav-item nav-1-nav">
                                      <a class="nav-link nav-link-2 active" data-toggle="tab" href="#home">Cart</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content bg-white">
                                <div id="home" class="container tab-pane active"><br>
                                    @if (isset($products) && $products)
                                        @foreach(Cart::instance('cart')->content() as $key => $cartItem)
                                            @php
                                                $product = $products->where('id', $cartItem->id)->first();
                                            @endphp
                                            @if (!empty($product))
                                                <input type="hidden" name="items[{{ $key }}][rowId]" value="{{ $cartItem->rowId }}">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <a href="{{ $product->original_product->url }}">
                                                            <img src="@if ($product->link == null){{ RvMedia::getImageUrl($product->image, null, false, RvMedia::getDefaultImage()) }}@else {{$product->link}} @endif" alt="{{ $product->name }}" />
                                                        </a>
                                                    </div>
                                                    <div class="col-md-4" data-title="{{ __('Product') }}">
                                                        <a href="{{ $product->original_product->url }}" title="{{ $product->name }}"><h3 class="nav-ta-1">{{ $product->name }}</h3></a>
                                                        <p>
                                                            <small>{{ $cartItem->options['attributes'] ?? '' }}</small>
                                                        </p>
                                                        @if (!empty($cartItem->options['extras']) && is_array($cartItem->options['extras']))
                                                            @foreach($cartItem->options['extras'] as $option)
                                                                @if (!empty($option['key']) && !empty($option['value']))
                                                                    <p style="margin-bottom: 0;"><small>{{ $option['key'] }}: <strong> {{ $option['value'] }}</strong></small></p>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <div class="col-md-3" data-title="{{ __('Quantity') }}">
                                                        <div class="row ml-4">
                                                            <div class="text-center">
                                                                <input type="button" value="-" class="col-md-3 minus">
                                                                <input type="text" value="{{ $cartItem->qty }}" title="Qty" class="col-md-6 qty" size="4" name="items[{{ $key }}][values][qty]">
                                                                <input type="button" value="+" class="col-md-3 plus">
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="thirfeen cart_price_in" data-title="{{ __('Total') }}">{{ format_price($cartItem->price * $cartItem->qty) }} @if ($product->front_sale_price != $product->price)
                                <small class = "cart_attributes_4"><del style="text-decoration-thickness: 3px;text-decoration-color: red;font-size: 22px;">{{ format_price($product->price  * $cartItem->qty) }}</del></small>
                            @endif</div>
                                                    <div class="product-remove" data-title="{{ __('Remove') }}"><a href="{{ route('public.cart.remove', $cartItem->rowId) }}" class="remove-cart-button "><i class="fa  fa-trash-o fa-lg text-danger" data-toggle="tooltip" data-placement="top" title="Remove from cart"></i></a></div>
                                                    
                                                </div>
                                                <hr>
                                            @endif
                                        @endforeach
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <div>
                                                        @if (!session()->has('applied_coupon_code'))
                                                            <div class="row coupon field_form input-group form-coupon-wrapper">
                                                                <div class="col-md-4">
                                                                    <input type="text" name="coupon_code" value="{{ old('coupon_code') }}" class="form-control form-control-sm coupon-code filed-1-fill" placeholder="{{ __('Enter Coupon Code...') }}">
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <button class="btn-apply-coupon-code" type="button" data-url="{{ route('public.coupon.apply') }}">{{ __('Apply Coupon') }}</button>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if (session('applied_coupon_code'))
                                                            <div class="mt-2 text-left">
                                                                <small><strong>{{ __('Coupon code: :code', ['code' => session('applied_coupon_code')]) }}</strong> <a class="btn-remove-coupon-code text-danger" data-url="{{ route('public.coupon.remove') }}" href="javascript:void(0)"><i class="ti-close"></i></a></small>
                                                            </div>
                                                        @endif
                                                            <div class="coupon-error-msg text-left">
                                                                <small><span class="text-danger"></span></small>
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn cont-shop-2" style="width: 100%;">{{ __('Update cart') }}</button>&nbsp;&nbsp;&nbsp;
                                                </div>
                                            </div>
                                        </div>
                                                
                                                                                                        
                                        <div>
                                        <div class="shipping">
                                                        <div>
                                                            <div class="row">
                                                                {{-- <table class> --}}
                                                                <div class="col-md-6"></div>
                                                                <div class="col-md-4">{{ __('Subtotal') }}</div>
                                                                <div class="col-md-2">{{ format_price(Cart::instance('cart')->rawSubTotal()) }}</div>
                                                                @if ($couponDiscountAmount > 0)
                                                                    <div class="col-md-6"></div>
                                                                    <div class="col-md-4">{{ __('Coupon code discount amount') }}</div>
                                                                    <div class="col-md-2">{{ format_price($couponDiscountAmount) }}</div>
                                                                @endif
                                                                @if ($promotionDiscountAmount)
                                                                    <div class="col-md-6"></div>
                                                                    <div class="col-md-4">{{ __('Discount promotion') }}</div>
                                                                    <div class="col-md-2">{{ format_price($promotionDiscountAmount) }}</div>
                                                                @endif
                                                                    <div class="col-md-6"></div>
                                                                    
                                                                    <div class="col-md-4">{{ __('Total') }} ({{ __('Shipping fees not included') }})</div>
                                                                    <div class="col-md-2"><strong>{{ format_price(Cart::instance('cart')->rawTotal() - $promotionDiscountAmount - $couponDiscountAmount) }}</strong></div>
                                                                    <div class="col-md-6"></div>
                                                                   
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-5">
                                                    <div class="col-md-6 px-0">
                                                        <a href="/dev/public/" class="continue_shop w-50">Continue Shopping</a>
                                                    </div>
                                                    <div class="col-md-6 px-0">
                                                        <button type="submit" class="cont-shop-2 w-50" name="checkout">{{ __('Proceed To CheckOut') }}</button>
                                                    </div>
                                                </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div> 
                </form>
            </div>
        @else
            <p class="text-center">{{ __('Your cart is empty!') }}</p>
        @endif 
    </div>
</div>