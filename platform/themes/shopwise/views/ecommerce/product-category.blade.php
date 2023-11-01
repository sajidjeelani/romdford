@php Theme::set('pageName', $category->name) @endphp

<div class="section" style="min-height: fit-content;">
    <form action="{{ URL::current() }}" method="GET">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div id="sidebar">
                        @include(Theme::getThemeNamespace() . '::views/ecommerce/includes/filters')
                    </div>
                </div>
                <div class="col-lg-9">
                    @if($category->description!=NULL)
                        <div class="category-desc">
                                <div style="color: white;">
                                  {!! clean($category->description) !!}  
                                </div>
                        </div>
                    @endif
                   <div class="row" style="margin-top: 1%;">
                        @if ($category->children->count() > 0)
                            @foreach($category->children as $product)
                                @if ($product->status=='published') 
                                    <div>
                                        <div class="card ml-3 mb-3" style="width: 12rem; height: fit-content;">
                                          <a href="{{$product->url}}">
                                              <img style="height: 160px;" src="{{ RvMedia::getImageUrl($product->image, null, false, RvMedia::getDefaultImage()) }}" class="card-img-top" alt="{{$product->name}}">
                                          </a>
                                          <div class="card-body">
                                            <h5 class="card-title">{{$product->name}}</h5>
                                          </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="row d-flex"> 
                        <div class="col-12">
                            <div class="product_header">
                                @include(Theme::getThemeNamespace() . '::views/ecommerce/includes/sort')
                            </div>
                        </div>
                    </div>
                    @if ($products->count() > 0)
                        <div class="row list" id="shop_container">
                            @foreach($products as $product)
                                @php 
                                    $words = str_word_count($product->description, 1); // Split the text into an array of words
                                    $product->description = implode(' ', array_slice($words, 0, 70)); // Select the first 30 words and join them back into a string
                                    $product->description=$product->description . " ...";
                                @endphp
                                <div class="listview" id="listview" style="display:none;">
                                    {!! Theme::partial('product-item-grid', compact('product')) !!}
                                </div>
                                <div class="gridview" id="gridview" style="width: 30%;">
                                    {!! Theme::partial('product-item', compact('product')) !!}
                                </div>
                            @endforeach
                        </div>

                        <div class="row shop_container grid" style="width: 100%;">
                            <div class="col-12">
                                <div class="heading_s1">
                                    <h3>{{ __('Related Products') }}</h3>
                                </div>
                            </div>
                            <div class="container">
                                @php
                                    $relatedProducts = get_categories_products($category->id);
                                @endphp
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
                    @else
                        <br>
                        <div class="col-12 text-center">{{ __('No products!') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>
<!-- END SECTION SHOP -->