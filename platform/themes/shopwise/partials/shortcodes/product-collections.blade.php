<!-- START SECTION SHOP -->

<div class="section small_pt pb-0 container">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                    <div id="sidebar">
                        @include(Theme::getThemeNamespace() . '::views/ecommerce/includes/filters')
                    </div>
                </div>
            <div class="col-md-9">
                
            <!--<product-collections-component title="{!! clean($title) !!}"-->
            <!--    :product_collections="{{ json_encode($productCollections) }}" url="{{ route('public.ajax.products') }}">-->
            <!--</product-collections-component>-->
            <h3 class="feat">{!! clean($title) !!}</h2>
            <div class="row align-items-center">
                <featured-product-categories-component url="{{ route('public.ajax.featured-product-categories') }}"></featured-product-categories-component>
            </div>
            
            </div>
        </div>
    </div>
</div>

<!-- END SECTION SHOP -->