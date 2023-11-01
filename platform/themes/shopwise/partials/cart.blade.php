@php
function truncate($text, $length) {
   $length = abs((int)$length);
   if(strlen($text) > $length) {
      $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
   }
   return($text);
}
$totalDiscount=0;
@endphp
@if (Cart::instance('cart')->count() > 0)
    <ul class="cart_list">
        @php
            $products = [];
            $productIds = Cart::instance('cart')->content()->pluck('id')->toArray();

            if ($productIds) {
                $products = get_products([
                    'condition' => [
                        ['ec_products.id', 'IN', $productIds],
                    ],
                    'with' => ['slugable'],
                ]);
            }
        @endphp
        @if (count($products))
            @foreach(Cart::instance('cart')->content() as $key => $cartItem)
                @php
                    $product = $products->where('id', $cartItem->id)->first();
                @endphp

                @if (!empty($product))
                    @php
                        $disvalue=$product->front_sale_price;
                        $disvaluetemp=0;
                         foreach ($product->categories()->get() as $category){
                                            $catdis = get_category_discount($category->id);
                                            if($catdis){
                                            $title=$catdis['title'];
                                            if($catdis['type_option']=="amount")
                                                $disvalue+=$catdis['value'];
                                            else    
                                                $disvaluetemp=(($disvalue*$catdis['value'])/100);
                                            $disvalue-=$disvaluetemp;
                                                break;
                                            
                                            }
                                        }
                        if($disvalue<0)
                            $disvalue=0;
                        $totalDiscount+=$disvalue;
                    @endphp
                    <li class="cart_items">
                            <div class="row">
                                <a style="font-size: 14px;display: flex;margin-left: 0%;align-items: center;" href="{{ route('public.cart.remove', $cartItem->rowId) }}" class="item_remove remove-cart-button col-md-2"><i class="fa fa-trash-o text-danger" data-toggle="tooltip" data-placement="top" title="Remove item"></i></a>
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-4" style="font-size: 14px;display: flex;flex-wrap: wrap;align-content: center;margin-left: 0%;">
                                            <img id="photo-img" src="{{ RvMedia::getImageUrl($product->image, null, false, RvMedia::getDefaultImage()) }}" data-zoom-enable="true" data-zoom-image="{{ RvMedia::getImageUrl($product->image, null, false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}" />
                                            
                                        </div>
                                        <div class="col-md-8">
                                            <span class="bust"> @php echo truncate($product->name, 25 ); @endphp </span></a>
                                            <p class = "cart_attributes">
                                                <small class = "cart_attributes_2">{{ $cartItem->options['attributes'] ?? '' }}</small>
                                            </p>
                                            @if (!empty($cartItem->options['extras']) && is_array($cartItem->options['extras']))
                                                @foreach($cartItem->options['extras'] as $option)
                                                    @if (!empty($option['key']) && !empty($option['value']))
                                                        <p class = "cart_attributes_3"><small>{{ $option['key'] }}: <strong> {{ $option['value'] }}</strong></small></p>
                                                    @endif
                                                @endforeach
                                            @endif
                                            <div class="row">
                                                <span class="cart_quantity col-md-5"> {{ $cartItem->qty }} x  </span>
                                                <div class="product_price col-md-7">
                                                    <del class="product-price-text sale_price"
                                                        @if ($product->front_sale_price == $disvalue && $product->front_sale_price == $product->price) 
                                                            style="display: none" 
                                                        @endif>{{ format_price($product->price_with_taxes) }}
                                                    </del>
                                                    <span class="on_sale" 
                                                        @if ($product->front_sale_price == $disvalue && $product->front_sale_price == $product->price) 
                                                            style="display: none" 
                                                        @endif>
                                                        @if ($disvalue==0)
                                                            <span class="on_sale_percentage_text">100%</span> <span>{{ __('Off') }}</span
                                                        @else 
                                                            <span class="on_sale_percentage_text">{{ get_sale_percentage($product->price, $disvalue) }}</span> <span>{{ __('Off') }}</span>
                                                        @endif
                                                    </span>
                                                    <span class="price product-sale-price-text" @if ($product->front_sale_price == $disvalue && $product->front_sale_price == $product->price) style="color: black" @endif>{{ format_price($disvalue) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </li>
                @endif
            @endforeach
        @endif
    </ul>
   
    <div class="cart_footer">
            <p class="cart_total sub_total" style="font-size: 14px;display: flex;margin-left: 0%;justify-content: flex-end;"><strong>{{ __('Sub Total') }}:</strong> <span class="cart_price cart_total_sub">{{ format_price($totalDiscount) }}</span></p>
            
            <a href="{{ route('public.cart') }}" class="cart_buttons">{{ __('View Cart') }}</a>
            @if (session('tracked_start_checkout'))
                <a href="{{ route('public.checkout.information', session('tracked_start_checkout')) }}" class="btn btn-outline-light rounded-pill mt-3 w-100">{{ __('Checkout') }}</a>
            @endif
            <button data-dismiss="modal" class="cart_buttons w-100 mt-3" style="background: black;">Continue Shopping</button>
    </div>
@else
    <p class="text-center">{{ __('Your cart is empty!') }}</p>
@endif