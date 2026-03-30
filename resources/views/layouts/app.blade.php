<!Doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $direction }}" class="{{ \App\Helpers\LocalizationHelper::getBodyClasses() }}">


    @include('layouts.head')

    @section('page_name' , 'Dashboard')
    <body class="g-sidenav-show  bg-gray-100">

            @if (session('msg'))
                <div class="alert alert-success alert-home">
                    {{ session('msg') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success alert-home">
                    {{ session('success') }}
                </div>
            @endif

            @if (isset($errors))
                @if ($errors->any())
                    <div class="alert alert-danger alert-home">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endif



            @include('layouts.sidebar')
            <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
                @include('layouts.nav')
                @yield('content')
            </main>
            @include('layouts.fixed_nav')


            @include('layouts.footer')
    </body>



</html>
