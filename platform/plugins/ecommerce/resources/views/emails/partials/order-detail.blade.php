@if (!$order->dont_show_order_info_in_product_list)
    @php
        $orderId = get_order_code($order->id);
    @endphp
    <a href="{{ route('public.orders.tracking', ['order_id' => str_replace('#', '', $orderId), 'email' => $order->user->email ?: $order->address->email]) }}"
        class="button button-blue">{{ trans('plugins/ecommerce::email.view_order') }}</a>
        {!! trans('plugins/ecommerce::email.link_go_to_our_shop', ['link' => route('public.index')]) !!}

    <br />

    <h3>{{ trans('plugins/ecommerce::email.order_information') }}</h3>

    <p>{!! trans('plugins/ecommerce::email.order_number', ['order_id' => $orderId]) !!}</p>
@endif
<div class="table">
    <table>
        <tr>
            <th style="text-align: left">
                {{ trans('plugins/ecommerce::products.form.product') }}
            </th>
            <th style="text-align: left">
                SKU
            </th>
            <th style="text-align: left">
                {{ trans('plugins/ecommerce::products.form.price') }}
            </th>
            <th style="text-align: left">
                {{ trans('plugins/ecommerce::products.form.quantity') }}
            </th>
            <th style="text-align: left">
                {{ trans('plugins/ecommerce::products.form.total') }}
            </th>
        </tr>

        @foreach ($order->products as $orderProduct)
            @php
                $product = get_products([
                        'condition' => [
                        'ec_products.status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED,
                        'ec_products.id' => $orderProduct->product_id,
                    ],
                        'take' => 1,
                        'select' => [
                        'ec_products.id',
                        'ec_products.name',
                        'ec_products.price',
                        'ec_products.sale_price',
                        'ec_products.sale_type',
                        'ec_products.start_date',
                        'ec_products.end_date',
                        'ec_products.sku',
                    ],
                ])
            @endphp
            <tr>
                <td>
                    {{ $orderProduct->product_name }}
                    @if ($product)
                        <small>{{ $product->variation_attributes }}</small>
                    @endif

                    @if (!empty($orderProduct->options) && is_array($orderProduct->options))
                        @foreach($orderProduct->options as $option)
                            @if (!empty($option['key']) && !empty($option['value']))
                                <p class="mb-0"><small>{{ $option['key'] }}: <strong> {{ $option['value'] }}</strong></small></p>
                            @endif
                        @endforeach
                    @endif
                </td>
                @if ($product)
                    <td>
                        {{ ($product->sku) }}
                    </td>
                @endif

                <td>
                    {{ format_price($orderProduct->price) }}
                </td>

                <td>
                    x {{ $orderProduct->qty }}
                </td>

                <td>
                    {{ format_price($orderProduct->qty * $orderProduct->price) }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>
                {{ trans('plugins/ecommerce::products.form.sub_total') }}:
            </td>
            <td>&nbsp;</td>
            <td>
                {{ format_price($order->sub_total) }}
            </td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>{{ trans('plugins/ecommerce::products.form.shipping_fee') }}:
            </td>
            <td>&nbsp;</td>
            <td>
                {{ format_price($order->shipping_amount) }}
            </td>
        </tr>

        @if (EcommerceHelper::isTaxEnabled())
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>{{ trans('plugins/ecommerce::products.form.tax') }}:
                </td>
                <td>&nbsp;</td>
                <td>
                    {{ format_price($order->tax_amount) }}
                </td>
            </tr>
        @endif

        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>{{ trans('plugins/ecommerce::products.form.discount') }}:
            </td>
            <td>&nbsp;</td>
            <td>
                {{ format_price($order->discount_amount) }}
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>{{ trans('Gift Wrap') }}:
            </td>
            <td>&nbsp;</td>
            <td>
                {{ format_price($order->gift_wrap) }}
            </td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>

            <td>{{ trans('plugins/ecommerce::products.form.total') }}:
            </td>
            <td>&nbsp;</td>
            <td>
                {{ format_price($order->amount) }}
            </td>
        </tr>
    </table><br>
</div>