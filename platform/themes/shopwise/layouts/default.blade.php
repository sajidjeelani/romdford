{!! Theme::partial('header') !!}

<div class="container">
    <div class="row">
            {{-- <div class="col-md-6">
                <div class="">
                    <h1 class="prodt">{{ Theme::get('pageName') }}</h1>
                </div>
            </div> --}}
            {{-- <div class="col-md-6">
                {!! Theme::partial('breadcrumbs') !!}
            </div> --}}
        </div>
        {!! Theme::content() !!}
</div>


{!! Theme::partial('footer') !!}
