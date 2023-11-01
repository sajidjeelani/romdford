<li>{{ $address->name }}</li>
@if ($address->phone)
    <li>
        <a href="tel:{{ $address->phone }}">
            <span><i class="fa fa-phone-square cursor-pointer mr5"></i></span>
            <span>{{ $address->phone }}</span>
        </a>
    </li>
@endif
<li>
     
    @if ($address->address)
        
        <div>Address 1: {{ $address->address }}</div>
    @endif
    @if ($address->address)
        <div>Address 2: {{ $address->address1 }}</div>
    @endif
    @if ($address->address)
        <div>Aditional Address: {{ $address->aaddress }}</div>
    @endif
    @if ($address->city)
        <div>Town / City: {{ $address->city }}</div>
    @endif
    @if ($address->state)
        <div>County / State: {{ $address->state }}</div>
    @endif
    @if ($address->country_name)
        <div>Country: {{ $address->country_name }}</div>
    @endif
    @if ($address->company_name)
        <div>Company: {{ $address->company_name }}</div>
    @endif
    @if (EcommerceHelper::isZipCodeEnabled() && $address->zip_code)
        <div>Postal Code / Zip Code   : {{ $address->zip_code }}</div>
    @endif
    <div>
        <a target="_blank" class="hover-underline" href="https://maps.google.com/?q={{ $address->address }}, {{ $address->city }}, {{ $address->state }}, {{ $address->country_name }}@if (EcommerceHelper::isZipCodeEnabled()), {{ $address->zip_code }} @endif">{{ trans('plugins/ecommerce::order.see_on_maps') }}</a>
    </div>
</li>