<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>@yield('title') - {{$generalsetting->name}}</title>
        <!-- App favicon -->

        <link rel="shortcut icon" href="{{asset($generalsetting->favicon)}}" alt="{{$generalsetting->name}}" />
        <meta name="author" content="Elite Design" />
        <link rel="canonical" href="{{ URL::to('/') }}" />
        @stack('seo') 
        @stack('css')
        <link rel="stylesheet" href="{{asset('frontEnd/css/bootstrap.min.css')}}" />
        <link rel="stylesheet" href="{{asset('frontEnd/css/animate.css')}}" />
        <link rel="stylesheet" href="{{asset('frontEnd/css/all.min.css')}}" />
        <link rel="stylesheet" href="{{asset('frontEnd/css/owl.carousel.min.css')}}" />
        <link rel="stylesheet" href="{{asset('frontEnd/css/owl.theme.default.min.css')}}" />
        <link rel="stylesheet" href="{{asset('frontEnd/css/mobile-menu.css')}}" />
        <link rel="stylesheet" href="{{asset('frontEnd/css/select2.min.css')}}" />
        <!-- toastr css -->
        <link rel="stylesheet" href="{{asset('backEnd/')}}/assets/css/toastr.min.css" />

        <link rel="stylesheet" href="{{asset('frontEnd/css/wsit-menu.css')}}" />
        <link rel="stylesheet" href="{{asset('frontEnd/css/style.css')}}" />
        <link rel="stylesheet" href="{{asset('frontEnd/css/responsive.css')}}" />
        <link rel="stylesheet" href="{{asset('frontEnd/css/main.css')}}" />
        
        <style>
            input:focus::-webkit-input-placeholder {
              -webkit-transform: translateY(-125%);
              font-size: 75%;
              opacity: 0.05
            }
            
            input.imitatefocus::-webkit-input-placeholder {
              -webkit-transform: translateY(-125%);
              opacity: 0.55
            }
        </style>

        <meta name="facebook-domain-verification" content="38f1w8335btoklo88dyfl63ba3st2e" />

        @foreach($pixels as $pixel)
        <!-- Facebook Pixel Code -->
        <script>
            !(function (f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function () {
                    n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments);
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = "2.0";
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s);
            })(window, document, "script", "https://connect.facebook.net/en_US/fbevents.js");
            fbq("init", "{{{$pixel->code}}}");
            fbq("track", "PageView");
        </script>
        <noscript>
            <img height="1" width="1" style="display: none;" src="https://www.facebook.com/tr?id={{{$pixel->code}}}&ev=PageView&noscript=1" />
        </noscript>
        <!-- End Facebook Pixel Code -->
        @endforeach
        
        @foreach($gtm_code as $gtm)
        <!-- Google tag (gtag.js) -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{ $gtm->code }}');</script>
        <!-- End Google Tag Manager -->
        @endforeach
    </head>
    <body class="gotop">
        @php $subtotal = Cart::instance('shopping')->subtotal(); @endphp
        <div class="mobile-menu">
                <div class="mobile-menu-logo">
                    <div class="logo-image">
                        <img src="{{asset($generalsetting->white_logo)}}" alt="" />
                    </div>
                    <div class="mobile-menu-close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <ul class="first-nav">
                    @foreach($menucategories as $scategory)
                    <li class="parent-category">
                        <a href="{{url('category/'.$scategory->slug)}}" class="menu-category-name">
                            <img src="{{asset($scategory->image)}}" alt="" class="side_cat_img" />
                            {{$scategory->name}}
                        </a>
                        @if($scategory->subcategories->count() > 0)
                        <span class="menu-category-toggle">
                            <i class="fa fa-chevron-down"></i>
                        </span>
                        @endif
                        <ul class="second-nav" style="display: none;">
                            @foreach($scategory->subcategories as $subcategory)
                            <li class="parent-subcategory">
                                <a href="{{url('subcategory/'.$subcategory->slug)}}" class="menu-subcategory-name">{{$subcategory->subcategoryName}}</a>
                                @if($subcategory->childcategories->count() > 0)
                                <span class="menu-subcategory-toggle"><i class="fa fa-chevron-down"></i></span>
                                @endif
                                <ul class="third-nav" style="display: none;">
                                    @foreach($subcategory->childcategories as $childcat)
                                    <li class="childcategory"><a href="{{url('products/'.$childcat->slug)}}" class="menu-childcategory-name">{{$childcat->childcategoryName}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            @endforeach
                        </ul>
                         
                    </li>
                    @endforeach
                    <li class="parent-category">
                        <a href="{{route('customer.order_track')}}" class="menu-category-name">
                            <i class="fa fa-truck side_cat_img"></i>
                            Order Track
                        </a>
                    </li>
                </ul>
            </div>
        <header id="navbar_top">
            <div class="mobile-header sticky">
                <div class="mobile-logo">
                    <div class="menu-bar">
                        <a class="toggle">
                            <i class="fa-solid fa-bars"></i>
                        </a>
                    </div>
                    <div class="menu-logo">
                        <a href="{{route('home')}}"><img src="{{asset($generalsetting->white_logo)}}" alt="" /></a>
                    </div>
                    <div class="menu-bag">
                        <p class="margin-shopping">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span class="mobilecart-qty">{{Cart::instance('shopping')->count()}}</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="mobile-search">
                <form action="{{route('search')}}">
                    <input type="text" id="mobilesearchbox" placeholder="Search Product ... " value="" class="msearch_keyword msearch_click" name="keyword" />
                    <button><i data-feather="search"></i></button>
                </form>
                <div class="search_result"></div>
            </div>

            

            <div class="main-header">
                <!-- header to end -->
                <div class="logo-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="logo-header d-flex justify-content-between align-items-center">
                                    <div class="main-logo">
                                        <a href="{{route('home')}}"><img src="{{asset($generalsetting->white_logo)}}" alt="" /></a>
                                    </div>
                                    <div class="main-search">
                                        <form action="{{route('search')}}">
                                            <input type="text" id="searchbox"  placeholder="Search Product..."value="" class="search_keyword search_click" name="keyword" />
                                            <button>
                                                <i data-feather="search"></i>
                                            </button>
                                        </form>
                                        <div class="search_result"></div>
                                    </div>
                                    <div class="header-list-items">
                                        <ul>
                                            <li class="track_btn">
                                                <a href="{{route('customer.order_track')}}"> <i class="fa fa-truck"></i>Track Order</a>
                                            </li>
                                            @if(Auth::guard('customer')->user())
                                            <li class="for_order">
                                                <p>
                                                    <a href="{{route('customer.account')}}">
                                                        <i class="fa-regular fa-user"></i>

                                                        {{Str::limit(Auth::guard('customer')->user()->name,14)}}
                                                    </a>
                                                </p>
                                            </li>
                                            @else
                                            <li class="for_order">
                                                <p>
                                                    <a href="{{route('customer.login')}}">
                                                        <i class="fa-regular fa-user"></i>
                                                        account
                                                    </a>
                                                </p>
                                            </li>
                                            @endif

                                            <li class="cart-dialog" id="cart-qty">
                                                <a href="{{route('customer.checkout')}}">
                                                    <p class="margin-shopping">
                                                        <i class="fa-solid fa-cart-shopping"></i>
                                                        <span>{{Cart::instance('shopping')->count()}}</span>
                                                    </p>
                                                </a>
                                                <div class="cshort-summary">
                                                    <ul>
                                                        @foreach(Cart::instance('shopping')->content() as $key=>$value)
                                                        <li>
                                                            <a href=""><img src="{{asset($value->options->image)}}" alt="" /></a>
                                                        </li>
                                                        <li><a href="">{{Str::limit($value->name, 30)}}</a></li>
                                                        <li>Qty: {{$value->qty}}</li>
                                                        <li>
                                                            <p>৳{{$value->price}}</p>
                                                            <button class="remove-cart cart_remove" data-id="{{$value->rowId}}"><i data-feather="x"></i></button>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                    <p><strong>সর্বমোট : ৳{{$subtotal}}</strong></p>
                                                    <a href="{{route('customer.checkout')}}" class="go_cart"> অর্ডার করুন </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="menu-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="catagory_menu">
                                    <ul>
                                        @foreach ($menucategories as $scategory)
                                        <li class="cat_bar ">
                                            <a href="{{ url('category/' . $scategory->slug) }}"> 
                                                <span class="cat_head">{{ $scategory->name }}</span>
                                                @if ($scategory->subcategories->count() > 0)
                                                <i class="fa-solid fa-angle-down cat_down"></i>
                                                @endif
                                            </a>
                                            @if($scategory->subcategories->count() > 0)
                                            <ul class="Cat_menu">
                                                @foreach ($scategory->subcategories as $subcat)
                                                <li class="Cat_list cat_list_hover">
                                                    <a href="{{ url('subcategory/' . $subcat->slug) }}">
                                                        <span>{{ Str::limit($subcat->subcategoryName, 25) }}</span>
                                                        @if($subcat->childcategories->count() > 0)<i class="fa-solid fa-chevron-right cat_down"></i>@endif
                                                    </a>
                                                    @if($subcat->childcategories->count() > 0)
                                                    <ul class="child_menu">
                                                        @foreach($subcat->childcategories as $childcat)
                                                        <li class="child_main">
                                                            <a href="{{ url('products/'.$childcat->slug) }}">{{ $childcat->childcategoryName }}</a>
                                                            
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                    @endif
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- main-header end -->
        </header>
        <div id="content">
            @yield('content')
        </div>
            <!-- content end -->
        <footer>
            <div class="footer-top">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4 mb-3 mb-sm-0 col-4">
                            <div class="footer-about">
                                <a href="{{route('home')}}">
                                    <img src="{{asset($generalsetting->white_logo)}}" alt="" />
                                </a>
                                <p>{{$contact->address}}</p>
                                <a href="tel:{{$contact->hotline}}" class="footer-hotlint">{{$contact->hotline}}</a>
                                <div class="footer-menu">
                                    <ul class="social_link">
                                        @foreach($socialicons as $value)
                                        <li class="social_list m-0">
                                            <a class="mobile-social-link" href="{{$value->link}}"><i class="{{$value->icon}}"></i></a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                        <!-- col end -->
                        <div class="col-sm-3 mb-3 mb-sm-0 col-4">
                            <div class="footer-menu">
                                <ul>
                                    <li class="title"><a>Useful Link</a></li>
                                    <li>
                                        <a href="{{route('contact')}}"> <a href="{{route('contact')}}">Contact Us</a></a>
                                    </li>
                                    @foreach($pages as $page)
                                    <li><a href="{{route('page',['slug'=>$page->slug])}}">{{$page->name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-2 mb-3 mb-sm-0 col-4">
                            <div class="footer-menu">
                                <ul>
                                    <li class="title"><a>Link</a></li>
                                    @foreach($pagesright as $key=>$value)
                                    <li>
                                        <a href="{{route('page',['slug'=>$value->slug])}}">{{$value->name}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- col end -->
                        <div class="col-sm-3 mb-3 mb-sm-0 d sm-none">
                            <div class="footer-menu">
                                <ul class="d-none">
                                    <li class="title stay_conn"><a>Stay Connected</a></li>
                                </ul>
                                <ul class="social_link d-none">
                                    @foreach($socialicons as $value)
                                    <li class="social_list">
                                        <a class="mobile-social-link" href="{{$value->link}}"><i class="{{$value->icon}}"></i></a>
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="d_app">
                                    <h2>Download App</h2>
                                    <a href="{{$generalsetting->play_store}}">
                                        <img src="{{asset('frontEnd/images/app-download.png')}}" alt="" />
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- col end -->
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="copyright">
                                <p>Copyright © {{ date('Y') }} {{$generalsetting->name}}. All rights reserved | <span style="color: white;">Website Designed by: <a href="https://www.elitedesign.com.bd"><span style="color: white;">Elite Design</span></a></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <div class="footer_nav">
            <ul>
                <li>
                    <a class="toggle">
                        <span>
                            <i class="fa-solid fa-bars"></i>
                        </span>
                        <span>Category</span>
                    </a>
                </li>

                <li>
                    <a href="https://wa.me/88{{$contact->hotline}}">
                        <span>
                            <i class="fa-solid fa-message"></i>
                        </span>
                        <span>Message</span>
                    </a>
                </li>

                <li class="mobile_home">
                    <a href="{{route('home')}}">
                        <span><i class="fa-solid fa-home"></i></span> <span>Home</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('customer.checkout')}}">
                        <span>
                            <i class="fa-solid fa-cart-shopping"></i>
                        </span>
                        <span>Cart (<b class="mobilecart-qty">{{Cart::instance('shopping')->count()}}</b>)</span>
                    </a>
                </li>
                @if(Auth::guard('customer')->user())
                <li>
                    <a href="{{route('customer.account')}}">
                        <span>
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <span>Account</span>
                    </a>
                </li>
                @else
                <li>
                    <a href="{{route('customer.login')}}">
                        <span>
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <span>Login</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
        
            <div class="whatapp" style="position: fixed; bottom: 80px; right: 32px;">
                <a href="https://wa.me/88{{$contact->hotline}}">
                    <i class="fa-brands fa-whatsapp" style="font-size:48px;color:green"></i>
                <a />
            </div>
        

        <div class="scrolltop" style="bottom: 20px !important;">
            <div class="scroll">
                <i class="fa fa-angle-up"></i>
            </div>
        </div>

        <!-- /. fixed sidebar -->

        <div id="custom-modal"></div>
        <div id="page-overlay"></div>
        <div id="loading"><div class="custom-loader"></div></div>

        <script src="{{asset('frontEnd/js/jquery-3.6.3.min.js')}}"></script>
        <script src="{{asset('frontEnd/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('frontEnd/js/owl.carousel.min.js')}}"></script>
        <script src="{{asset('frontEnd/js/mobile-menu.js')}}"></script>
        <script src="{{asset('frontEnd/js/wsit-menu.js')}}"></script>
        <script src="{{asset('frontEnd/js/mobile-menu-init.js')}}"></script>
        <script src="{{asset('frontEnd/js/wow.min.js')}}"></script>
        <script>
            new WOW().init();
        </script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <!-- feather icon -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js"></script>
        <script>
            feather.replace();
        </script>
        <script src="{{asset('backEnd/')}}/assets/js/toastr.min.js"></script>
        {!! Toastr::message() !!} @stack('script')
        <script>
            $(".quick_view").on("click", function () {
                var id = $(this).data("id");
                $("#loading").show();
                if (id) {
                    $.ajax({
                        type: "GET",
                        data: { id: id },
                        url: "{{route('quickview')}}",
                        success: function (data) {
                            if (data) {
                                $("#custom-modal").html(data);
                                $("#custom-modal").show();
                                $("#loading").hide();
                                $("#page-overlay").show();
                            }
                        },
                    });
                }
            });
        </script>
        <!-- quick view end -->
        <!-- cart js start -->
        <script>
            $(".addcartbutton").on("click", function () {
                var id = $(this).data("id");
                var qty = 1;
                if (id) {
                    $.ajax({
                        cache: "false",
                        type: "GET",
                        url: "{{url('add-to-cart')}}/" + id + "/" + qty,
                        dataType: "json",
                        success: function (data) {
                            if (data) {
                                toastr.success('Success', 'Product add to cart successfully');
                                return cart_count() + mobile_cart();
                            }
                        },
                    });
                }
            });
            $(".cart_store").on("click", function () {
                var id = $(this).data("id");
                var qty = $(this).parent().find("input").val();
                if (id) {
                    $.ajax({
                        type: "GET",
                        data: { id: id, qty: qty ? qty : 1 },
                        url: "{{route('cart.store')}}",
                        success: function (data) {
                            if (data) {
                                toastr.success('Success', 'Product add to cart succfully');
                                return cart_count() + mobile_cart();
                            }
                        },
                    });
                }
            });

            $(".cart_remove").on("click", function () {
                var id = $(this).data("id");
                if (id) {
                    $.ajax({
                        type: "GET",
                        data: { id: id },
                        url: "{{route('cart.remove')}}",
                        success: function (data) {
                            if (data) {
                                $(".cartlist").html(data);
                                return cart_count() + mobile_cart() + cart_summary();
                            }
                        },
                    });
                }
            });

            $(".cart_increment").on("click", function () {
                var id = $(this).data("id");
                if (id) {
                    $.ajax({
                        type: "GET",
                        data: { id: id },
                        url: "{{route('cart.increment')}}",
                        success: function (data) {
                            if (data) {
                                $(".cartlist").html(data);
                                return cart_count() + mobile_cart();
                            }
                        },
                    });
                }
            });

            $(".cart_decrement").on("click", function () {
                var id = $(this).data("id");
                if (id) {
                    $.ajax({
                        type: "GET",
                        data: { id: id },
                        url: "{{route('cart.decrement')}}",
                        success: function (data) {
                            if (data) {
                                $(".cartlist").html(data);
                                return cart_count() + mobile_cart();
                            }
                        },
                    });
                }
            });

            function cart_count() {
                $.ajax({
                    type: "GET",
                    url: "{{route('cart.count')}}",
                    success: function (data) {
                        if (data) {
                            $("#cart-qty").html(data);
                        } else {
                            $("#cart-qty").empty();
                        }
                    },
                });
            }
            function mobile_cart() {
                $.ajax({
                    type: "GET",
                    url: "{{route('mobile.cart.count')}}",
                    success: function (data) {
                        if (data) {
                            $(".mobilecart-qty").html(data);
                        } else {
                            $(".mobilecart-qty").empty();
                        }
                    },
                });
            }
            function cart_summary() {
                $.ajax({
                    type: "GET",
                    url: "{{route('shipping.charge')}}",
                    dataType: "html",
                    success: function (response) {
                        $(".cart-summary").html(response);
                    },
                });
            }
        </script>
        <!-- cart js end -->
        <script>
            $(".search_click").on("keyup change", function () {
                var keyword = $(".search_keyword").val();
                $.ajax({
                    type: "GET",
                    data: { keyword: keyword },
                    url: "{{route('livesearch')}}",
                    success: function (products) {
                        if (products) {
                            $(".search_result").html(products);
                        } else {
                            $(".search_result").empty();
                        }
                    },
                });
            });
            $(".msearch_click").on("keyup change", function () {
                var keyword = $(".msearch_keyword").val();
                $.ajax({
                    type: "GET",
                    data: { keyword: keyword },
                    url: "{{route('livesearch')}}",
                    success: function (products) {
                        if (products) {
                            $("#loading").hide();
                            $(".search_result").html(products);
                        } else {
                            $(".search_result").empty();
                        }
                    },
                });
            });
        </script>
        <!-- search js start -->
        <script></script>
        <script></script>
        <script>
            $(".district").on("change", function () {
                var id = $(this).val();
                $.ajax({
                    type: "GET",
                    data: { id: id },
                    url: "{{route('districts')}}",
                    success: function (res) {
                        if (res) {
                            $(".area").empty();
                            $(".area").append('<option value="">Select..</option>');
                            $.each(res, function (key, value) {
                                $(".area").append('<option value="' + key + '" >' + value + "</option>");
                            });
                        } else {
                            $(".area").empty();
                        }
                    },
                });
            });
        </script>
        <script>
            $(".toggle").on("click", function () {
                $("#page-overlay").show();
                $(".mobile-menu").addClass("active");
            });

            $("#page-overlay").on("click", function () {
                $("#page-overlay").hide();
                $(".mobile-menu").removeClass("active");
                $(".feature-products").removeClass("active");
            });

            $(".mobile-menu-close").on("click", function () {
                $("#page-overlay").hide();
                $(".mobile-menu").removeClass("active");
            });

            $(".mobile-filter-toggle").on("click", function () {
                $("#page-overlay").show();
                $(".feature-products").addClass("active");
            });
        </script>
        <script>
            $(document).ready(function () {
                $(".parent-category").each(function () {
                    const menuCatToggle = $(this).find(".menu-category-toggle");
                    const secondNav = $(this).find(".second-nav");

                    menuCatToggle.on("click", function () {
                        menuCatToggle.toggleClass("active");
                        secondNav.slideToggle("fast");
                        $(this).closest(".parent-category").toggleClass("active");
                    });
                });
                $(".parent-subcategory").each(function () {
                    const menuSubcatToggle = $(this).find(".menu-subcategory-toggle");
                    const thirdNav = $(this).find(".third-nav");

                    menuSubcatToggle.on("click", function () {
                        menuSubcatToggle.toggleClass("active");
                        thirdNav.slideToggle("fast");
                        $(this).closest(".parent-subcategory").toggleClass("active");
                    });
                });
            });
        </script>

        <script>
            var menu = new MmenuLight(document.querySelector("#menu"), "all");

            var navigator = menu.navigation({
                selectedClass: "Selected",
                slidingSubmenus: true,
                // theme: 'dark',
                title: "ক্যাটাগরি",
            });

            var drawer = menu.offcanvas({
                // position: 'left'
            });

            //  Open the menu.
            document.querySelector('a[href="#menu"]').addEventListener("click", (evnt) => {
                evnt.preventDefault();
                drawer.open();
            });
        </script>

        <script>
            // document.addEventListener("DOMContentLoaded", function () {
            //     window.addEventListener("scroll", function () {
            //         if (window.scrollY > 200) {
            //             document.getElementById("navbar_top").classList.add("fixed-top");
            //         } else {
            //             document.getElementById("navbar_top").classList.remove("fixed-top");
            //             document.body.style.paddingTop = "0";
            //         }
            //     });
            // });
            /*=== Main Menu Fixed === */
            // document.addEventListener("DOMContentLoaded", function () {
            //     window.addEventListener("scroll", function () {
            //         if (window.scrollY > 0) {
            //             document.getElementById("m_navbar_top").classList.add("fixed-top");
            //             // add padding top to show content behind navbar
            //             navbar_height = document.querySelector(".navbar").offsetHeight;
            //             document.body.style.paddingTop = navbar_height + "px";
            //         } else {
            //             document.getElementById("m_navbar_top").classList.remove("fixed-top");
            //             // remove padding top from body
            //             document.body.style.paddingTop = "0";
            //         }
            //     });
            // });
            /*=== Main Menu Fixed === */

            $(window).scroll(function () {
                if ($(this).scrollTop() > 50) {
                    $(".scrolltop:hidden").stop(true, true).fadeIn();
                } else {
                    $(".scrolltop").stop(true, true).fadeOut();
                }
            });
            $(function () {
                $(".scroll").click(function () {
                    $("html,body").animate({ scrollTop: $(".gotop").offset().top }, "1000");
                    return false;
                });
            });
        </script>
        <script>
            $(".filter_btn").click(function(){
               $(".filter_sidebar").addClass('active');
               $("body").css("overflow-y", "hidden");
            })
            $(".filter_close").click(function(){
               $(".filter_sidebar").removeClass('active');
               $("body").css("overflow-y", "auto");
            })
        </script>
        
        <!--search ANIMAtion-->
        <script>
            const texts1 = ['Search for something…','Search for other…','One more search'];
            const input1 = document.querySelector('#mobileSearch');
            const animationWorker1 = function (input1, texts1) {
              this.input1 = input1;
              this.defaultPlaceholder = this.input1.getAttribute('placeholder');
              this.texts1 = texts1;
              this.curTextNum = 0;
              this.curPlaceholder = '';
              this.blinkCounter = 0;
              this.animationFrameId = 0;
              this.animationActive = false;
              this.input1.setAttribute('placeholder',this.curPlaceholder);
            
              this.switch = (timeout) => {
                this.input1.classList.add('imitatefocus');
                setTimeout(
                  () => { 
                    this.input1.classList.remove('imitatefocus');
                    if (this.curTextNum == 0) 
                      this.input1.setAttribute('placeholder',this.defaultPlaceholder);
                    else
                      this.input1.setAttribute('placeholder',this.curPlaceholder);
            
                    setTimeout(
                      () => { 
                        this.input1.setAttribute('placeholder',this.curPlaceholder);
                        if(this.animationActive) 
                          this.animationFrameId = window.requestAnimationFrame(this.animate)}, 
                      timeout);
                  }, 
                  timeout);
              }
            
              this.animate = () => {
                if(!this.animationActive) return;
                let curPlaceholderFullText = this.texts1[this.curTextNum];
                let timeout = 900;
                if (this.curPlaceholder == curPlaceholderFullText+'|' && this.blinkCounter==3) {
                  this.blinkCounter = 0;
                  this.curTextNum = (this.curTextNum >= this.texts1.length-1)? 0 : this.curTextNum+1;
                  this.curPlaceholder = '|';
                  this.switch(1000);
                  return;
                }
                else if (this.curPlaceholder == curPlaceholderFullText+'|' && this.blinkCounter<3) {
                  this.curPlaceholder = curPlaceholderFullText;
                  this.blinkCounter++;
                }
                else if (this.curPlaceholder == curPlaceholderFullText && this.blinkCounter<3) {
                  this.curPlaceholder = this.curPlaceholder+'|';
                }
                else {
                  this.curPlaceholder = curPlaceholderFullText
                    .split('')
                    .slice(0,this.curPlaceholder.length+1)
                    .join('') + '|';
                  timeout = 50;
                }
                this.input1.setAttribute('placeholder',this.curPlaceholder);
                setTimeout(
                  () => { if(this.animationActive) this.animationFrameId = window.requestAnimationFrame(this.animate)}, 
                  timeout);
              }
            
              this.stop = () => {
                this.animationActive = false;
                window.cancelAnimationFrame(this.animationFrameId);
              }
            
              this.start = () => {
                this.animationActive = true;
                this.animationFrameId = window.requestAnimationFrame(this.animate);
                return this;
              }
            }
            
            document.addEventListener("DOMContentLoaded", () => {
              let aw = new animationWorker1(input1, texts1).start();
              input1.addEventListener("focus", (e) => aw.stop());
              input1.addEventListener("blur", (e) => {
                aw = new animationWorker1(input1, texts1);
                if(e.target.value == '') setTimeout( aw.start, 500);
              });
            });
            
            const texts = ['Search for something…','Search for other…','One more search'];
            const input = document.querySelector('#searchbox');
            const animationWorker = function (input, texts) {
              this.input = input;
              this.defaultPlaceholder = this.input.getAttribute('placeholder');
              this.texts = texts;
              this.curTextNum = 0;
              this.curPlaceholder = '';
              this.blinkCounter = 0;
              this.animationFrameId = 0;
              this.animationActive = false;
              this.input.setAttribute('placeholder',this.curPlaceholder);
            
              this.switch = (timeout) => {
                this.input.classList.add('imitatefocus');
                setTimeout(
                  () => { 
                    this.input.classList.remove('imitatefocus');
                    if (this.curTextNum == 0) 
                      this.input.setAttribute('placeholder',this.defaultPlaceholder);
                    else
                      this.input.setAttribute('placeholder',this.curPlaceholder);
            
                    setTimeout(
                      () => { 
                        this.input.setAttribute('placeholder',this.curPlaceholder);
                        if(this.animationActive) 
                          this.animationFrameId = window.requestAnimationFrame(this.animate)}, 
                      timeout);
                  }, 
                  timeout);
              }
            
              this.animate = () => {
                if(!this.animationActive) return;
                let curPlaceholderFullText = this.texts[this.curTextNum];
                let timeout = 900;
                if (this.curPlaceholder == curPlaceholderFullText+'|' && this.blinkCounter==3) {
                  this.blinkCounter = 0;
                  this.curTextNum = (this.curTextNum >= this.texts.length-1)? 0 : this.curTextNum+1;
                  this.curPlaceholder = '|';
                  this.switch(1000);
                  return;
                }
                else if (this.curPlaceholder == curPlaceholderFullText+'|' && this.blinkCounter<3) {
                  this.curPlaceholder = curPlaceholderFullText;
                  this.blinkCounter++;
                }
                else if (this.curPlaceholder == curPlaceholderFullText && this.blinkCounter<3) {
                  this.curPlaceholder = this.curPlaceholder+'|';
                }
                else {
                  this.curPlaceholder = curPlaceholderFullText
                    .split('')
                    .slice(0,this.curPlaceholder.length+1)
                    .join('') + '|';
                  timeout = 50;
                }
                this.input.setAttribute('placeholder',this.curPlaceholder);
                setTimeout(
                  () => { if(this.animationActive) this.animationFrameId = window.requestAnimationFrame(this.animate)}, 
                  timeout);
              }
            
              this.stop = () => {
                this.animationActive = false;
                window.cancelAnimationFrame(this.animationFrameId);
              }
            
              this.start = () => {
                this.animationActive = true;
                this.animationFrameId = window.requestAnimationFrame(this.animate);
                return this;
              }
            }
            
            document.addEventListener("DOMContentLoaded", () => {
              let aw = new animationWorker(input, texts).start();
              input.addEventListener("focus", (e) => aw.stop());
              input.addEventListener("blur", (e) => {
                aw = new animationWorker(input, texts);
                if(e.target.value == '') setTimeout( aw.start, 500);
              });
            });
            
            
            
            
            </script>
        <!--search ANIMAtion end-->
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtm->code }}"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    </body>
</html>
