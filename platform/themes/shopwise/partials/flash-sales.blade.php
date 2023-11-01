{!! Theme::partial('header') !!}


    @php
        $products=get_products();
        $name=array();
        $i=0;
        foreach ($products as $product){
            $name[$i]=($product->name);
            $i++;
            }
    
        if (is_plugin_active('ecommerce')) {
            $categories = get_product_categories(['status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED], ['slugable', 'children', 'children.slugable', 'icon'], [], true);
        } else {
            $categories = [];
        }
    @endphp
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- END HEADER -->
<div class="section">
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
                                
                            </div>
                           
                        </div>
                    </div>
                    @php
                        $flashSale = get_flashSale_products();
                        $endDateRecords = DB::table('ec_flash_sales')->select('end_date')->get();
                        foreach($endDateRecords as $endDate)
                            $timer=$endDate;
                        $currentDate = new DateTime(); // current date and time
                        $targetDate = new DateTime($timer->end_date); // your target date
                        
                        // Calculate the difference
                        $interval = $currentDate->diff($targetDate);
                        
                            $status = DB::table('ec_flash_sales')->select('status')->get();
                        foreach($status as $status){
                            $status1=$status;
                        }
                    @endphp

                    @if ($products->count() > 0 && $status1->status == 'published')
                    <div class="row list" id="shop_container">
                        <div class="row" style="max-width:100% ;width:100%">
                            <div class="col-md-6">
                                <div class=" bbb_viewed_title text-danger text-start" style="margin-left: 4%;font-size: 25px;font-weight: 500;position: inherit;top:0px;">FLASH SALE</div>
                            </div>
                            <div class="col-md-6" style="display: flex;justify-content: space-evenly;align-items: center;">
                                <div class="countdown_time" style="font-size:20px !important; " id="timer"></div>
                            </div>
                        </div>
                            @foreach($products as $product)
                                @if($flashSale->contains($product->id))
                                    <div class="gridview" >
                                        {!! Theme::partial('product-item-grid', compact('product')) !!}
                                    </div>
                                @endif    
                            @endforeach
                    </div>
                    @else
                        <br>
                        <div class="col-12 text-center">{{ __('No products!') }}</div>
                    @endif
                </div>
                
            </div>
        </div>
</div>
<script>
    // Ensure the DOM is ready
    $(document).ready(function () {
        // Get the end date from PHP
        var endDate = "{{ $timer->end_date }}"; // Assuming $timer is available in your view

        // Set up the countdown timer
        $('#timer').countdown(endDate, function (event) {
            $(this).html(
                event.strftime('%D days %H Hours %M Minutes %S Second')
            );
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://www.romfordgifts.co.uk/dev/public/themes/shopwise/plugins/slick/slick.min.js"></script>
<script src="https://www.romfordgifts.co.uk/dev/public/vendor/core/plugins/simple-slider/libraries/owl-carousel/owl.carousel.js?v=1.0.0"></script>
<script src="https://www.romfordgifts.co.uk/dev/public/vendor/core/plugins/simple-slider/js/simple-slider.js?v=1.0.0"></script>
<script src="https://www.romfordgifts.co.uk/dev/public/themes/shopwise/js/popper.min.js"></script>
<script src="https://www.romfordgifts.co.uk/dev/public/themes/shopwise/bootstrap/js/bootstrap.min.js"></script>
<script src="https://www.romfordgifts.co.uk/dev/public/themes/shopwise/js/magnific-popup.min.js"></script>
<script src="https://www.romfordgifts.co.uk/dev/public/themes/shopwise/js/waypoints.min.js?v=4.0.1"></script>
<script src="https://www.romfordgifts.co.uk/dev/public/themes/shopwise/plugins/owlcarousel/js/owl.carousel.min.js"></script>
<script src="https://www.romfordgifts.co.uk/dev/public/themes/shopwise/js/jquery.elevatezoom.js"></script>
<script src="https://www.romfordgifts.co.uk/dev/public/themes/shopwise/js/scripts.js?v=1.12.286"></script>
<script src="https://www.romfordgifts.co.uk/dev/public/themes/shopwise/js/backend.js?v=1.12.286"></script>
<script src="https://www.romfordgifts.co.uk/dev/public/vendor/core/plugins/ecommerce/js/change-product-swatches.js"></script>
<script src="https://www.romfordgifts.co.uk/dev/public/themes/shopwise/js/jquery.countdown.min.js"></script>
<script src="https://www.romfordgifts.co.uk/dev/public/themes/shopwise/js/jquery-ui.js"></script>
<script src="https://www.romfordgifts.co.uk/dev/public/themes/shopwise/js/jquery.ui.touch-punch.min.js"></script>
{!! Theme::partial('footer') !!}