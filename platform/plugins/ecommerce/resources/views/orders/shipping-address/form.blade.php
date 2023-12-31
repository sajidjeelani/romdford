{!! Form::open(['url' => $url]) !!}
    <input type="hidden" name="order_id" value="{{ $orderId }}">
    <div class="next-form-section">
        <div class="next-form-grid">
            <div class="next-form-grid-cell">
                <label class="text-title-field required">{{ trans('plugins/ecommerce::shipping.form_name') }}</label>
                <input type="text" class="next-input" name="name" placeholder="{{ trans('plugins/ecommerce::shipping.form_name') }}" value="{{ $address->name }}">
            </div>
            <div class="next-form-grid-cell">
                <label class="text-title-field required">{{ trans('plugins/ecommerce::shipping.phone') }}</label>
                <input type="text" class="next-input" name="phone" placeholder="{{ trans('plugins/ecommerce::shipping.phone') }}" value="{{ $address->phone }}">
            </div>
        </div>
        <div class="next-form-grid">
            <div class="next-form-grid-cell">
                <label class="text-title-field">{{ trans('plugins/ecommerce::shipping.email') }}</label>
                <input type="text" class="next-input" name="email" placeholder="{{ trans('plugins/ecommerce::shipping.email') }}" value="{{ $address->email }}">
            </div>
        </div>

        @if (count(EcommerceHelper::getAvailableCountries()) > 1)
            <div class="next-form-grid">
                <div class="next-form-grid-cell">
                    <label class="text-title-field required">{{ trans('plugins/ecommerce::shipping.country') }}</label>
                    <select name="country" class="form-control" >
                        @foreach(['' => trans('plugins/ecommerce::shipping.select_country')] + EcommerceHelper::getAvailableCountries() as $countryCode => $countryName)
                            <option value="{{ $countryCode }}" @if ($address->country == $countryCode) selected @endif>{{ $countryName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @else
            <input type="hidden" name="country" value="{{ Arr::first(array_keys(EcommerceHelper::getAvailableCountries())) }}">
        @endif

        <div class="next-form-grid">
            <div class="next-form-grid-cell">
                <label class="text-title-field required">County / {{ trans('plugins/ecommerce::shipping.state') }}</label>
                <input type="text" class="next-input" name="state" placeholder="County / {{ trans('plugins/ecommerce::shipping.state') }}" value="{{ $address->state }}">
            </div>
        </div>

        <div class="next-form-grid">
            <div class="next-form-grid-cell">
                <label class="text-title-field required">{{ __('Town/City') }}</label>
                <input type="text" class="next-input" name="city" placeholder="{{ __('Town/City') }}" value="{{ $address->city }}">
            </div>
        </div>

        <div class="next-form-grid">
            <div class="next-form-grid-cell">
                <label class="text-title-field required">{{ trans('plugins/ecommerce::shipping.address') }}</label>
                <input type="text" class="next-input" name="address" placeholder="{{ trans('plugins/ecommerce::shipping.address') }}" value="{{ $address->address }}">
            </div>
        </div>

        @if (EcommerceHelper::isZipCodeEnabled())
            <div class="next-form-grid">
                <div class="next-form-grid-cell">
                    <label class="text-title-field required">Postal Code/{{ trans('plugins/ecommerce::shipping.zip_code') }}</label>
                    <input type="text" class="next-input" name="zip_code" placeholder="Postal Code / {{ trans('plugins/ecommerce::shipping.zip_code') }}" value="{{ $address->zip_code }}">
                </div>
            </div>
        @endif

    </div>
{!! Form::close() !!}