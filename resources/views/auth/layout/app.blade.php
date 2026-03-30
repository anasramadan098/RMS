<!Doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $direction }}" class="{{ \App\Helpers\LocalizationHelper::getBodyClasses() }}">
<head>
@include('layouts.head')
</head>
<body class="g-sidenav-show bg-gray-100 {{ \App\Helpers\LocalizationHelper::getBodyClasses() }}">

@include('auth.layout.navbar')

  <main class="main-content mt-0">
    @yield('content')

    @include('auth.layout.footer')
  </main>

@include('layouts.scripts')
</body>
</html>