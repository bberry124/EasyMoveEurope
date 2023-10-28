<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php
        if (!empty($blog->title)) {
            echo $blog->title;
        } else {
            echo "Hire a Van with Driver | Transportation service Europe";
        }
    ?></title>
    <meta name="description" content=<?php
        if (!empty($blog->header_description)) {
            echo $blog->header_description;
        } else {
            echo "Looking to hire a van with a driver for your next move? Easy Move Europe offers reliable and professional van hire services. Visit our website for more info.";
        }
    ?>/>
    <meta name="keywords" content=<?php
        if (!empty($blog->header_keywords)) {
            echo $blog->header_keywords;
        } else {
            echo "Hire a van with driver, Moving company, Transportation service Europe, Delivery van service, Europe Removals Company";
        }
    ?>/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(session('user-proxy-id'))
    <meta name="user-proxy-id" content="{{session('user-proxy-id')}}">
    @endif

    <!-- Favicons -->
    <link href="{{ asset('img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet">

    <!-- Styles -->

    <link rel="stylesheet" href="{{ asset('css/header&footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">


    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('vendor/php-email-form/validate.js') }}"></script>

    <!-- Toastr -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <style>
        .flag-en {
            background-image: url("{{asset('img/flags/usa.png')}}");
        }

        @media only screen
        and (min-device-width: 390px)
        and (max-device-width: 767px) {
            .residential_text {
                font-size:16px;
            }
        }


    </style>
    @yield('style')
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-7EZML0W28R"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-7EZML0W28R');
</script>


<meta name="google-site-verification" content="f-j9SdKa7QM-S1KMFzJ68oSGDRDgldzib-m8d5JvEsg" />
</head>
<body>
    <div id="app">
        @include("partials.navbar")


        <main class="">
            @yield('content')
        </main>

        @include("partials.footer")
    </div>
    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>

    <!-- Template Main JS File -->

    <script src="{{ asset('js/main.js') }}"></script>
@yield('scripts')
</body>
</html>
