@extends('auth.layout.app')


@section('content')
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 {{ $textAlign }} bg-transparent">
                  <!-- Language Switcher -->
                  <div class="d-flex justify-content-end mb-3">
                    @include('components.language-switcher')
                  </div>
                  <h3 class="font-weight-bolder text-info text-gradient">{{ __('app.welcome') }}</h3>
                  <p class="mb-0">{{ __('app.auth.login') }}</p>
                </div>
                <div class="card-body">
                    {{-- Get All Msg From Server --}}
                    @if (session('msg'))
                        <div class="alert alert-success">
                            {{ session('msg') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                  <form role="form" action="/login_user" method="POST">
                    @csrf
                    <label>{{ __('app.auth.email') }}</label>
                    <div class="mb-3">
                      <input type="email" name="email" class="form-control" placeholder="{{ __('app.auth.email') }}" aria-label="{{ __('app.auth.email') }}" aria-describedby="email-addon">
                    </div>
                    <label>{{ __('app.auth.password') }}</label>
                    <div class="mb-3">
                      <input type="password" name="password" class="form-control" placeholder="{{ __('app.auth.password') }}" aria-label="{{ __('app.auth.password') }}" aria-describedby="password-addon">
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
                      <label class="form-check-label" for="rememberMe">{{ __('app.auth.remember_me') }}</label>
                    </div>
                    <div class="text-center">
                      <input type="submit" value="{{ __('app.auth.login') }}" class="btn bg-gradient-info w-100 my-4 mb-2">
                    </div>
                  </form>
                </div>
                {{-- <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    {{ __('app.auth.forgot_password') }}
                    <a href="/password/reset" class="text-info text-gradient font-weight-bold">{{ __('app.auth.reset_password') }}</a>
                  </p>
                </div> --}}
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('{{asset('img/curved-images/curved6.jpg')}}')"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
