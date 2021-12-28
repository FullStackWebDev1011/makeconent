<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <title>{{config('app.name', 'MkzApp')}}</title>
    <link rel="icon" href="{{ asset('logo.png') }}" />
    @include('common.style')
    <!-- Additional library for page -->
    <link rel="stylesheet" href="{{ asset('plugins/flag-icon-css/css/flag-icon.min.css') }}">
    @yield('style')
</head>
<body class="jumbo-page pace-done sidebar-pinned">
@include('common.copywriter.sidebar')
<main class="admin-main">
    @include('common.copywriter.header')
    @yield('content')
</main>
@include('modals.site_search_modal')
@include('common.script')
@yield('script')
</body>

</html>
