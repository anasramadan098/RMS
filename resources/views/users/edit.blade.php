@extends('layouts.app')


@section('content')

<style>
    .eye {
            cursor: pointer;
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(50%);
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Edit User: {{ $user->name }}</h1>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Users
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
                <form method="POST" action="{{ route('users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
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
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
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
                                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select @error('role') is-invalid @enderror" 
                                        id="role" 
                                        name="role" 
                                        required>
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->value }}" 
                                                {{ old('role', $user->role->value) == $role->value ? 'selected' : '' }}>
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

                        <input type="hidden" name="user_meals" value="{{$user->meals}}">
                        

                        <div class="col-md-6">
                            <div class="mb-3" style="position: relative;">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Make It Empty If You Don't Want To Change"
                                       style="padding-left:40px;">
                                    <i class="fa-solid fa-eye eye" onclick="showPassword()"></i>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>




                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Account Status</label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-success">Active</span>
                                <small class="text-muted d-block">Member since {{ $user->created_at->format('M d, Y') }}</small>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update User
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Danger Zone -->
        @if($user->id !== auth()->id())
            <div class="card mt-4 border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Danger Zone</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Once you delete this user, there is no going back. Please be certain.</p>
                    <form method="POST" 
                          action="{{ route('users.destroy', $user) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Delete User
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>


<script>
    function showPassword() {
        const input = document.querySelector('input[name="password"]');
        input.type == 'password' ? input.type = 'text' : input.type = 'password';
    }
</script>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="{{asset('js/user_meals.js')}}"></script>

@endsection
