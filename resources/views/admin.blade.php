<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- font awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- wowjs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/nav.css') }}">

    <!-- loader css -->
    <link rel="stylesheet" href="{{ asset('css/loaders.min.css') }}">

    <!-- wowjs -->
    <link rel="stylesheet" href="{{ asset('css/wow.css') }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- 1. Addchat css -->
    {{-- <link href="{{asset('assets/addchat/css/addchat.min.css') }}" rel="stylesheet"> --}}

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('css')
</head>
<body>
    <div id="app">
        <admin-chat list_users="{{route('admin.users')}}" fetch_user_message={{ route('admin.user') }} send_message="{{ route('admin.chat') }}"  :authuser="{{auth()->user()}}"></admin-chat>
    </div>
</body>
</html>