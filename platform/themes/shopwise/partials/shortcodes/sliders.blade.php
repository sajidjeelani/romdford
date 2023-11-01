@if (count($sliders) > 0)
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!--New SLider-->
                <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                      
                      @foreach ($sliders as $slider)
                        <li data-target="#carouselExampleCaptions" data-slide-to="{{ $loop->index }}" class="@if ($loop->first) active @endif"></li>
                      @endforeach
                  </ol>
                              <div class="carousel-inner">
                 @foreach ($sliders as $slider)
                    <div class="carousel-item @if ($loop->first) active @endif">
                  <img src="{{ RvMedia::getImageUrl($slider->image, null, false, RvMedia::getDefaultImage()) }}" class="d-block w-100" alt="...">
                  <div class="carousel-caption d-none d-md-block">
                        @if ($slider->title)
                            <h2 class='text-black font-weight-bold' style="font-size:30px; text-shadow: 2px 0 0 #fff, -2px 0 0 #fff, 0 2px 0 #fff, 0 -2px 0 #fff, 1px 1px #fff, -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff;">{{ $slider->title }}</h2>
                        @endif
                        
                        @if ($slider->description)
            <p class='text-black font-weight-bold' style="font-size:18px; text-shadow:2px 0 0 #fff, -2px 0 0 #fff, 0 2px 0 #fff, 0 -2px 0 #fff, 1px 1px #fff, -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff;">{{ $slider->description }}</p>
                        @endif
                        
                        @if ($slider->link)
                            @php
                                $buttonText = MetaBox::getMetaData($slider, 'button_text', true);
                            @endphp
                            <a class="btn w-40 text-white rounded-pill border border-light" style="background-color: #111196;margin-left:15%" href="{{ $slider->link }}"data-animation="slideInLeft" data-animation-delay="1.5s">{!! clean($buttonText ?: __('Shop Now')) !!}</a>
                        @endif
                  </div>
                </div>
                 @endforeach
                  </div>
                  <button class="carousel-control-prev" type="button" data-target="#carouselExampleCaptions" style="display: none;" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-target="#carouselExampleCaptions" style="display: none;" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </button>
                </div>
                
                <!--ENDE SLID-->
            </div>
            <div class="col-md-4">
                
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{theme_option('slidersidetopcontentlink')}}">
                                    <div class="background_bg  imjok-1" style="background-size: 100% 100%;" 
                                                        data-img-src="{{ RvMedia::getImageUrl(theme_option('slidersidetopcontent')) }}">
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-12">
                            <a class="" href="{{theme_option('slidersidetoplink')}}">
                                    <div class="background_bg  imjok-1" style="background-size: 100% 100%;" 
                                                        data-img-src="{{ RvMedia::getImageUrl(theme_option('slidersidetop')) }}">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
@endif