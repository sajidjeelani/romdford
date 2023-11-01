<div class="container">
    
    <div class="row d-flex " style="margin-left: 10px;">
        <div class="col-md-3 row">
            <label>Sort:</label>
            <select class="form-control form-control-sm submit-form-on-change" name="sort-by" id="sort-by" >
                @foreach (EcommerceHelper::getSortParams() as $key => $name)
                    <option value="{{ $key }}" @if (request()->input('sort-by') == $key) selected @endif>{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="custom_select col-md-3">
            <select class="form-control form-control-sm submit-form-on-change" name="num" style="width: 80%; text-align: -webkit-center;">
                @foreach (EcommerceHelper::getShowParams() as $key => $name)
                    <option value="{{ $key }}" @if (request()->input('num') == $key) selected @endif>{{ $key }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <div class="products_view d-flex justify-content-end" style="font-size: 22px;">
                <a href="javascript:void(0);" class="shorting_icon grid active" style="margin-right: 10px;"><i class="ti-view-grid"></i></a>
                <a href="javascript:void(0);" class="shorting_icon list"><i class="ti-layout-list-thumb"></i></a>
            </div>
        </div>
    </div>
    <hr>
    <div class="row mb-4">
        <div class="col-md-10 d-flex justify-content-center " style="font-size: 15px;">
            
        </div>
        <div class="col-md-2 d-flex justify-content-end">
            <a href="{{ route('public.compare') }}" class="sela">{{__('Compare ')}}<span>({{ Cart::instance('compare')->count() }})</span></a>
        </div>
    </div>

</div>