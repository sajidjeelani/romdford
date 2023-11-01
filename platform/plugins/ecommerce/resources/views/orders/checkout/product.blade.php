<div class="row cart-item">
    <div class="col-3">
        <div class="checkout-product-img-wrapper">
            
                <div>
                    <img id="photo-img" src="{{ RvMedia::getImageUrl($product->image, null, false, RvMedia::getDefaultImage()) }}" data-zoom-enable="true" data-zoom-image="{{ RvMedia::getImageUrl($product->image, null, false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}" />
                    <a href="#" class="product_img_zoom" title="Zoom">
                        <span class="linearicons-zoom-in"></span>
                    </a>
                </div>

            <span class="checkout-quantity">{{ $cartItem->qty }}</span>
        </div>
    </div>
    <div class="col-5">
        <p class="mb-0">{{ $product->name }}</p>
        <p class="mb-0">
            <small>{{ $product->variation_attributes }}</small>
        </p>
        @if ($options = Arr::get($cartItem->options, 'extras', []))
            @if (is_array($options))
                @foreach($options as $option)
                    @if (!empty($option['key']) && !empty($option['value']))
                        <p class="mb-0">
                            <small>{{ $option['key'] }}: <strong> {{ $option['value'] }}</strong></small>
                        </p>
                    @endif
                @endforeach
            @endif
        @endif

    </div>
    <div class="col-2">
        <a href="{{ route('public.cart.remove', $cartItem->rowId) }}" class="item_remove remove-cart-button bg-white"><i class="fa fa-trash-o text-danger" data-toggle="tooltip" data-placement="top" title="Remove item"></i></a>
    </div>
    <div class="col-2 text-right">
        <p>{{ format_price($cartItem->price) }}</p>
    </div>
</div> <!--  /item -->