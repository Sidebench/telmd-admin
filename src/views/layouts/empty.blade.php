<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Admin') }}</title>

    <!-- Styles -->
    <link href="{{ asset('adminhtml/css/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('adminhtml/css/animate.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('adminhtml/css/icons.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('adminhtml/css/sidebar-menu.css') }}" rel="stylesheet"/>
    <link href="{{ asset('adminhtml/css/app-style.css') }}" rel="stylesheet"/>

    <!-- Scripts -->
    <script src="{{ asset('adminhtml/js/app.js') }}"></script>
</head>
<body>
    @yield('content')
</body>
</html>
