@extends('core/base::layouts.master')

@section('content')
    <div class="max-width-1200">
        <div class="group">
            <div class="row">
                <div class="@if (count($shipping) > 0) col-md-3 col-sm-12 @else col-sm-12 @endif">
                    <h4>{{ trans('plugins/ecommerce::shipping.shipping_rules') }}</h4>
                    <p>{{trans('plugins/ecommerce::shipping.shipping_rules_description') }}</p>
                    <p><a href="#" class="btn btn-secondary btn-select-country">{{ trans('plugins/ecommerce::shipping.select_country') }}</a></p>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="wrapper-content">
                        <div class="table-wrap">
                            @foreach ($shipping as $shippingItem)
                                <div class="wrap-table-shipping-{{ $shippingItem->id }}">
                                    <div class="pd-all-20 p-none-b">
                                        <label class="p-none-r">{{ trans('plugins/ecommerce::shipping.country') }}: <strong>{{ Arr::get(\Botble\Base\Supports\Helper::countries(), $shippingItem->title, $shippingItem->title) }}</strong></label>
                                        <a href="#" class="btn-change-link float-right pl20 btn-add-shipping-rule-trigger" data-shipping-id="{{ $shippingItem->id }}">{{ trans('plugins/ecommerce::shipping.add_shipping_rule') }}</a>
                                        &nbsp;&nbsp;&nbsp;
                                        <a href="#" class="btn-change-link float-right excerpt btn-confirm-delete-region-item-modal-trigger text-danger" data-id="{{ $shippingItem->id }}" data-name="{{ $shippingItem->title }}">{{ trans('plugins/ecommerce::shipping.delete') }}</a>
                                    </div>
                                    <div class="pd-all-20 p-none-t p-b10 border-bottom">
                                        @foreach($shippingItem->rules as $rule)
                                            @include('plugins/ecommerce::shipping.rule-item', compact('rule', 'shippingItem'))
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            <div class="pd-all-20 p-none-t p-b10 border-bottom">
                                <form action="{{ route('shipping_methods.add_courier') }}" method="POST">
                                    @csrf
                                    <p>Please enter Courier Name</p>
                                    <input type="text" name="courier" minlength="3" required>
                                    <button type="submit" style="border: none;background: #36c6d3;border-radius: 7px;padding: 5px;text-align: center;width: 10%;">Submit</button>  
                                </form>
                                
                            </div>
                            <div class="pd-all-20 p-none-t p-b10 border-bottom">
                                <form action="{{ route('shipping_methods.delete_courier') }}" method="POST">
                                    @csrf
                                    <p>Please enter Courier Name to Delete</p>
                                    <input type="text" name="courier" minlength="3" required>
                                    <button type="submit" style="border: none;background: #36c6d3;border-radius: 7px;padding: 5px;text-align: center;width: 10%;">Submit</button>  
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    {!! Form::modalAction('confirm-delete-price-item-modal', trans('plugins/ecommerce::shipping.delete_shipping_rate'), 'info', trans('plugins/ecommerce::shipping.delete_shipping_rate_confirmation'), 'confirm-delete-price-item-button', trans('plugins/ecommerce::shipping.confirm'), 'modal-xs') !!}
    {!! Form::modalAction('confirm-delete-region-item-modal', trans('plugins/ecommerce::shipping.delete_shipping_area'), 'info', trans('plugins/ecommerce::shipping.delete_shipping_area_confirmation'), 'confirm-delete-region-item-button', trans('plugins/ecommerce::shipping.confirm'), 'modal-xs') !!}
    {!! Form::modalAction('add-shipping-rule-item-modal', trans('plugins/ecommerce::shipping.add_shipping_fee_for_area'), 'info', view('plugins/ecommerce::shipping.rule-item', ['rule' => null])->render(), 'add-shipping-rule-item-button', trans('plugins/ecommerce::shipping.save')) !!}
    <div data-delete-region-item-url="{{ route('shipping_methods.region.destroy') }}"></div>
    <div data-delete-rule-item-url="{{ route('shipping_methods.region.rule.destroy') }}"></div>
    <div data-delete-shipping-method-item-url="{{ route('shipping_methods.delete_method') }}"></div>

    {!! Form::modalAction('select-country-modal', trans('plugins/ecommerce::shipping.add_shipping_region'), 'info', FormBuilder::create(\Botble\Ecommerce\Forms\AddShippingRegionForm::class)->renderForm(), 'add-shipping-region-button', trans('plugins/ecommerce::shipping.save'), 'modal-xs') !!}
@stop