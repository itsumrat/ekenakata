@extends('frontEnd.layouts.master') @section('title', 'Home') @push('seo')
<meta name="app-url" content="{{ URL::to('/') }}" />
<meta name="robots" content="index, follow" />
<meta name="description" content="{{$generalsetting->meta_description}}" />
<meta name="keywords" content="{{$generalsetting->meta_keyword}}" />

<!-- Open Graph data -->
<meta property="og:title" content="{{$generalsetting->name}}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ URL::to('/') }}" />
<meta property="og:image" content="{{ asset($generalsetting->og_baner) }}" />
<meta property="og:description" content="{{$generalsetting->meta_description}}" />
@endpush @push('css')
<link rel="stylesheet" href="{{ asset('frontEnd/css/owl.carousel.min.css') }}" />
<link rel="stylesheet" href="{{ asset('frontEnd/css/owl.theme.default.min.css') }}" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css" rel="stylesheet" />
@endpush @section('content')
<section class="slider-section">
    <div class="container">
        <div class="row">
            {{-- 
            <div class="col-sm-3 hidetosm">
                <div class="sidebar-menu">
                    <ul class="hideshow">
                        @foreach ($menucategories as $key => $category)
                            <li>
                                <a href="{{ route('category', $category->slug) }}">
                                    <img src="{{ asset($category->image) }}" alt="" />
                                    {{ $category->name }}
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <ul class="sidebar-submenu">
                                    @foreach ($category->subcategories as $key => $subcategory)
                                        <li>
                                            <a href="{{ route('subcategory', $subcategory->slug) }}">
                                                {{ $subcategory->subcategoryName }} <i
                                                    class="fa-solid fa-chevron-right"></i> </a>
                                            <ul class="sidebar-childmenu">
                                                @foreach ($subcategory->childcategories as $key => $childcat)
                                                    <li>
                                                        <a href="{{ route('products', $childcat->slug) }}">
                                                            {{ $childcat->childcategoryName }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            --}}
            <div class="col-sm-12">
                <div class="home-slider-container">
                    <div class="main_slider owl-carousel">
                        @foreach ($sliders as $key => $value)
                            <div class="slider-item">
                                <img src="{{ asset($value->image) }}" alt="" />
                            </div>
                            <!-- slider item -->
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- slider end -->

<section class="homeproduct">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="sec_title">
                    <h3 class="section-title-header">
                        <div class="timer_inner">
                            <div class="">
                                <span class="section-title-name"> Top Categories </span>
                            </div>
                        </div>
                    </h3>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="topcategory product_slider owl-carousel">
                    @foreach ($menucategories as $key => $value)
                        <div class="cat_item">
                            <div class="cat_img">
                                <a href="{{ route('category', $value->slug) }}">
                                    <img src="{{ asset($value->image) }}" alt="" />
                                </a>
                            </div>
                            <div class="cat_name">
                                <a href="{{ route('category', $value->slug) }}">
                                    {{ $value->name }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>

<section class="homeproduct">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="sec_title">
                    <h3 class="section-title-header">
                        <div class="timer_inner">
                            <div class="">
                                <span class="section-title-name"> Hot Deal </span>
                            </div>

                            <div class="">
                                <div class="offer_timer" id="simple_timer"></div>
                            </div>
                        </div>
                    </h3>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="product_slider owl-carousel">
                    @foreach ($hotdeal_top as $key => $value)
                        <div class="product_item wist_item">
                            <div class="product_item_inner">
                                @if($value->old_price)
                                <div class="sale-badge">
                                    <div class="sale-badge-inner">
                                        <div class="sale-badge-box">
                                            <span class="sale-badge-text">
                                                <p>@php $discount=(((($value->old_price)-($value->new_price))*100) / ($value->old_price)) @endphp {{ number_format($discount, 0) }}% ছাড়</p>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="pro_img">
                                    <a href="{{ route('product', $value->slug) }}">
                                        <img src="{{ asset($value->image ? $value->image->image : '') }}"
                                            alt="{{ $value->name }}" />
                                    </a>
                                </div>
                                <div class="pro_des">
                                    <div class="pro_name">
                                        <a
                                            href="{{ route('product', $value->slug) }}">{{ Str::limit($value->name, 80) }}</a>
                                    </div>
                                    <div class="pro_price">
                                        <p>
                                            @if ($value->old_price)
                                             <del>৳ {{ $value->old_price }}</del>
                                            @endif

                                            ৳ {{ $value->new_price }} 
                                           
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @if (!$value->prosizes->isEmpty() || !$value->procolors->isEmpty())
                                <div class="pro_btn">
                                   
                                    <div class="cart_btn order_button">
                                        <a href="{{ route('product', $value->slug) }}"
                                            class="addcartbutton">অর্ডার করুন </a>
                                    </div>
                                </div>
                            @else
                                <div class="pro_btn">
                                    
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $value->id }}" />
                                        <input type="hidden" name="qty" value="1" />
                                        <button type="submit">অর্ডার করুন</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-sm-12 d-flex justify-content-center align-items-center">
               <a href="{{ route('hotdeals') }}" class="view_more_btn">View More</a> 
            </div>
        </div>
    </div>
</section>

@foreach ($homeproducts as $homecat)
    <section class="homeproduct">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="sec_title">
                        <h3 class="section-title-header">
                            <span class="section-title-name">{{ $homecat->name }}</span>
                            
                        </h3>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="product_sliders">
                        @foreach ($homecat->products as $key => $value)
                           <div class="product_item wist_item">
                            <div class="product_item_inner">
                                @if($value->old_price)
                                <div class="sale-badge">
                                    <div class="sale-badge-inner">
                                        <div class="sale-badge-box">
                                            <span class="sale-badge-text">
                                                <p>@php $discount=(((($value->old_price)-($value->new_price))*100) / ($value->old_price)) @endphp {{ number_format($discount, 0) }}% ছাড়</p>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="pro_img">
                                    <a href="{{ route('product', $value->slug) }}">
                                        <img src="{{ asset($value->image ? $value->image->image : '') }}"
                                            alt="{{ $value->name }}" />
                                    </a>
                                </div>
                                <div class="pro_des">
                                    <div class="pro_name">
                                        <a
                                            href="{{ route('product', $value->slug) }}">{{ Str::limit($value->name, 80) }}</a>
                                    </div>
                                    <div class="pro_price">
                                        <p>
                                            @if ($value->old_price)
                                             <del>৳ {{ $value->old_price }}</del>
                                            @endif

                                            ৳ {{ $value->new_price }} 
                                           
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @if (!$value->prosizes->isEmpty() || !$value->procolors->isEmpty())
                                <div class="pro_btn">
                                   
                                    <div class="cart_btn order_button">
                                        <a href="{{ route('product', $value->slug) }}"
                                            class="addcartbutton">অর্ডার করুন </a>
                                    </div>
                                </div>
                            @else
                                <div class="pro_btn">
                                    
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $value->id }}" />
                                        <input type="hidden" name="qty" value="1" />
                                        <button type="submit">অর্ডার করুন</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="show_more_btn">
                        <a href="{{ route('category', $homecat->slug) }}" class="view_more_btn">View More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endforeach

@endsection @push('script')
<script src="{{ asset('frontEnd/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('frontEnd/js/jquery.syotimer.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $(".main_slider").owlCarousel({
            items: 1,
            loop: true,
            dots: false,
            autoplay: true,
            nav: true,
            autoplayHoverPause: false,
            margin: 0,
            mouseDrag: true,
            smartSpeed: 8000,
            autoplayTimeout: 3000,
            animateOut: "fadeOutDown",
            animateIn: "slideInDown",

            navText: ["<i class='fa-solid fa-angle-left'></i>",
                "<i class='fa-solid fa-angle-right'></i>"
            ],
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(".hotdeals-slider").owlCarousel({
            margin: 15,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 3,
                    nav: true,
                },
                600: {
                    items: 3,
                    nav: false,
                },
                1000: {
                    items: 6,
                    nav: true,
                    loop: false,
                },
            },
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(".category-slider").owlCarousel({
            margin: 15,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 5,
                    nav: true,
                },
                600: {
                    items: 3,
                    nav: false,
                },
                1000: {
                    items: 8,
                    nav: true,
                    loop: false,
                },
            },
        });

        $(".product_slider").owlCarousel({
            margin: 15,
            items: 6,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 3,
                    nav: false,
                },
                600: {
                    items: 5,
                    nav: false,
                },
                1000: {
                    items: 6,
                    nav: false,
                },
            },
        });
    });
</script>

<script>
    $("#simple_timer").syotimer({
        date: new Date(2015, 0, 1),
        layout: "hms",
        doubleNumbers: false,
        effectType: "opacity",

        periodUnit: "d",
        periodic: true,
        periodInterval: 1,
    });
</script>
@endpush
