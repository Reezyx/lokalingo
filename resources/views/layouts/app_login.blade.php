<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>
    <!-- Favicon -->
    <link href="{{ asset('argon/img/brand/lokalingo.png') }}" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Extra details for Live View on GitHub Pages -->

    <!-- Icons -->
    <link href="{{ asset('assets/vendor/nucleo/css/nucleo.css') }}" rel="stylesheet">
    <link href="{{ asset('argon/vendor/@fortawesome/fontawesome-free/css/all.min.css') }} " rel="stylesheet">
    <!-- Argon CSS -->
    <link type="text/css" href="{{ asset('argon/css/argon.css') }}" rel="stylesheet">
</head>

<body class="{{ $class ?? '' }}">
    <div class="main-content">
        @include('layouts.navbars.navbar')
        @yield('content')
    </div>

    @include('layouts.footers.guest')

    <script src="{{ asset('argon/vendor/jquery/dist/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script> --}}

    @stack('js')

    <!-- Argon JS -->
    <script src="{{ asset('argon/js/argon.js') }}"></script>
    <script src="{{ asset('argon/js/scripts.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('argon/js/vendors.bundle.js') }}" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
