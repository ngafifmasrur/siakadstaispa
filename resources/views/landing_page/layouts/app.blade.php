<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Siakad STAISPA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Siakad Staispa" />
    <meta name="keywords" content="Siakad Staispa" />
    <meta content="Themesbrand" name="author" />
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('landing_page/images/logo.png') }}">

    <!--Material Icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('landing_page/css/materialdesignicons.min.css') }}" />

    <!-- Pixeden Icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('landing_page/css/pe-icon-7.css') }}" />

    <!-- tinyslider -->
    <link rel="stylesheet" href="{{ asset('landing_page/css/tiny-slider.css') }}">

    <!-- css -->
    <link href="{{ asset('landing_page/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('landing_page/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('landing_page/css/style.css') }}" rel="stylesheet" type="text/css" />

</head>

<body onload="return preloader();">

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="sk-cube-grid">
                <div class="sk-cube sk-cube1"></div>
                <div class="sk-cube sk-cube2"></div>
                <div class="sk-cube sk-cube3"></div>
                <div class="sk-cube sk-cube4"></div>
                <div class="sk-cube sk-cube5"></div>
                <div class="sk-cube sk-cube6"></div>
                <div class="sk-cube sk-cube7"></div>
                <div class="sk-cube sk-cube8"></div>
                <div class="sk-cube sk-cube9"></div>
            </div>
        </div>
    </div>

    @include('landing_page.layouts.partials.navbar')

    @yield('content')

    @include('landing_page.layouts.partials.footer')

    <script src="{{ asset('landing_page/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('landing_page/js/smooth-scroll.polyfills.min.js') }}"></script>
    <script src="{{ asset('landing_page/js/gumshoe.polyfills.min.js') }}"></script>
    <script src="{{ asset('landing_page/js/tiny-slider.js') }}"></script>
    <!-- Main Js -->
    <script src="{{ asset('landing_page/js/app.js') }}"></script>
</body>

</html>