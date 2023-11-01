<div class="mb-5">
    <div class="container">
        <nav class="navbar navbar-expand-lg frist">
            <a class="navbar-brand navbr text-white menu-nav-1" href="#">
                <img src="{{ asset('themes/shopwise/images/RomfordGiftsPNGHeader.png') }}">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04"
                aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon bgmenu"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav" {!! $options !!}>

                    @foreach ($menu_nodes as $key => $row)
                        <li class="nav-item">
                            <a class="nav-link menucolor {{ $row->css_class }} home-1 @if ($row->has_child) dropdown-toggle @endif"
                                href="{{ $row->has_child ? '#' : url($row->url) }}"
                                @if ($row->target !== '_self') target="{{ $row->target }}" @endif
                                @if ($row->has_child) data-toggle="dropdown" @endif>
                                @if ($row->icon_font) <i
                                        class="sr-only {{ trim($row->icon_font) }}"></i>
                                @endif
                                {{ $row->title }}
                            </a>
                            @if ($row->has_child)
                                <div class=" menu-item nav-nav1 dropdown-menu dropdown-reverse">
                                    {!! Menu::generateMenu([
                                        'menu' => $menu,
                                        'menu_nodes' => $row->child,
                                        'view' => 'sub-menu',
                                    ]) !!}
                                </div>
                            @endif
                        </li>
                    @endforeach

                </ul>
            </div>
        </nav>
    </div>
</div>
