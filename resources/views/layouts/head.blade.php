<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('title')

    <!--     Fonts and icons     -->
  <link href="{{asset('css/fonts.css')}}" rel="stylesheet" />
  <!-- Nucleo Icons -->
  {{-- <link href="{{asset('css/nucleo-icons.css')}}" rel="stylesheet" /> --}}

  {{-- <link href="{{asset('css/nucleo-svg.css')}}" rel="stylesheet" /> --}}
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href={{asset('css/icons.css')}} integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href={{asset('css/fa_all.min.css')}} integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{asset('css/main.css')}}" rel="stylesheet" />
  <!-- RTL Support CSS -->
  <link href="{{asset('css/rtl-support.css')}}" rel="stylesheet" />

  {{-- FavICon --}}
  <link rel="icon" type="image/x-icon" href="{{asset('img/dash.ico')}}">

  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  {{-- <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script> --}}
</head>