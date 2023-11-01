@php Theme::set('pageName', __('Wishlist')) @endphp

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive shop_cart_table wishlist-table">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="product-thumbnail">{{ __('Image') }}</th>
                            <th class="product-name">{{ __('Product') }}</th>
                            <th class="product-price">{{ __('Price') }}</th>
                            <th class="product-subtotal">{{ __('Add to cart') }}</th>
                            <th class="product-remove">{{ __('Remove') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if (auth('customer')->check())
                                @if (count($wishlist) > 0 && $wishlist->count() > 0)
                                    @foreach ($wishlist as $item)
                                        @php $item = $item->product; @endphp
                                          @php
                                            $product = $item;
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
                                                
                                            
                                        @endphp
                                        <tr>
                                            <td class="product-thumbnail">
                                                <img alt="{{ $item->name }}" width="50" height="70" class="img-fluid"
                                                     style="max-height: 75px"
                                                     src="{{ RvMedia::getImageUrl($item->image, 'thumb', false, RvMedia::getDefaultImage()) }}">
                                            </td>
                                            <td class="product-name" data-title="{{ __('Product') }}">
                                                <a href="{{ $item->original_product->url }}">{{ $item->name }}</a>
                                            </td>
                                          <td class="product_price">
                                                <del class="product-price-text sale_price"@if ($product->front_sale_price == $disvalue && $product->front_sale_price == $product->price) style="display: none" @endif>{{ format_price($product->price_with_taxes) }}</del>
                            <span class="on_sale" @if ($product->front_sale_price == $disvalue && $product->front_sale_price == $product->price) style="display: none" @endif>
                                @if ($disvalue==0)
                                    <span class="on_sale_percentage_text">100%</span> <span>{{ __('Off') }}</span
                                @else 
                                    <span class="on_sale_percentage_text">{{ get_sale_percentage($product->price, $disvalue) }}</span> <span>{{ __('Off') }}</span>
                                @endif
                            </span>
                            <span class="price product-sale-price-text" @if ($product->front_sale_price == $disvalue && $product->front_sale_price == $product->price) style="color: black" @endif>{{ format_price($disvalue) }}</span>
                                            </td>
                                  <td class="row_btn">           @if ($item->isOutOfStock())
                                    <button class="btn btn-primary button-1">
                                        {{ __('Contact for Availability')}}
                                    </button>
                                @else
                                    @if (EcommerceHelper::isCartEnabled())
                                        <a class="btn btn-fill-out add-to-cart-button" data-id="{{ $item->id }}" href="#" data-url="{{ route('public.cart.add-to-cart') }}"><i class="icon-basket-loaded"></i> {{ __('Add To Cart') }}</a> 
                                    @endif
                                    
                                @endif</td>
                                            <td class="product-remove" data-title="{{ __('Remove') }}">
                                                <a class="btn btn-dark btn-sm js-remove-from-wishlist-button" href="#" data-url="{{ route('public.wishlist.remove', $item->id) }}">{{ __('Remove') }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">{{ __('No product in wishlist!') }}</td>
                                    </tr>
                                @endif
                            @else
                                @if (Cart::instance('wishlist')->count())
                                    @foreach(Cart::instance('wishlist')->content() as $cartItem)
                                        @php
                                            $item = app(\Botble\Ecommerce\Repositories\Interfaces\ProductInterface::class)->findById($cartItem->id);
                                        @endphp
                                        @if (!empty($item))
         
                                        @php
                                            $product = $item;
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
                                                
                                            
                                        @endphp
                                            <tr>
                                                <td class="product-thumbnail">
                                                    <img alt="{{ $item->name }}" width="50" height="70" class="img-fluid"
                                                         style="max-height: 75px"
                                                         src="{{ RvMedia::getImageUrl($item->image, 'thumb', false, RvMedia::getDefaultImage()) }}">
                                                </td>
                                                <td class="product-name" data-title="{{ __('Product') }}">
                                                    <a href="{{ $item->original_product->url }}">{{ $item->name }}</a>
                                                </td>
                                                                               </div>
                                                </td>                 
                                                
                                                
                                                <td class="product_price">
                                                <del class="product-price-text sale_price"@if ($product->front_sale_price == $disvalue && $product->front_sale_price == $product->price) style="display: none" @endif>{{ format_price($product->price_with_taxes) }}</del>
                            <span class="on_sale" @if ($product->front_sale_price == $disvalue && $product->front_sale_price == $product->price) style="display: none" @endif>
                                @if ($disvalue==0)
                                    <span class="on_sale_percentage_text">100%</span> <span>{{ __('Off') }}</span
                                @else 
                                    <span class="on_sale_percentage_text">{{ get_sale_percentage($product->price, $disvalue) }}</span> <span>{{ __('Off') }}</span>
                                @endif
                            </span>
                            <span class="price product-sale-price-text" @if ($product->front_sale_price == $disvalue && $product->front_sale_price == $product->price) style="color: black" @endif>{{ format_price($disvalue) }}</span>
                                            </td>
                                                <td class="row_btn">           @if ($item->isOutOfStock())
                                    <button class="btn btn-primary button-1">
                                        {{ __('Contact for Availability')}}
                                    </button>
                                @else
                                    @if (EcommerceHelper::isCartEnabled())
                                        <a class="btn btn-fill-out add-to-cart-button" data-id="{{ $item->id }}" href="#" data-url="{{ route('public.cart.add-to-cart') }}"><i class="icon-basket-loaded"></i> {{ __('Add To Cart') }}</a> 
                                    @endif
                                    
                                @endif</td>
                                                <td class="product-remove" data-title="{{ __('Remove') }}">
                                                    <a class="btn btn-dark btn-sm js-remove-from-wishlist-button" href="#" data-url="{{ route('public.wishlist.remove', $item->id) }}">{{ __('Remove') }}</a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">{{ __('No product in wishlist!') }}</td>
                                    </tr>
                                @endif
                            @endif
                        </tbody>
                    </table>
                </div>

                @if (auth('customer')->check())
                    <div class="mt-3 justify-content-center pagination_style1">
                        {!! $wishlist->links() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>