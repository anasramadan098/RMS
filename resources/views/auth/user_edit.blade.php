@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{__('edit_user')}}</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">{{__('app.name')}}</label>
            <input 
                type="text" 
                class="form-control" 
                id="name" 
                name="name" 
                value="{{ old('name', $user->name) }}" 
                required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{__('app.auth.email')}}</label>
            <input 
                type="email" 
                class="form-control" 
                id="email" 
                name="email" 
                value="{{ old('email', $user->email) }}" 
                required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">{{__('app.auth.password')}} <small>({{__('app.leave_blank')}})</small></label>
            <input 
                type="password" 
                class="form-control" 
                id="password" 
                name="password">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">{{__('app.auth.confirm_password')}}</label>
            <input 
                type="password" 
                class="form-control" 
                id="password_confirmation" 
                name="password_confirmation">
        </div>

        <button type="submit" class="btn btn-primary">{{__('app.update')}}</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">{{__('app.cancel')}}</a>
    </form>
</div>
@endsection