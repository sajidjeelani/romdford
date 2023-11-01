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
    <div class="card" style="height: fit-content; min_height:350px;">
        <div class="rowforlist row wid">
           
                <!--ye wala part hai jis ki wajah bohot zyada space aaa raha hai-->
                <div class="card-body" id="" style="min-height: 209px;"> 
                <div class="container-fluid">
                    <div class="row">
                <div class="col-md-4">
                <img src="{{ RvMedia::getImageUrl($product->image, null, false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}"  class="cat-img">
                @if ($product->productLabels->count())
                @foreach ($product->productLabels as $label)
                    <span class="sale" @if ($label->color) style="background-color: {{ $label->color }}" @endif>{{ $label->name }}</span>
                 @endforeach
                @endif
                </div>
                
                
                <div class="col-md-8">
                
                    <a href="@if ($product->url==url('/')) {{$product->link}} @else {{$product->url}} @endif"><h2 class="text-black pname">{{ $product->name }}</h2></a>
                    <div class="mt-4 pr_desc">
                        <p>{!! clean($product->description) !!}</p>
                    </div>
                    <div></div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 px-0 text-center">
                                <a href="#" class="js-add-to-compare-button mb-1 text-center " data-url="{{ route('public.compare.add', $product->id) }}"><i class="fa fa-plus fa-xs" aria-hidden="true"></i> Add to Compare</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div></div>
                            
                            
                            
                            <div class="col-md-4 px-0">
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
                            </div>
                            
                            
                            
                            <div class="col-md-8 px-0"> 
                                @if (($product->isOutOfStock()))
                                    <a class="btn btn-primary button-1" href="{{ url('/contact-us') }}">{{ __('Contact For Avalibility') }}</a>
                                @else
                                    @if (EcommerceHelper::isCartEnabled())
                                        <div class="list_product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart"><a class="add-to-cart-button btn btn-23 pr_action_btn float-right" data-id="{{ $product->id }}" href="#" data-url="{{ route('public.cart.add-to-cart') }}">{{ __('Add To Cart') }}</a></li>
                                            </ul>
                                        </div>
                                    @endif
                                @endif                         
                            </div>
                        
                        
                        
                        </div>
                        
                    </div>
                    
                    @if (count($product->variationAttributeSwatchesForProductList))
                        <div class="pr_switch_wrap">
                            <div class="product_color_switch"> 
                                @foreach($product->variationAttributeSwatchesForProductList->unique('attribute_id') as $attribute)
                                    @if ($attribute->display_layout == 'visual')
                                        <span @if ($attribute->image) style="background-image: url({{ RvMedia::getImageUrl($attribute->image) }});" @else data-color="{{ $attribute->color }}" @endif></span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                </div>
            </div>
            
            
            
            
            
            </div>
        </div>
    </div>

@endif