
<!-- START SECTION CATEGORIES -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-9">
            <h5 class="feat">{!! clean($title) !!}</h5>
            <div class="row align-items-center">
                <featured-product-categories-component url="{{ route('public.ajax.featured-product-categories') }}"></featured-product-categories-component>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION CATEGORIES -->