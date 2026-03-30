@extends('layouts.app')

@section('title', __('dashboard.owner_dashboard'))

@section('content')
<div class="row">
    <div class="col-12">
        <h1>{{ __('dashboard.owner_dashboard') }}</h1>
        <p class="text-muted">{{ __('dashboard.welcome_back', ['name' => auth()->user()->name]) }}</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">{{ __('dashboard.total_users') }}</h5>
                        <h2 class="mb-0">{{ $totalUsers }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">{{ __('dashboard.total_employees') }}</h5>
                        <h2 class="mb-0">{{ $totalEmployees }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-tie fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">{{ __('dashboard.total_owners') }}</h5>
                        <h2 class="mb-0">{{ $totalUsers - $totalEmployees }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-crown fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('dashboard.quick_actions') }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('users.index') }}" class="btn btn-outline-primary btn-lg w-100 mb-3">
                            <i class="fas fa-users me-2"></i>
                            {{ __('dashboard.manage_users') }}
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('users.create') }}" class="btn btn-outline-success btn-lg w-100 mb-3">
                            <i class="fas fa-user-plus me-2"></i>
                            {{ __('dashboard.add_new_user') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('dashboard.system_information') }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>{{ __('dashboard.your_role') }}:</strong> <span class="badge bg-warning">{{ auth()->user()->role->label() }}</span></p>
                        <p><strong>{{ __('dashboard.email') }}:</strong> {{ auth()->user()->email }}</p>
                        <p><strong>{{ __('dashboard.member_since') }}:</strong> {{ auth()->user()->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>{{ __('dashboard.last_login') }}:</strong> {{ now()->format('M d, Y H:i') }}</p>
                        <p><strong>{{ __('dashboard.system_status') }}:</strong> <span class="badge bg-success">{{ __('dashboard.online') }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
