@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>{{ __('users.add_new_user') }}</h1>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>{{ __('app.back_to', ['item' => __('users.users')]) }}
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">User Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('users.name') }} <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required 
                                       autofocus>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('users.email') }} <span class="text-danger">*</span></label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="role" class="form-label">{{ __('users.role') }} <span class="text-danger">*</span></label>
                                <select class="form-select @error('role') is-invalid @enderror"
                                        id="role"
                                        name="role"
                                        required>
                                    <option value="">{{ __('users.placeholders.select_role') }}</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->value }}" 
                                                {{ old('role') == $role->value ? 'selected' : '' }}>
                                            {{ $role->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('users.password') }} <span class="text-danger">*</span></label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text">{{ __('users.validation.password_min') }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">{{ __('users.confirm_password') }} <span class="text-danger">*</span></label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required>
                            </div>
                        </div>
                    </div>


                    

                    
                    @foreach ($meals as $meal)
                        <div class="row meals">
                            <div class="col-md-4">
                                <div class="mb-3">
                                   <h6> {{$meal->name_en}} </h6>
                                   <h6> {{$meal->name_ar}} </h6>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="quantatity" class="form-label">Quantatity</label>
                                    <input type="number" 
                                        class="form-control" 
                                        name="quantatity" 
                                        data-id="{{$meal->id}}"
                                        data-name="{{$meal->name_ar}}"
                                        value="{{ old('quantatity' , 0) }}" 
                                        required>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <input type="hidden" name="user_meals" value="[]">

                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">{{ __('app.cancel') }}</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>{{ __('users.create_user') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="{{asset('js/user_meals.js')}}"></script>
@endsection
