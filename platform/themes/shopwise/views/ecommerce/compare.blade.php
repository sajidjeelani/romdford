@php Theme::set('pageName', SeoHelper::getTitle()) @endphp

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="compare_box">
                    @if (Cart::instance('compare')->count())
                        @php
                            $withCount = [];
                            if (EcommerceHelper::isReviewEnabled()) {
                                $withCount = [
                                    'reviews',
                                    'reviews as reviews_avg' => function ($query) {
                                        $query->select(DB::raw('avg(star)'));
                                    },
                                ];
                            }
                            $products = app(\Botble\Ecommerce\Repositories\Interfaces\ProductInterface::class)->advancedGet([
                               'condition' => [
                                    ['ec_products.id', 'IN', Cart::instance('compare')->content()->pluck('id')->all()],
                                    'ec_products.status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED,
                                ],
                               'with' => [
                                    'variations',
                                    'productCollections',
                                    'variationAttributeSwatchesForProductList',
                                    'promotions',
                                    'latestFlashSales',
                                ],
                                'withCount' => $withCount,
                            ]);

                        @endphp
                        <div class="table-responsive table__compare">
                            <table class="table table-bordered text-center">
                                <tbody>
                                <tr class="pr_image">
                                    <td class="row_title">Product Image</td>
                                    @foreach(Cart::instance('compare')->content() as $item)
                                        @php
                                            $product = $products->find($item->id);
                                        @endphp
                                        @if (!empty($product))
                                            <td class="row_img">
                                                <a href="{{ $product->original_product->url }}"><img src="{{ RvMedia::getImageUrl($product->image, 'thumb', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}"></a>
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                                <tr class="pr_title">
                                    <td class="row_title">Product Name</td>
                                    @foreach(Cart::instance('compare')->content() as $item)
                                        @php
                                            $product = $products->find($item->id);
                                        @endphp
                                        @if (!empty($product))
                                            <td class="product_name">
                                                <h5><a href="{{ $product->original_product->url }}">{{ $product->name }}</a></h5>
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                                <tr class="pr_price">
                                    <td class="row_title">Price</td>
                                    @foreach(Cart::instance('compare')->content() as $item)
                                        @php
                                            $product = $products->find($item->id);
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
                                        @if (!empty($product))
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
                                        @endif
                                    @endforeach
                                </tr>
                                @if (EcommerceHelper::isReviewEnabled())
                                    <tr class="pr_rating">
                                        <td class="row_title">{{ __('Rating') }}</td>
                                        @foreach(Cart::instance('compare')->content() as $item)
                                            @php
                                                $product = $products->find($item->id);
                                            @endphp
                                            @if (!empty($product))
                                                <td>
                                                    <div class="rating_wrap">
                                                        <div class="rating">
                                                            <div class="product_rate" style="width: {{ $product->reviews_avg * 20 }}%"></div>
                                                        </div>
                                                        <span class="rating_num">({{ $product->reviews_count }})</span>
                                                    </div>
                                                </td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endif
                                <tr class="description">
                                    <td class="row_title">{{ __('Description') }}</td>
                                    @foreach(Cart::instance('compare')->content() as $item)
                                        @php
                                            $product = $products->find($item->id);
                                        @endphp
                                        @if (!empty($product))
                                            <td class="row_text font-xs">
                                                <p>
                                                    {!! clean($product->description) !!}
                                                </p>
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>

                                @php
                                    $attributeSets = app(\Botble\Ecommerce\Repositories\Interfaces\ProductAttributeSetInterface::class)->getAllWithSelected(Cart::instance('compare')->content()->pluck('id'));
                                @endphp

                                {{-- @foreach($attributeSets as $attributeSet)
                                    <tr>
                                        <td class="row_title">
                                             {{ $attributeSet->title }}
                                        </td>

                                        @foreach(Cart::instance('compare')->content() as $item)
                                            @php
                                                $product = $products->find($item->id);
                                            @endphp

                                            @if (!empty($product))
                                                @php
                                                    $attributes = app(\Botble\Ecommerce\Repositories\Interfaces\ProductInterface::class)->getRelatedProductAttributes($product)->where('attribute_set_id', $attributeSet->id)->sortBy('order');
                                                @endphp

                                                @if ($attributes->count())
                                                    @if ($attributeSet->display_layout == 'dropdown')
                                                        <td>
                                                            @foreach($attributes as $attribute)

                                                                {{ $attribute->title }}@if (!$loop->last), @endif
                                                            @endforeach
                                                        </td>
                                                    @elseif ($attributeSet->display_layout == 'text')
                                                        <td>
                                                            <div class="attribute-values">
                                                                <ul class="text-swatch attribute-swatch color-swatch">
                                                                    @foreach($attributes as $attribute)
                                                                        <li class="attribute-swatch-item" style="display: inline-block">
                                                                            <label>
                                                                                <input class="form-control product-filter-item" type="radio" disabled>
                                                                                <span  @if({{ $attribute->title }} == 'Size') style="cursor: default"  @else style="cursor: default">{{ $attribute->title }}</span>
                                                                            </label>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <div class="attribute-values">
                                                                <ul class="visual-swatch color-swatch attribute-swatch">
                                                                    @foreach($attributes as $attribute)
                                                                        <li class="attribute-swatch-item" style="display: inline-block">
                                                                            <div class="custom-radio">
                                                                                <label>
                                                                                    <input class="form-control product-filter-item" type="radio" disabled>
                                                                                    <span style="{{ $attribute->image ? 'background-image: url(' . RvMedia::getImageUrl($attribute->image) . ');' : 'background-color: ' . $attribute->color . ';' }}; cursor: default;"></span>
                                                                                </label>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    @endif
                                                @else
                                                    <td>&mdash;</td>
                                                @endif
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach--}}
                                <tr>
                                        <td class="row_title">{{ __('Size') }}</td>
                                        @foreach(Cart::instance('compare')->content() as $item)
                                                                                        @php $product1 = $products->find($item->id); @endphp

                                            <td class="row_btn">H: {{$product1->height}} cm<br>W: {{$product1->wide}} cm<br>D: {{$product1->length}} cm</td>
                                           

                                        @endforeach
                                </tr>
                                @if (EcommerceHelper::isCartEnabled())
                                    <tr class="pr_add_to_cart">
                                        <td class="row_title">{{ __('Buy now') }}</td>
                                        @foreach(Cart::instance('compare')->content() as $item)
                                            <td class="row_btn"><a class="btn btn-fill-out add-to-cart-button" data-id="{{ $item->id }}" href="#" data-url="{{ route('public.cart.add-to-cart') }}"><i class="icon-basket-loaded"></i> {{ __('Add To Cart') }}</a></td>
                                        @endforeach
                                    </tr>
                                @endif
                                <tr class="pr_remove">
                                    <td class="row_title"></td>

                                    @foreach(Cart::instance('compare')->content() as $item)
                                        <td class="row_remove"><a class="js-remove-from-compare-button" href="#" data-url="{{ route('public.compare.remove', $item->id) }}"><small><i class="ti-close"></i></small> <span>{{ __('Remove') }}</span></a></td>
                                    @endforeach
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center">{{ __('No products in compare list!') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>