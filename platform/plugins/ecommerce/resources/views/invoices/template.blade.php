<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ trans('plugins/ecommerce::order.invoice_for_order') }} {{ get_order_code($order->id) }}</title>
    <link rel="stylesheet" href="{{ asset('vendor/core/plugins/ecommerce/css/invoice.css') }}?v=1.1.1">
</head>
<body @if (BaseHelper::siteLanguageDirection() == 'rtl') dir="rtl" @endif>

<span class="stamp @if ($order->payment->status == \Botble\Payment\Enums\PaymentStatusEnum::COMPLETED) is-completed @else is-failed @endif">{{ $order->payment->status->label() }}</span>

@php
    $logo = theme_option('logo_in_invoices') ?: theme_option('logo');
@endphp
<style>
    .column {
  float: left;
  width: 50%;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
</style>
<div class="logo-container">
    <div class="row">
        <div class="column">
            @if ($logo)
                <img src="{{ RvMedia::getImageUrl($logo) }}"
                     style="width:100%; max-width:150px;" alt="{{ theme_option('site_title') }}">
            @endif
        </div>
        <div class="column">
            <p>{{theme_option('company_info')}}</p>
        </div>
    </div>
</div>
@php
$orderAddress = DB::table('ec_order_addresses')
            ->select('*')
            ->where('order_id', '=', $order->id)
            ->first(); // Use `first()` to get the first matching record
        
        // Check if a record was found
        if ($orderAddress) {
            // Print the values of the first record
            $address1 = $orderAddress->address1;
            $aaddress = $orderAddress->aaddress;
            $companyName = $orderAddress->company_name;
            
            
        } else {
            $address1 = "No Address";
            $aaddress = $order->id;
            $companyName="";
        }
@endphp
<table class="invoice-info-container">
    <tr>
        <td>
            {{ trans('plugins/ecommerce::order.customer_label') }}
        </td>
        <td>
            {{ $order->address->name }}
        </td>
    </tr>
    <tr>
        <td>
            Address
        </td>
        <td>
            {{ $order->full_address }}
        </td>
    </tr>
    <tr>
        <td>
            Address 1
        </td>
        <td>
            {{ $address1 }}
        </td>
    </tr>
    <tr>
        <td>
            Additional Address
        </td>
        <td>
            {{ $aaddress }}
        </td>
    </tr> 
    <tr>
        <td>
            Company Name
        </td>
        <td>
            {{ $companyName }}
        </td>
    </tr>
    <tr>
        <td>
            {{ trans('plugins/ecommerce::order.created') }}: <strong>{{ now()->format('F d, Y') }}</strong>
        </td>
        <td>

            {{ $order->address->email }}
        </td>
    </tr>
    <tr>
        <td>
            {{ trans('plugins/ecommerce::order.invoice') }}: <strong>{{ get_order_code($order->id) }}</strong>
        </td>
        <td>
            {{ $order->address->phone ?? 'N/A' }}
        </td>
    </tr>
</table>


<table class="line-items-container">
    <thead>
    <tr>
        <th class="heading-description">{{ trans('plugins/ecommerce::products.form.product') }}</th>
        <th class="heading-description">SKU</th>
        <th class="heading-description">{{ trans('plugins/ecommerce::products.form.options') }}</th>
        <th class="heading-quantity">{{ trans('plugins/ecommerce::products.form.quantity') }}</th>
        <th class="heading-price">{{ trans('plugins/ecommerce::products.form.price') }}</th>
        <th class="heading-subtotal">{{ trans('plugins/ecommerce::products.form.total') }}</th>
    </tr>
    </thead>
    <tbody>

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
                        'ec_products.images',
                        'ec_products.name',
                        'ec_products.price',
                        'ec_products.sale_price',
                        'ec_products.sale_type',
                        'ec_products.start_date',
                        'ec_products.end_date',
                        'ec_products.sku',
                    ],
                ]);
            @endphp
            @if (!empty($product))
                <tr>
                    <td>
                        {{ $product->name }}
                    </td>
                    <td>
                        {{ $product->sku }}
                    </td>
                    <td>
                        <small>{{ $product->variation_attributes }}</small>

                        @if (!empty($orderProduct->options) && is_array($orderProduct->options))
                            @foreach($orderProduct->options as $option)
                                @if (!empty($option['key']) && !empty($option['value']))
                                    <p class="mb-0">
                                        <small>{{ $option['key'] }}:
                                            <strong> {{ $option['value'] }}</strong></small>
                                    </p>
                                @endif
                            @endforeach
                        @endif
                    </td>
                    
                    <td>
                        {{ $orderProduct->qty }}
                    </td>
                    <td class="right">
                        @if ($product->front_sale_price != $product->price)
                            {!! htmlentities(format_price($product->front_sale_price)) !!}
                            <del>{!! htmlentities(format_price($product->price)) !!}</del>
                        @else
                            {!! htmlentities(format_price($product->price)) !!}
                        @endif
                    </td>
                    <td class="bold">
                        @if ($product->front_sale_price != $product->price)
                            {!! htmlentities(format_price($product->front_sale_price * $orderProduct->qty)) !!}
                        @else
                            {!! htmlentities(format_price($product->price * $orderProduct->qty)) !!}
                        @endif
                    </td>
                </tr>
            @endif
        @endforeach

        <tr>
            <td colspan="5" class="right">
                {{ trans('plugins/ecommerce::products.form.sub_total') }}
            </td>
            <td class="bold">
                {!! htmlentities(format_price($order->sub_total)) !!}
            </td>
        </tr>
        @if (EcommerceHelper::isTaxEnabled())
            <tr>
                <td colspan="5" class="right">
                    {{ trans('plugins/ecommerce::products.form.tax') }}
                </td>
                <td class="bold">
                    {!! htmlentities(format_price($order->tax_amount)) !!}
                </td>
            </tr>
        @endif
        <tr>
            <td colspan="5" class="right">
                {{ trans('plugins/ecommerce::products.form.shipping_fee') }}
            </td>
            <td class="bold">
                {!! htmlentities(format_price($order->shipping_amount)) !!}
            </td>
        </tr>
        <tr>
            <td colspan="5" class="right">
                {{ trans('Gift Wrap') }}
            </td>
            <td class="bold">
                {!! htmlentities(format_price($order->gift_wrap)) !!}
            </td>
        </tr>
        <tr>
            
            <td colspan="5" class="right">
                {{ trans('plugins/ecommerce::products.form.discount') }}
            </td>
            <td class="bold">
                {!! htmlentities(format_price($order->discount_amount)) !!}
            </td>
        </tr>
    </tbody>
</table>


<table class="line-items-container">
    <thead>
    <tr>
        <th>{{ trans('plugins/ecommerce::order.payment_info') }}</th>
        <th>{{ trans('plugins/ecommerce::order.total_amount') }}</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="payment-info">
            <div>
                {{ trans('plugins/ecommerce::order.payment_method') }}: <strong>{{ $order->payment->payment_channel->label() }}</strong>
            </div>
            <div>
                {{ trans('plugins/ecommerce::order.payment_status_label') }}: <strong>{{ $order->payment->status->label() }}</strong>
            </div>
        </td>
        <td class="large total">{!! htmlentities(format_price($order->amount)) !!}</td>
    </tr>
    </tbody>
</table>
</body>
</html>