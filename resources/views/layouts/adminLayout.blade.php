<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>xsnipperdev Admin</title>
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
    <!-- wowjs -->
    <link rel="stylesheet" href="{{ asset('css/wow.css') }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- JQuery -->
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('css')
    <link rel="stylesheet" href="{{asset('css/adminLayout.css')}}">
    @if (request()->routeIs('admin.uploads'))
        <link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">
    @endif
</head>

<body>
    <div class="wrapper" id="app">
        <div class="top_nav">
            <a href="#" class="logo_wrapper">
                <img src="{{ asset('image/logo.png') }}" alt="">
                <span class="site_name">SITE NAME <i class="fa fa-caret-up arrow"></i></span>
            </a>
            <ul>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link text-white dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre >
                        <img src="@if($user->image) {{asset($user->image->first()->url) }} @else {{ asset('image/download.jpeg') }} @endif" alt="" class="user_avatar mr-3">
                        {{ $user->name }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <div class="section-body">
            <aside class="sidebar">
                <ul>
                    <li>
                        <a href="#">Dashboard</a>
                    </li>
                    <li>
                        <a href="#">Transactions</a>
                    </li>
                    <li>
                        <a href="#">Products</a>
                    </li>
                    <li>
                        <a href="#">Deliveries</a>
                    </li>
                </ul>
            </aside>
            <div class="content_wrapper">
                <main class="content">
                    @yield('content')
                </main>
                <aside class="livechat">
                    @if ($user && $user->isadmin == 1)
                        <admin-chat :authuser="{{collect($user->only(['id','name','image']))}}" list_users="{{route('admin.users')}}" fetch_user_message={{ route('admin.user') }} send_message="{{ route('admin.chat') }}"></admin-chat>
                    @endif
                </aside>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            let caret = document.querySelector('.arrow');
            let dropdown = document.querySelector('.sidebar')
            document.querySelector('.logo_wrapper').addEventListener('click', function() {
                dropdown.classList.toggle('active');
                if (caret.style.transform == 'rotate(' + 180 + 'deg)') {
                    caret.style.transform = 'rotate(' + 0 + 'deg)'
                } else {
                    caret.style.transform = 'rotate(' + 180 + 'deg)'
                }
            }, true)
        }
    </script>
</body>

</html>