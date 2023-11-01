@if ($product)

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
   <div class="card card-bor-91 mt-3 card_m_height" style="height: fit-content;min-height: 350px;width: 100%;">
            
                <a class="" href="{{$product->url}}" cl>
                    <img src="{{ RvMedia::getImageUrl($product->image, null, false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}"  class="cat-img mx-auto">
                    @if ($product->productLabels->count())
                    @foreach ($product->productLabels as $label)
                        <span class="sale_grid" @if ($label->color) style="background-color: {{ $label->color }}" @endif>{{ $label->name }}</span>
                     @endforeach
                    @endif
                </a>
            <div class="card-body" style="min-height: 20px;">
                <a href="@if ($product->url==url('/')) {{$product->link}} @else {{$product->url}} @endif"><h3 class="text-black ">{{ \Illuminate\Support\Str::limit(strip_tags($product->name), 30, $end='...') }}</h3></a>
                
                
                <div class="product_price-grid">
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
                            
                
                
                
               @if (($product->isOutOfStock()))
                    <a class="btn btn-primary button-1" href="{{ url('/contact-us') }}">{{ __('Contact For Avalibility') }}</a>
                @else
                    @if (EcommerceHelper::isCartEnabled())
                    <div class="add-to-cart-button-div">
                    <a class="add-to-cart add-to-cart-button btn btn-23 pr_action_btn" data-id="{{ $product->id }}" href="#" data-url="{{ route('public.cart.add-to-cart') }}">{{ __('Add To Cart') }}</a>
                        
                    </div>
                    
                    @endif

                @endif
            </div>
        </div>

            {{-- @if (EcommerceHelper::isReviewEnabled())
                <div class="rating_wrap">
                    <div class="rating">
                        <div class="product_rate" style="width: {{ $product->reviews_avg * 20 }}%"></div>
                    </div>
                    <span class="rating_num">({{ $product->reviews_count }})</span>
                </div>
            @endif --}}
            <div class="pr_desc">
            </div>
    <script>
        $(document).ready(function () {
            'use strict';
            function carousel_slider() {
                $('.carousel_slider').each( function() {
                    var $carousel = $(this);
                    $carousel.owlCarousel({
                        dots : $carousel.data("dots"),
                        loop : $carousel.data("loop"),
                        items: $carousel.data("items"),
                        margin: $carousel.data("margin"),
                        mouseDrag: $carousel.data("mouse-drag"),
                        touchDrag: $carousel.data("touch-drag"),
                        autoHeight: $carousel.data("autoheight"),
                        center: $carousel.data("center"),
                        nav: $carousel.data("nav"),
                        rewind: $carousel.data("rewind"),
                        navText: ['<i class="ion-ios-arrow-left"></i>', '<i class="ion-ios-arrow-right"></i>'],
                        autoplay : $carousel.data("autoplay"),
                        animateIn : $carousel.data("animate-in"),
                        animateOut: $carousel.data("animate-out"),
                        autoplayTimeout : $carousel.data("autoplay-timeout"),
                        smartSpeed: $carousel.data("smart-speed"),
                        responsive: $carousel.data("responsive")
                    });
                });
            }

            function slick_slider() {
                $('.slick_slider').each( function() {
                    var $slick_carousel = $(this);
                    $slick_carousel.slick({
                        arrows: $slick_carousel.data("arrows"),
                        dots: $slick_carousel.data("dots"),
                        infinite: $slick_carousel.data("infinite"),
                        centerMode: $slick_carousel.data("center-mode"),
                        vertical: $slick_carousel.data("vertical"),
                        fade: $slick_carousel.data("fade"),
                        cssEase: $slick_carousel.data("css-ease"),
                        autoplay: $slick_carousel.data("autoplay"),
                        verticalSwiping: $slick_carousel.data("vertical-swiping"),
                        autoplaySpeed: $slick_carousel.data("autoplay-speed"),
                        speed: $slick_carousel.data("speed"),
                        pauseOnHover: $slick_carousel.data("pause-on-hover"),
                        draggable: $slick_carousel.data("draggable"),
                        slidesToShow: $slick_carousel.data("slides-to-show"),
                        slidesToScroll: $slick_carousel.data("slides-to-scroll"),
                        asNavFor: $slick_carousel.data("as-nav-for"),
                        focusOnSelect: $slick_carousel.data("focus-on-select"),
                        responsive: $slick_carousel.data("responsive")
                    });
                });
            }

            $('.popup-ajax').magnificPopup({
                type: 'ajax',
                callbacks: {
                    ajaxContentAdded: function() {
                        carousel_slider();
                        slick_slider();
                    }
                }
            });
        });
    </script>
@endif