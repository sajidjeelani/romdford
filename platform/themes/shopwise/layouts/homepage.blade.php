@if (theme_option('Under_Maintenance')=='no')

{!! Theme::partial('header') !!}

{!! Theme::content() !!}

{!! Theme::partial('footer') !!}
@else
    
    {!! Theme::partial('website-under-maintenance') !!}

@endif