@php 
    $brands = get_all_brands(['status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED], ['slugable'], ['products']);
    $categories = get_product_categories(['status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED], ['slugable'], ['products'], true);
    $tags = app(\Botble\Ecommerce\Repositories\Interfaces\ProductTagInterface::class)->advancedGet([ 
        'condition' => ['status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED],
        'with'      => ['slugable'],
        'withCount' => ['products'],
        'order_by'  => ['products_count' => 'desc'],
        'take'      => 10,
    ]);

    Theme::asset()->usePath()->add('jquery-ui-css', 'css/jquery-ui.css');
    Theme::asset()->container('footer')->usePath()->add('jquery-ui-js', 'js/jquery-ui.js', ['jquery']);
    Theme::asset()->container('footer')->usePath()->add('touch-punch', 'js/jquery.ui.touch-punch.min.js', ['jquery-ui-js']);
    $columns = array_column($categories, 'name');
    array_multisort($columns,SORT_ASC,$categories);
    
@endphp
<div class="widget">
    
    <h5 class="sidebar_title">{{ __('Product Categories') }}</h5> 
    <ul class="list-unstyled components mb-5" id="main-category">
        @foreach($categories as $category)
            <li @if (URL::current() == $category->url || (!empty(request()->input('categories', [])) && in_array($category->id, request()->input('categories', [])))) class="active" @endif>
                <a href="{{$category->url}}">
                    <span class="main-category">{{ $category->name }}</span> 
                </a>
                @if ($category->children->count() > 0)
                    <a href="#child-{{$category->id}}" role="button" data-toggle="collapse" aria-controls="#child-{{$category->id}}" data-target="#child-{{$category->id}}">
                        <i class="fa fa-plus" style="font-size:20px;color: black;float: right;margin-top: -11%;"></i>
                    </a>
                @endif
            </li>
            @if ($category->children->count() > 0)
                    <div id="child-{{$category->id}}" class="collapse" data-parent="#main-category">
                        <ul>
                            <li>
                                <ul>
                                    @foreach($category->children as $childCategory)
                                        @if ($childCategory->status=='published') 
                                        <li id='child-category' @if (URL::current() == $childCategory->url || (!empty(request()->input('categories', [])) && in_array($childCategory->id, request()->input('categories', [])))) class="active" @endif><a class="" href="{{ $childCategory->url }}"><span class="child-category">{{ $childCategory->name }}</span></a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>
                    
                @endif
        @endforeach
    </ul>
</div>