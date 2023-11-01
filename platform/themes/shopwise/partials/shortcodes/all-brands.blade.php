<!--<div class="section pt-0 small_pb">
    <div class="container">
        @if (clean($title))
            <div class="heading_tab_header">
                <div class="heading_s2">
                    <h4>{!! clean($title) !!}</h4>
                </div>
            </div>
        @endif
        @if ($brands->count() > 0)
            <div class="row">
                @foreach($brands as $brand)
                    <div class="col-md-3 col-6" style="margin-bottom: 10px;">
                        <a href="{{ $brand->url }}">
                            <img src="{{ RvMedia::getImageUrl($brand->logo) }}" alt="{{ $brand->name }}">
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
--><div class="row">
            <!--<div class="col-md-3">
                    <div id="sidebar">
                        @include(Theme::getThemeNamespace() . '::views/ecommerce/includes/filters')
                    </div>
                </div>-->
            <div class="col-md-12">
                
            
            <h3 class="feat">{!! clean($title) !!}</h2>
            <div class="row align-items-center">
               <flash-sale-products-component url="{{ route('public.ajax.get-flash-sales') }}"></flash-sale-products-component>
            </div>
            
            </div>
        </div>
<!-- END SECTION SHOP -->