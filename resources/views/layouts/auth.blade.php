<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <title>{{config('app.name', 'MkzApp')}}</title>
    @include('common.style')
    <!-- Additional library for page -->
    @yield('style')

</head>
<body class="jumbo-page">
    @yield('content')
    @include('modals.site_search_modal')
    @include('common.script')
    @yield('script')
</body>

</html>
