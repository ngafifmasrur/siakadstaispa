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

    <!-- CANONICAL TAG -->
    <link rel="canonical"
        href="{{ (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] }}">

    <!-- css -->
    <link href="{{ asset('landing_page/css/style.min.css') }}" rel="stylesheet" type="text/css" />
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

    {{-- Style --}}
    <!-- Pixeden Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css" crossorigin="anonymous">

    {{-- Material Design --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/6.5.95/css/materialdesignicons.min.css" integrity="sha512-Zw6ER2h5+Zjtrej6afEKgS8G5kehmDAHYp9M2xf38MPmpUWX39VrYmdGtCrDQbdLQrTnBVT8/gcNhgS4XPgvEg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    {{-- Script Js --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scroll/16.1.3/smooth-scroll.polyfills.min.js" integrity="sha512-LZ6YBzwuQvIG41twjliX3HUVeAd+ErnJ0UsqRnkI4firX2l71jxbKJoax/hu7XY2tiyLl0YA2kcnz/XEW+9O3g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gumshoe/4.0.0/gumshoe.polyfills.min.js" crossorigin="anonymous"></script>
    {{-- <script src="{{ asset('landing_page/js/gumshoe.polyfills.min.js') }}"></script> --}}
    <!-- Main Js -->
    <script src="{{ asset('landing_page/js/app.js') }}"></script>

    {{-- Service Worker --}}
    <script nonce type="text/javascript">
        // Check that service workers are supported
        if ('serviceWorker' in navigator) {
            // Use the window load event to keep the page load performant
            window.addEventListener('load', () => {
                navigator.serviceWorker.register("{{ asset('/sw.js') }}");
            });
        }

    </script>
</body>

</html>
