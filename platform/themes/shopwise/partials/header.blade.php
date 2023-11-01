<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>{{ theme_option('site_title') }}</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ asset('/themes/shopwise/bootstrap/css/bootstrap.min.css') }}">
    <!-- style css -->
    <link rel="stylesheet" href="{{ asset('/themes/shopwise/css/style.css?v=7878787')}}">
    <!-- Responsive-->
    <link rel="stylesheet" href="{{ asset('/themes/shopwise/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('/themes/shopwise/plugins/owlcarousel/css/owl.carousel.min.css') }}">
    <!-- fevicon -->
    <link rel="icon" href="{{ asset('/themes/shopwise/images/fevicon.png') }}" type="image/gif" />
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="{{ asset('/themes/shopwise/css/jquery.mCustomScrollbar.min.css') }}">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"
        media="screen">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/aframe/0.7.1/aframe.min.js"></script>
    @php
        $products=get_products();
        $name=array();
        $i=0;
        foreach ($products as $product){
            $name[$i]=($product->name);
            $i++;
            }
    @endphp
    
    <script >
        function autocomplete(inp, arr) {
            /*the autocomplete function takes two arguments,
            the text field element and an array of possible autocompleted values:*/
            var currentFocus;
            /*execute a function when someone writes in the text field:*/
            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;
                /*close any already open lists of autocompleted values*/
                closeAllLists();
                if (!val) {
                    return false;
                }
                if (val.length>=3){
                currentFocus = -1;
                /*create a DIV element that will contain the items (values):*/
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                /*append the DIV element as a child of the autocomplete container:*/
                this.parentNode.appendChild(a);
                /*for each item in the array...*/
                for (i = 0; i < arr.length; i++) {
                    /*check if the item starts with the same letters as the text field value:*/
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        /*create a DIV element for each matching element:*/
                        b = document.createElement("DIV");
                        /*make the matching letters bold:*/
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        /*insert a input field that will hold the current array item's value:*/
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        /*execute a function when someone clicks on the item value (DIV element):*/
                        b.addEventListener("click", function(e) {
                            /*insert the value for the autocomplete text field:*/
                            inp.value = this.getElementsByTagName("input")[0].value;
                            /*close the list of autocompleted values,
                            (or any other open lists of autocompleted values:*/
                            closeAllLists();
                        });
                        a.appendChild(b);
                    }
                }
            }});
            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        if (x) x[currentFocus].click();
                    }
                }
            });
    
            function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
            }
    
            function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }
    
            function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function(e) {
                closeAllLists(e.target);
            });
        } 
    </script>    
        

    {!! Theme::header() !!}
</head>

<body @if (BaseHelper::siteLanguageDirection() == 'rtl') dir="rtl" @endif>
    @if (theme_option('preloader_enabled', 'no') == 'yes')
        <!-- LOADER -->
        <div class="preloader">
            <div class="lds-ellipsis">
                <span></span> 
                <span></span>
                <span></span>
            </div>
        </div>
        <!-- END LOADER -->
    @endif

    <div id="alert-container"></div>

    @if (is_plugin_active('newsletter') && theme_option('enable_newsletter_popup', 'yes') === 'yes')
        <div data-session-domain="{{ config('session.domain') ?? request()->getHost() }}"></div>
        <!-- Home Popup Section -->
        <div class="modal fade subscribe_popup" id="newsletter-modal"
            data-time="{{ (int) theme_option('newsletter_show_after_seconds', 10) * 1000 }}" data-backdrop="static"
            data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                        </button>
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                @if (theme_option('newsletter_image'))
                                    <div class="background_bg h-100" style="background-size: 100% 100%;"
                                        data-img-src="{{ RvMedia::getImageUrl(theme_option('newsletter_image')) }}">
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <div class="popup_content px-5">
                                    <div class="popup-text">
                                        <div class="heading_s4">
                                            <h2>{{ theme_option('newsletter_message') }}</h2>
                                        </div>
                                        <p>{{ __('Subscribe to the newsletter to receive updates about new products.') }}
                                        </p>
                                    </div>
                                    <form method="post" action="{{ route('public.newsletter.subscribe') }}"
                                        class="newsletter-form">
                                        @csrf
                                        <div class="form-group">
                                            <input name="email" type="email" class="form-control rounded-0"
                                                placeholder="{{ __('Enter Your Email') }}">
                                        </div>

                                        @if (setting('enable_captcha') && is_plugin_active('captcha'))
                                            <div class="form-group">
                                                {!! Captcha::display() !!}
                                            </div>
                                        @endif
                                        <div class="form-group px-3">
                                        <div class="chek-form text-left form-group">
                                            <div class="custome-checkbox">
                                                <input class="form-check-input" type="checkbox" name="dont_show_again"
                                                    id="dont_show_again" value="">
                                                <label class="form-check-label"
                                                    for="dont_show_again"><span>{{ __("Don't show this popup again!") }}</span></label>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-block text-uppercase rounded-0" type="submit"
                                                style="background: #333; color: #fff;">{{ __('Subscribe') }}</button>
                                        </div>

                                        <div class="form-group">
                                            <div class="newsletter-message newsletter-success-message"
                                                style="display: none"></div>
                                            <div class="newsletter-message newsletter-error-message"
                                                style="display: none"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Screen Load Popup Section -->
    @endif

    @php
        if (is_plugin_active('ecommerce')) {
            $categories = get_product_categories(['status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED], ['slugable', 'children', 'children.slugable', 'icon'], [], true);
        } else {
            $categories = [];
        }
    @endphp

    <!-- START HEADER -->
    {{-- please correct here != to == --}}
    <header class="d_none @if (theme_option('enable_sticky_header', 'yes') != 'yes') fixed-top header_with_topbar @endif">
        <div class="header_to">

            <div class="container-fluid"> 
            <div class="container px-0">    
                <div class="col-md-12 col-sm-6">
                  
                            
                       
                       
                    <div id="carouselExampleControls" class="carousel slide py-3" data-ride="carousel">
                          <div class="carousel-inner">
                            <div class="carousel-item active">
                              <p class="header-pera">{{ theme_option('headerdata') }}</p>
                            </div>
                            <div class="carousel-item">
                             <p class="header-pera"> {{ theme_option('headerdata1') }}</p>
                            </div>
                            <div class="carousel-item">
                              <p class="header-pera">{{ theme_option('headerdata2') }} </p>
                            </div>
                          </div>
                         
                        </div>   
                       
                       
                       
                </div>
                </div>
                
                <div class="text-end text-right" style="position: absolute;margin-left: 95%;margin-top: -2.5%;">  
                         <button  type="button" data-target="#carouselExampleControls" data-slide="prev" style="background: unset;">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                          </button>
                          <button  type="button" data-target="#carouselExampleControls" data-slide="next" style="background: unset;">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                          </button>
                        </div> 
            </div>
        </div>
        <div class="container-fluid header_to">
            <div class="row">
                <div class="col-md-12">
                    <hr class="section-hr" />
                </div>
            </div>
        </div>
        <div class="header_to">
            <div class="container ">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <ul class="lan">
                            <li><i class="fa fa-phone" aria-hidden="true"></i></li>
                            <li>&nbsp; {{ theme_option('hotline') }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-sm-6 ">
                        <ul class="social_icon1">
                            <li> <a href="{{ url('/contact-us') }}" class='px-3 ml-3'><i class="fa fa-envelope" aria-hidden="true"></i> Contact us </a>
                            </li>
                            <li><a href="{{ route('public.wishlist') }}" class="nav-link btn-wishlist"><i class="linearicons-heart"></i><span class="wishlist_count">{{ !auth('customer')->check() ? Cart::instance('wishlist')->count() : auth('customer')->user()->wishlist()->count() }}</span></a></li>
                            @if (!auth('customer')->check())
                                <li class="sig-fon"><a href="{{ route('customer.login') }}"><i class="px-3"></i><span><i class="fa fa-user" aria-hidden="true"></i> {{ __('Sign In') }}</span></a></li>
                            @else
                                <li><a href="{{ route('customer.overview') }}" class="px-1 py-3"> | <i class="fa fa-user" aria-hidden="true"></i> {{ auth('customer')->user()->name }} &nbsp;</span></a></li>
                                <li><a href="{{ route('customer.logout') }}" class="px-1  py-3"> | <i class="fa fa-power-off" aria-hidden="true"></i>&nbsp;{{ __('Logout') }}</span></a></li>
                            @endif
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="header_midil">
            <div class="container">
                <div class="row d_flex">
                    <div class="col-md-4 col-sm-4 d_none">
                        <div class=" pt-3">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('themes/shopwise/images/RomfordGiftsPNGHeader.png') }}"
                                    class="img-log">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <form autocomplete="off" action="{{ route('public.products') }}" method="GET">
                            <input class="search-lo autocomplete" id="myInput" name="q" value="{{ request()->input('q') }}" placeholder="{{ __('Search Product') }}..." required type="text">
                            <button type="submit" class="sea"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                    @if (is_plugin_active('ecommerce'))
                        <div class="col-md-4 col-sm-4 d_none">
                            @if (EcommerceHelper::isCartEnabled())
                                <div class="unst-1 pb-1">
                                    <i class="nav-link cart_trigger btn-shopping-cart " data-toggle="dropdown">
                                        <h3 class="text-white cart_title">
                                            <i class="fa fa-shopping-cart carz" aria-hidden="true"></i>
                                            Basket: <span class="bask"> @if (!Cart::instance('cart')->count()) @else {{ Cart::instance('cart')->count() }} </span> @endif <i class="fa fa-caret-down dolt pull-end" aria-hidden="true"></i>
                                        </h3>
                                    </i>
                                    <div class="cart_box dropdown-menu dropdown-menu-right" aria-hidden="true">
                                        {!! Theme::partial('cart') !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div id="navbarSidetoggle">
            {!! Menu::renderMenuLocation('main-menu', ['view' => 'menu', 'options' => ['class' => 'navbar-nav']]) !!}
        </div>

    </header>
<!--    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">-->
<!--  <div class="modal-dialog">-->
<!--    <div class="modal-content">-->
<!--      <div class="modal-header">-->
<!--        <h5 class="modal-title" id="exampleModalLabel">Send To Friend</h5>-->
<!--        <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--          <span aria-hidden="true">&times;</span>-->
<!--        </button>-->
<!--      </div>-->
<!--      <div class="modal-body">-->
<!--        <form>-->
<!--            <p>Enter your friend email address to send this product link.</p>-->
<!--            <input type="email" name="email" id="email" required />-->
            
<!--            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
<!--            <button type="button" class="btn btn-primary">Send</button>-->
            
<!--        </form>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->
<!--    <button type="button" class="btn btn-primary" style="display:none;" id="button12" data-toggle="modal" data-target="#exampleModal"></button>-->
    
<script>
        var passedArray = <?php echo json_encode($name); ?>;
            autocomplete(document.getElementById("myInput"), passedArray);
        </script>


<!-- Products Modal Box -->
<div class="modal fade" id="productModal_flash" tabindex="-1" aria-labelledby="productModal_flashLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="productModal_flashLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="flashModalBody">
          
        
      </div>
    </div>
  </div>
</div>

<!-- END SECTION SHOP -->

    <!-- END HEADER -->