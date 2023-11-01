@php Theme::set('pageName', __('Products')) @endphp

<div class="section">
    <form  method="GET">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div id="sidebar">
                        @include(Theme::getThemeNamespace() . '::views/ecommerce/includes/filters')
                    </div>
                </div>
                
                <div class="col-lg-9">
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