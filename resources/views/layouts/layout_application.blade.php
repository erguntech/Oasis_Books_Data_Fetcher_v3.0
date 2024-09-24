<!DOCTYPE html>
<!--
Author: ErgunTech @2024
Product Name: Oasis_Books_Data_Fetcher_v2.0
Contact: erguntech@gmail.com
-->
<html lang="tr">
<head>
    <title>Oasis Books Data Fetcher</title>
    <meta charset="utf-8"/>
    <meta name="description" content="Oasis Books Data Fetcher"/>
    <meta name="keywords" content="Oasis Books Data Fetcher"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
    @yield('PageVendorCSS')
    @yield('PageCustomCSS')
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css"/>
</head>

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
@include('layouts.partials.partial_app_theme_mode')
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        @include('layouts.partials.partial_app_header')
        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
            @include('layouts.partials.partial_app_sidebar')
            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                <div class="d-flex flex-column flex-column-fluid">
                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <div id="kt_app_content_container" class="app-container container-fluid">@yield('PageContent')</div>
                    </div>
                </div>
                @include('layouts.partials.partial_app_footer')
            </div>
        </div>
    </div>
</div>
@include('layouts.partials.partial_app_scrolltop')
@yield('PageModals')
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
@yield('PageVendorJS')
@yield('PageCustomJS')
</body>
</html>
