<!-- START SECTION SHOP -->
<div class="container">
    <div class="row">
            <div class="col-md-12">
                <div class="bbb_viewed">
                    <div class="container">
                        <div class="row">
                            <div class="bbb_main_container">
                                <div class="bbb_viewed_title_contanier row">
                                    <div class="col-md-6"><h1 class="bbb_viewed_title text-danger text-start">FLASH SALE</h1></div>
                                    <div class="col-md-6"><h3 class="text-right"><b>Expires in 20 : 00 :30</b></h3></div>
                                    <!--<h1 class="bbb_viewed_title text-danger col-md-6">{!! clean($title) !!}</h1>-->
                                     
                                    <div class="bbb_viewed_nav_container col-md-6">
                                        
                                    </div>
                                </div>
                            {{-- <div class="view_all">
                                <a href="{{ route('public.products') }}" class="text_default"><i class="linearicons-power"></i> <span>{{ __('View All') }}</span></a>
                            </div> --}}
                                <div class="bbb_viewed_slider_container">
                                    <trending-products-component url="{{ route('public.ajax.trending-products') }}"></trending-products-component>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<!-- END SECTION SHOP -->
