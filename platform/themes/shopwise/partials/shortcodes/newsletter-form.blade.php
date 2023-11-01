
<section class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ theme_option('mostfavouritelink')}}">
                        <div class="background_bg w-100 h-100" style="background-size: 100% 100%;" data-img-src="{{ RvMedia::getImageUrl(theme_option('mostfavourite')) }}"></div>
                    </a>
                </div>
                <div class="col-md-6" style="margin-bottom: 20%;">
                    <div class="row " style="height: 216px;">
                        <div class="col-md-6">
                            <a  href="{{ theme_option('bestgiftredirectlink') }}">
                                <div class="background_bg w-100 h-100" style="background-size: 100% 100%; padding: 45px 0px 40px 30px;" data-img-src="{{ RvMedia::getImageUrl(theme_option('bestgiftimage')) }}">
                                    
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 ">
                            <a href="{{ theme_option('disneyredirectlink') }}">
                                <div class="background_bg w-100 h-100 diney" style="background-size: 100% 100%;" data-img-src="{{ RvMedia::getImageUrl(theme_option('disneyimage')) }}"></div>
                            </a>
                        </div>
                    </div>
                    <div class="h-100">
                        <a href="{{ theme_option('jokerlink') }}">
                                <div class="background_bg w-100 h-100 joker-img" style="background-size: 100% 100%;" data-img-src="{{ RvMedia::getImageUrl(theme_option('jokerimg')) }}"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- START SECTION SUBSCRIBE NEWSLETTER -->
<div class="section back1 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <div >
                    <h3 class="text-white fo-get">{!! clean($title) !!}</h3>
                    @if ($description)
                        <p>{!! clean($description) !!}</p>
                    @endif
                   
                </div>
            </div>
            <div class="col-md-4">
                <form method="post" action="{{ route('public.newsletter.subscribe') }}">
                <div class="row">
                        @csrf
                        <div class="col-md-8">
                                <input name="email" type="email" class="form-control field-1"placeholder="{{ __('Type your email...') }}">
        
                                @if (setting('enable_captcha') && is_plugin_active('captcha'))
                                    {!! Captcha::display() !!}
                                @endif
                        </div>
                        <div class="col-md-4">
                                <div class="form-group">
                                    <button class="btn btn-block rounded-0" type="submit" style="margin-left: -80%;margin-top: 21%;">                        
                                        <span class="icon2">
                                            <i class="fa fa-location-arrow locton-1"></i>
                                        </span>
                                    </button>
                                </div>
                        </div>    
                </div>
                </form>
                    <div class="newsletter-message newsletter-success-message" style="display: none"></div>
                    <div class="newsletter-message newsletter-error-message" style="display: none"></div>
            </div>
            <div class="col-md-6">
                @if ($subtitle)
                    <h2 class="getim">{{theme_option('newsletter_message')}}</h2>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- START SECTION SUBSCRIBE NEWSLETTER -->