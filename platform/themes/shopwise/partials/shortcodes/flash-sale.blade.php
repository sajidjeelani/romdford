@php                         
    $status = DB::table('ec_flash_sales')->select('status')->get();
    foreach($status as $status){
        $status1=$status;
    }
@endphp
                    
@if ($status1->status == 'published')

<div class="section pt-0 pb-0">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading_tab_header">
                    <div class="heading_s2">
                        <h4>{!! isset($title) ? clean($title) : null !!}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            
            <flash-sale-products-component url="{{ route('public.ajax.get-flash-sales') }}"></flash-sale-products-component>
        </div>
    </div>
</div>
@endif