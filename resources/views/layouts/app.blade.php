<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.0/css/font-awesome.css" integrity="sha512-72McA95q/YhjwmWFMGe8RI3aZIMCTJWPBbV8iQY3jy1z9+bi6+jHnERuNrDPo/WGYEzzNs4WdHNyyEr/yXJ9pA==" crossorigin="anonymous" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://www.merchantbay.com/public/css/frontend.all.min.css" rel="stylesheet" type="text/css">
{{--    {!! Charts::assets() !!}--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chartist/0.10.1/chartist.min.css">

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/5.0.7/highcharts.js"></script>
</head>
<body>
    <div id="app">
        <div id="myHeader">
            <div class="header-top-section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2 logo">
                            <a href="{{ url('/') }}"><img src="https://www.merchantbay.com/public/images/logo.png" alt="Missing"></a>
                        </div>
                        <div class="col-md-7 menu" style="padding-top: 6px;">
                            <div id="navbar">
                                <nav class="navbar navbar-default">
                                    <!-- Brand and toggle get grouped for better mobile display -->
                                    <div class="navbar-header">
                                        <button type="button" class="ic navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                            <span class="sr-only">Toggle navigation</span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                    </div>

                                    <!-- Collect the nav links, forms, and other content for toggling -->
                                    <div class="ic collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                        <ul class="ic nav navbar-nav">
                                            <li>
                                                <a href="/products" class="">Products </a>
                                            </li>
                                            <li>
                                                <a href="/supplier_by_category" class="">Suppliers </a>
                                            </li>
                                            <li>
                                                <a href="/#" class="" data-toggle="dropdown">Solutions &amp; Membership <b class="icofont icofont-thin-down"></b></a>
                                                <ul>
                                                    <li class=""><a href="/supplier-membership/create/1">Supplier Membership</a>
                                                    </li>
                                                    <li class=""><a href="/buyer-membership">Buyer Membership</a>
                                                    </li>
                                                    <li class=""><a href="/trade_security">Trade security</a>
                                                    </li>
                                                    <li class="active"><a href="/create-rfq">Request for quote (RFQ)</a>
                                                    </li>
                                                    <li class=""><a href="/logistic-service">Logistic Service</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="/#" class="" data-toggle="dropdown">Help Center <b class="icofont icofont-thin-down"></b></a>
                                                <ul>
                                                    <li class=""><a href="/faq">FAQ</a>
                                                    </li>
                                                    <li class=""><a href="/help-buyer">For Buyers</a>
                                                    </li>
                                                    <li class=""><a href="/help-supplier">For suppliers</a>
                                                    </li>
                                                    <li class=""><a href="/contact-us">Contact / Submit a dispute</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="/industry-blogs" class="">Industry Blogs </a>
                                            </li>
                                        </ul>

                                    </div>
                                    <!-- /.navbar-collapse -->
                                </nav>
                            </div>
                        </div>
                        <div class="col-md-3 hotline-cont">
                        </div>
                    </div>
                </div>
            </div>
            <div style="height: 0px; border-bottom: 8px solid rgb(85, 168, 96);"></div>
        </div>
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
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
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <div class="footer-social-section" style="margin-top: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-md-9">
                    <div class="col-md-4 footer-det">
                        <span class="footer-det-hd">Merchant Bay</span>
                        <span class="footer-det-mhd">©2019-2020 All rights reserved</span>
                        <span class="footer-det-nhd">Developed By: <a href="http://22digitals.com/" target="_blank" style="color: #FFF;">22Digitals.com</a></span>
                    </div>
                    <div class="col-md-8">
                        <h5 class="followhd">Follow Us</h5>
                        <ul class="new-soc">
                            <li><a href="https://www.facebook.com/merchantbaybd"><i class="icofont icofont-social-facebook"></i></a></li>
                            <li><a href="https://twitter.com/MerchantBay"><i class="icofont icofont-social-twitter"></i></a></li>
                            <li><a href="https://www.linkedin.com/company/merchantbay"><i class="icofont icofont-brand-linkedin"></i></a></li>
                            <li><a href="https://www.instagram.com/merchant.bay/"><i class="icofont icofont-social-instagram"></i></a></li>
                            <li><a href="https://www.pinterest.com/merchantbaybd/"><i class="icofont icofont-social-pinterest"></i></a></li>
                            <li><a href="https://www.youtube.com/channel/UCFh7Sh8xvuedLyN9wIk5bTQ"><i class="icofont icofont-brand-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">&nbsp;</div>
            </div>
        </div>
    </div>
</body>
</html>
