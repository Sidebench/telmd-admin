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
    <link href="{{ asset('adminhtml/css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('adminhtml/css/bootstrap-datepicker.css') }}" rel="stylesheet"/>
    <link href="{{ asset('adminhtml/css/nestable.css') }}" rel="stylesheet"/>
    <link href="{{ asset('adminhtml/css/jquery.steps.css') }}" rel="stylesheet"/>
    <link href="{{ asset('adminhtml/css/simplebar.css') }}" rel="stylesheet"/>
    <link href="{{ asset('adminhtml/css/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('adminhtml/css/animate.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('adminhtml/css/icons.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('adminhtml/css/sidebar-menu.css') }}" rel="stylesheet"/>
    <link href="{{ asset('adminhtml/css/app-style.css') }}" rel="stylesheet"/>

    <!-- Scripts -->
    <script src="{{ asset('adminhtml/js/app.js') }}"></script>
</head>
<body>
    <div id="wrapper">
        <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
            <div class="brand-logo">
                <img src="{{ asset('adminhtml/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
                <a href="{{ route('admin.dashboard')}}"><h5 class="logo-text">{{ config('app.name', 'Admin') }}</h5></a>
            </div>
            @include('admin::page/navigation')
        </div>
        @include('admin::page/topbar')

        <div class="clearfix"></div>
        <div class="content-wrapper">
            @include('admin::page/alert')
            
            @yield('content')
        </div>

        @include('admin::page/footer')
  
    </div>
</body>
</html>
