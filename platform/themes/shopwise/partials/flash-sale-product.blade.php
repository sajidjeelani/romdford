@if($product)
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
$disvalue=round($disvalue,2);
@endphp

<div class="card card-bor-91">
    <div class="card ">
                <div class="countdown_time countdown_style4 mb-4" data-time="{{ $flashSale->end_date }}" data-days-text="{{ __('Days') }}" data-hours-text="{{ __('Hours') }}" data-minutes-text="{{ __('Minutes') }}" data-seconds-text="{{ __('Seconds') }}" ></div>

        @if ($product->isOutOfStock())
            <span class="sale" style="background-color: #000">{{ __('Out Of Stock') }}</span>
        @else
            @if ($product->productLabels->count())
                @foreach ($product->productLabels as $label)
                    <span class="sale" @if ($label->color) style="background-color: {{ $label->color }}" @endif>{{ $label->name }}</span>
                @endforeach
            @endif
        @endif
        <a href="@if ($product->url==url('/')) {{$product->link}} @else {{$product->url}} @endif">
            <img class="cat-img" src="{{ RvMedia::getImageUrl($product->image, 'medium', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}">
        </a>
    </div>
    <div class="card-body">
        <div class="product_info">
            <h5 class="product_title"><a href="@if ($product->url==url('/')) {{$product->link}} @else {{$product->url}} @endif">{{ \Illuminate\Support\Str::limit(strip_tags($product->name), 30, $end='...') }}</a></h5>
            <div class="product_price">
                <div >
                                <div class="product_price" style="margin-left: 10%;">
                                    <del class="product-price-text sale_price"@if ($product->front_sale_price == $disvalue && $product->front_sale_price == $product->price) style="display: none" @endif>{{ format_price($product->price_with_taxes) }}</del>
                                    <span class="on_sale" @if ($product->front_sale_price == $disvalue && $product->front_sale_price == $product->price) style="display: none" @endif>
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
            
            @if (($product->isOutOfStock()))
                    <a class="btn btn-primary button-1" href="{{ url('/contact-us') }}">{{ __('Contact For Avalibility') }}</a>
                @else
                    @if (EcommerceHelper::isCartEnabled())
                    <div class="list_product_action_box">
                    <ul class="list_none pr_action_btn">
                        <li class="add-to-cart"><a class="add-to-cart-button btn btn-23 pr_action_btn" data-id="{{ $product->id }}" href="#" data-url="{{ route('public.cart.add-to-cart') }}">{{ __('Add To Cart') }}</a></li>
                    </ul>
                    </div>
                    @endif

                @endif
        </div>
    </div>

</div>
@endif