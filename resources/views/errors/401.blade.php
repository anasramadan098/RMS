@extends('errors.layout')

@section('code', '401')
@section('title', __('app.errors.401_title'))

@section('icon')
<i class="fas fa-user-lock text-warning" style="font-size: 5rem;"></i>
@endsection

@section('message')
{{ __('app.errors.401_description') }}
@endsection

@section('custom_content')
<div class="alert alert-warning d-inline-block mb-4">
    <i class="fas fa-key me-2"></i>
    {{ __('app.errors.authentication_required') }}
</div>
@endsection

@section('additional_actions')
<div class="mt-3">
    @guest
    <a href="{{ route('login') }}" class="btn btn-success btn-lg">
        <i class="fas fa-sign-in-alt me-2"></i>
        {{ __('auth.login_now') }}
    </a>
    @else
    <form method="POST" action="{{ route('logout') }}" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-warning btn-lg">
            <i class="fas fa-sign-out-alt me-2"></i>
            {{ __('auth.logout_and_login_again') }}
        </button>
    </form>
    @endguest
</div>
@endsection
