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
    <!-- 2. AddChat widget -->
    {{-- <div id="addchat_app" 
        data-baseurl="{{ url('') }}"
        data-csrfname="{{ 'X-CSRF-Token' }}"
        data-csrftoken="{{ csrf_token() }}"
    ></div> --}}

    <div id="app">
        <aside id="sidebar">
            <a class="navbar-brand mb-5" href="{{ url('/') }}">
                <img alt="image" src="{{ asset('image/logo.png') }}" class="header-logo"> <span class="logo-name">Otika</span>
            </a>
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav(this)"><i class="fa fa-arrow-left"></i></a>
            <h6 class="text-center mb-3">MAIN</h6>

            <ul class="list-group list-group-flush category_wrapper">
                @php
                    $list =  \App\Http\Controllers\ProductController::category();

                @endphp
                @foreach ($list->groupBy('category') as $category => $subcategory)
                    <li class="list-group-item accordion " onclick="dropDown(this)">
                        {{ $category }}
                    </li>
                    <div class="panel px-0">
                        <ul class="list-group subcat list-group-flush">
                            @foreach ($subcategory as $cat => $sub)
                                <li class="list-group-item subcat-item p-0">
                                    <a href="{{ route('subcategory.products',[$category, $sub->subcategory]) }}" id=""><i class="fa fa-angle-right"></i> {{ $sub->subcategory }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </ul>
        </aside>
        <div class="content">
            <nav class="navbar navbar-expand-md navbar-light shadow-sm navigation">
                <div class="container-fluid mx-1">
                    <button type="button" onclick="sidebarTooggle()" class="navbar-toggler" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-3">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <form class="form-inline mr-auto form-horizontal w-100" method="GET" action="{{ route('search') }}">
                                    <div class="input-group search-element">
                                        <input type="text" class="form-control" name="key" placeholder="Search">
                                        <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </ul>

                        {{-- <form class="form-inline mr-auto form-horizontal" method="GET" action="{{ route('search') }}">
                            <div class="input-group search-element">
                                <input type="text" class="form-control" name="key" placeholder="Search">
                                <div class="input-group-append">
                                  <button class="btn btn-primary" type="submit">
                                      <i class="fa fa-search"></i>
                                  </button>
                                </div>
                              </div>
                        </form> --}}
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-2 justify-content-center">
                            <li class="nav-item">
                                <a href="{{ URL::signedRoute('admin.layout') }}" class="nav-link">User</a>
                            </li>
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto" style="display: flex;align-items: baseline;">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item">
                                    <a href="{{ route('cart',auth()->user()->id) }}" class="nav-link">
                                        <span class="mr-4 d-flex align-content-center" id="cart">
                                            <i class="fa fa-shopping-cart" style="font-size: 1.2rem"></i><sup class="badge" id="vue-cart-products-count"> {{ count(auth()->user()->orderQueue) }}</sup>
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <img alt="image" src='@if(Auth::user()->image) {{asset(Auth::user()->image->first()->url) }} @else {{ asset("image/download.jpeg") }} @endif' class="user-img-radious-style">
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('transaction') }}"
                                           >
                                            Transactions
                                        </a>
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
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
            <main class="w-100">
                @yield('content')
            </main>
        </div>
        
        @if (Auth::user() && Auth::user()->isadmin == 1)
            <admin-chart :authuser="{{auth()->user()}}"></admin-chart>
        @elseif(Auth::user())
            <user-chat :authuser="{{auth()->user()}}"></user-chat>    
        @endif
    </div>
    <script src="{{ asset('js/nav.js') }}"></script>
    <script>
        wow = new WOW(
            {
                animateClass: 'animated',
                offset:       100,
                callback:     function(box) {

                }
            }
        );
        wow.init();
    </script>

    @yield('script')
    <!-- 3. AddChat JS -->
    <!-- Modern browsers -->
    {{-- <script type="module" src="{{ asset('assets/addchat/js/addchat.min.js') }}"></script> --}}
    <!-- Fallback support for Older browsers -->
    {{-- <script nomodule src="{{ asset('assets/addchat/js/addchat-legacy.min.js') }}"></script> --}}
</body>
</html>