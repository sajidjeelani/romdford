@php
    Theme::asset()->remove('app-js');
    Theme::set('pageName', $product->name);
@endphp 
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Send to friend</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('public.send-mail') }}" >
            @csrf
          <p>Your Friend Will get your message & product to view this product.</p>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Recipient Email:</label>
            <input type="email" class="form-control" id="recipient-mail" name="recipient-mail" required>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text" name="message-text"></textarea>
            <textarea style="display: none;" class="form-control" id="url" name="url">{{ url()->current() }}</textarea>
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Send Now</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
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
    
@endphp
    <div class="section">
        <div class="container bg-white pt-5">
            <div class="row">
                <div class="col-md-6">
                    @if ($product->link != null)
                        @php
                        $productimages=explode(',',$product->link);
                        $i=0;
                        @endphp
                            <div>
                                <img id="photo-img" style="width: 100%;" src="{{$productimages[0]}}" data-zoom-enable="true" data-zoom-image="{{ RvMedia::getImageUrl($productimages[0], null, false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}" />
                                <a href="#" class="product_img_zoom" title="Zoom">
                                    <span class="linearicons-zoom-in"></span>
                                </a>
                            </div>
                            
                        
                    @else
                        <div>
                            <img id="photo-img" src="{{ RvMedia::getImageUrl($product->image, null, false, RvMedia::getDefaultImage()) }}" data-zoom-enable="true" data-zoom-image="{{ RvMedia::getImageUrl($product->image, null, false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}" />
                            <a href="#" class="product_img_zoom" title="Zoom">
                                <span class="linearicons-zoom-in"></span>
                            </a>
                        </div>

                    @endif
                    <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-slides-to-show="4" data-slides-to-scroll="1" data-infinite="false">
                            @foreach ($productImages as $img)
                                <div class="item">
                                    <a href="#" class="product_gallery_item @if ($loop->first) active @endif" data-image="{{ RvMedia::getImageUrl($img) }}" data-zoom-image="{{ RvMedia::getImageUrl($img) }}">
                                        <img src="{{ RvMedia::getImageUrl($img, 'thumb') }}" alt="{{ $product->name }}"/>
                                    </a>
                                </div>
                            @endforeach
                    </div>
                        
                </div>
                <div class="col-md-6">
                    <div class="pr_detail">
                        <div class="product_description">
                        <div style="margin-bottom: 7%;">
                            @if ($product->productLabels->count())
                                @foreach ($product->productLabels as $label)
                                <span class="sale1" @if ($label->color) style="background-color: {{ $label->color }} !important " @endif>{{ $label->name }}</span>
                                @endforeach
                            @endif
                        </div>
                        <h1><a class="prodt" href="@if ($product->url==url('/')) {{$product->link}} @else {{$product->url}} @endif" >{{ $product->name }}</a></h1>
                        
                        @if (EcommerceHelper::isReviewEnabled())
                            @if ($product->reviews_count > 0)
                                <div class="rating_wrap">
                                    <div class="rating">
                                        <div class="product_rate" style="width: {{ $product->reviews_avg * 20 }}%"></div>
                                    </div>
                                    
                                        @if($product->reviews_avg<=1)
                                            <span class="fa fa-star checked"></span>
                                        @elseif($product->reviews_avg<=2)
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                        @elseif($product->reviews_avg<=3)
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                        @elseif($product->reviews_avg<=4)
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                        @elseif($product->reviews_avg<=5)
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                        @endif
                                        
                                    <span class="rating_num">({{ $product->reviews_count }})</span>
                                    
                                </div>
                            @else
                                <p>No Reviews Yet</p>    
                            @endif
                        @endif
                        
                        <div class="clearfix"></div>
                        <div class="thouth">
                            <p>{!! clean($product->description, 'youtube') !!}</p>
                        </div>
                        <h5 class="pt-3">{{ __('SKU') }}: <span id="product-sku">{{ $product->sku }}</span></h5>
                            
                        <div class="product_price">
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
                        <div class="row">
                            <div class="col-md-4">Height: {!! clean($product->height) !!} cm</div>
                            <div class="col-md-4">Width: {!! clean($product->wide) !!} cm</div>
                            <div class="col-md-4">Depth: {!! clean($product->length) !!} cm</div>
                        </div>
                        @if ($product->variations()->count() > 0)
                            <div class="pr_switch_wrap">
                                {!! render_product_swatches($product, [
                                    'selected' => $selectedAttrs,
                                    'view'     => Theme::getThemeNamespace() . '::views.ecommerce.attributes.swatches-renderer'
                                ]) !!}
                            </div>
                        @endif

                        {{-- <hr /> --}}
                        <div class="cart_extra">
                            <form class="add-to-cart-form" method="POST" action="{{ route('public.cart.add-to-cart') }}">
                                @csrf
                                {!! apply_filters(ECOMMERCE_PRODUCT_DETAIL_EXTRA_HTML, null) !!}
                                <input type="hidden" name="id" id="hidden-product-id" value="{{ ($product->is_variation || !$product->defaultVariation->product_id) ? $product->id : $product->defaultVariation->product_id }}"/>
                                @if (EcommerceHelper::isCartEnabled())
                                    <div class="cart-product-quantity">
                                        {{-- <div class="quantity float-left">
                                            <input type="button" value="-" class="minus">
                                            <input type="text" name="qty" value="1" title="{{ __('Qty') }}" class="qty" size="4">
                                            <input type="button" value="+" class="plus">
                                        </div> &nbsp; --}}
                                        <div class="float-right number-items-available" style="@if ($product->isOutOfStock()) display: none; @endif line-height: 45px;">
                                            @if ($product->isOutOfStock())
                                                <span class="text-danger">({{ __('Out of stock') }})</span>
                                            @endif
                                        </div>
                                    </div>
                                    <br>
                                    @endif
                                <div class="cart_btn">
                                @if ($product->isOutOfStock())
                                    <button class="btn btn-primary button-1">
                                        {{ __('Contact for Availability')}}
                                    </button>
                                @else
                                    @if (EcommerceHelper::isCartEnabled())
                                        <button class="btn btn-primary btn-112 @if ($product->isOutOfStock()) btn-disabled @endif" type="submit" @if ($product->isOutOfStock()) disabled @endif>{{ __('Add to cart') }}</button>
                                    @endif
                                    @if (EcommerceHelper::isQuickBuyButtonEnabled())
                                        &nbsp;
                                        <button class="btn btn-primary btn-113 @if ($product->isOutOfStock()) btn-disabled @endif" type="submit" @if ($product->isOutOfStock()) disabled @endif name="checkout">{{ __('Quick Buy') }}</button>
                                    @endif
                                @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <a class="add_wishlist js-add-to-wishlist-button" href="#" data-url="{{ route('public.wishlist.add', $product->id) }}"><h3 class="wish_icon">
                                                <span class="add_me_in_wish"> <i class="fa fa-heart-o hart"></i></span> {{'Add To Wishlist'}}</h3>
                                            </a>
                                    </div>
                                    <div class="col-md-4">
                                        <h3 class="friend_icon" style="cursor:pointer" data-toggle="modal" data-target="#exampleModal" ><span class="send_to_friend"><i class="fa fa-envelope hart" aria-hidden="true"></i></span> Send to friend</h3>
                                    </div>
                                    <div class="col-md-4">
                                        <h3 class="print_icon" onclick="window.print()" style="cursor:pointer"><span class="print_out" ><i class="fa fa-print hart" aria-hidden="true"></i></span> Print</h3>
                                    </div>
                                        {{-- <a class="add_compare js-add-to-compare-button" data-url="{{ route('public.compare.add', $product->id) }}" href="#"><i class=""></i></a> --}}
                                </div>
                                <br>
                                <div class="success-message text-success" style="display: none;">
                                    <span></span>
                                </div>
                                <div class="error-message text-danger" style="display: none;">
                                    <span></span>
                                </div>
                            </form>
                        </div>
                        <hr />
                        {{-- <ul class="product-meta">
                            
                            <li>{{ __('Category') }}:
                                @foreach ($product->categories()->get() as $category)
                                    @php $categoryId=$category->id; @endphp
                                    <a href="{{ $category->url }}">{{ $category->name }}</a>@if (!$loop->last),@endif
                                @endforeach
                            </li>
                            @if (!$product->tags->isEmpty())
                                <li>{{ __('Tags') }}:
                                    @foreach ($product->tags as $tag)
                                        <a href="{{ $tag->url }}" rel="tag">{{ $tag->name }}</a>@if (!$loop->last),@endif
                                    @endforeach
                                </li>
                            @endif
                        </ul> --}}
                        <div class="product_share">
                            {{-- <span>{{ __('Share') }}:</span> --}}
                            <ul class="social_icons">
                                <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($product->url) }}&title={{ rawurldecode($product->description) }}" target="_blank" title="{{ __('Share on Facebook') }}"><i class="ion-social-facebook"></i></a></li>
                                <li><a href="https://twitter.com/intent/tweet?url={{ urlencode($product->url) }}&text={{ rawurldecode($product->description) }}" target="_blank" title="{{ __('Share on Twitter') }}"><i class="ion-social-twitter"></i></a></li>
                                <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($product->url) }}&summary={{ rawurldecode($product->description) }}&source=Linkedin" title="{{ __('Share on Linkedin') }}" target="_blank"><i class="ion-social-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="large_divider clearfix"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="text134">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">{{ __('Description') }}</a>
                            </li>
                            @if (EcommerceHelper::isReviewEnabled())
                                <li class="nav-item">
                                    <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">{{ __('Reviews') }} ({{ $product->reviews_count }})</a>
                                </li>
                            @endif
                        </ul>
                        <div class="tab-content width-text">
                            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                <div id="app">
                                    {!! clean($product->content, 'youtube') !!}
                                </div>
                                
                                @if (theme_option('facebook_comment_enabled_in_product', 'yes') == 'yes')
                                    <br />
                                    {!! apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, Theme::partial('comments')) !!}
                                @endif
                            </div>
                            @if (EcommerceHelper::isReviewEnabled())
                                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                    <div id="list-reviews">
                                        <div class="comments">
                                            <h5 class="product_tab_title">{{ __(':count Reviews For :product', ['count' => $product->reviews_count, 'product' => $product->name]) }}</h5>
                                            <product-reviews-component url="{{ route('public.ajax.product-reviews', $product->id) }}"></product-reviews-component>
                                        </div>
                                    </div>
                                    <div class="review_form field_form mt-3">
                                        <h5>{{ __('Add a review') }}</h5>
                                        @if (!auth('customer')->check())
                                            <p class="text-danger">{{ __('Please') }} <a href="{{ route('customer.login') }}">{{ __('login') }}</a> {{ __('to write review!') }}</p>
                                        @endif
                                        {!! Form::open(['route' => 'public.reviews.create', 'method' => 'post', 'class' => 'row form-review-product']) !!}
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="star" value="1">
                                            <div class="form-group col-12">
                                                <div class="star_rating">
                                                    <span data-value="1"><i class="ion-star"></i></span>
                                                    <span data-value="2"><i class="ion-star"></i></span>
                                                    <span data-value="3"><i class="ion-star"></i></span>
                                                    <span data-value="4"><i class="ion-star"></i></span>
                                                    <span data-value="5"><i class="ion-star"></i></span>
                                                </div>
                                            </div>
                                            <div class="form-group col-12">
                                                <textarea class="form-control" name="comment" id="txt-comment" rows="4" placeholder="{{ __('Write your review') }}" @if (!auth('customer')->check()) disabled @endif></textarea>
                                            </div>
                                            <div class="form-group col-12">
                                                <button type="submit" class="btn btn-fill-out @if (!auth('customer')->check()) btn-disabled @endif" @if (!auth('customer')->check()) disabled @endif name="submit" value="Submit">Submit Review</button>
                                            </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @php
                $crossSellProducts = get_cross_sale_products($product);
            @endphp
            {{-- @if (count($crossSellProducts) > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="small_divider"></div>
                        <div class="divider"></div>
                        <div class="medium_divider"></div>
                    </div>
                </div>
                <div class="row shop_container grid">
                    <div class="col-12">
                        <div class="heading_s1">
                            <h3>{{ __('Customers who bought this item also bought') }}</h3>
                        </div>
                        <div class="releted_product_slider carousel_slider owl-carousel owl-theme" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
                            @foreach ($crossSellProducts as $crossSellProduct)
                                {!! Theme::partial('product-item-grid', ['product' => $crossSellProduct]) !!}
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif --}}

            <div class="row shop_container grid">
                <div class="col-12">
                    <div class="heading_s1">
                        <h3>{{ __('Related Products') }}</h3>
                    </div>
                </div>
                <div class="container">
                    @foreach ($product->categories()->get() as $category)
                        @php
                            $relatedProducts = get_categories_products($category->id);
                        @endphp
                    @endforeach
                    <div class="releted_product_slider carousel_slider owl-carousel owl-theme" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}}'>
                        @if (!empty($relatedProducts))
                            @foreach ($relatedProducts as $related)
                            <div>
                                {!! Theme::partial('product-item', ['product' => $related]) !!}
                            </div>
                            @endforeach
                        @endif
                    </div>
</div>
</div>
</div>
</div>
</div>
<script src="https://romfordgifts.co.uk/dev/public/vendor/core/plugins/ecommerce/js/utilities.js"></script>


    [newsletter-form title="Get Newsletter" subtitle="Get 5% OFF On Your First Order When You Sign Up"][/newsletter-form]
@endif