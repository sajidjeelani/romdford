<div class="section pt-0 small_pb">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-9">
        @if (clean($title))
            <div class="heading_tab_header">
                <div class="heading_s2">
                    <h3 class="feat">{!! clean($title) !!}</h3>
                </div>
            </div>
        @endif
        @if ($products->count() > 0)
            <div class="row mt-3">
                @foreach($products as $product)
                    <div class="col-md-4">
                        {!! Theme::partial('product-item', compact('product')) !!}
                    </div>
                @endforeach
            </div>
            <div class="shop__pagination">
                {!! $products->appends(request()->query())->links() !!}
            </div>
        @endif
    </div>
    </div>
</div>