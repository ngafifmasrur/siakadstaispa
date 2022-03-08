<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="language" content="{{ app()->getLocale() }}" />
        <meta name='geo.placename' content='Indonesia'/>
        <meta name='audience' content='all'/>
        <meta name='rating' content='general'/>
        <meta name='author' content='{{ env('APP_NAME') }}'/>
        <meta name='keywords' content='@yield('doc.keywords',  env('APP_KEYWORDS'))'/>

        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ env('APP_URL') }}" />
        <meta property="og:title" content="@yield('doc.title', env('APP_NAME'))" />
        <meta property="og:image" content="{{ asset('assets/img/logo/icon-sq256.png') }}" />
        <meta property="og:description" content="@yield('doc.description', env('APP_DESCRIPTION'))" />
        
        <title>@yield('title', env('APP_NAME'))</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/app.css?v=1.1') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.ico') }}"/>
        @stack('style')
    </head>
    <body class="@yield('bodyclass')">
        @yield('main')
        <script type="text/javascript" src="{{ asset('assets/js/app.js') }}"></script>
        @stack('script')
    </body>
</html>