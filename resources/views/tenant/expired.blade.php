@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Subscription Status') }}</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <h3>{{ $tenant->name }}</h3>
                        <p class="text-muted">{{ $tenant->email }}</p>
                    </div>

                    <div class="subscription-status p-4 rounded" style="background-color: #f8f9fa;">
                        <h4 class="mb-3">Subscription Information</h4>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Current Plan:</strong><br>
                                <span class="badge badge-{{ $tenant->subscribtion_type == 'premium' ? 'success' : ($tenant->subscribtion_type == 'enterprise' ? 'primary' : 'secondary') }}">
                                    {{ ucfirst($tenant->subscribtion_type) }}
                                </span>
                            </div>
                            <div class="col-md-6">
                                <strong>Status:</strong><br>
                                @if($tenant->hasActiveSubscription())
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Expired</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Subscription Started:</strong><br>
                                {{ $tenant->subscribtion_created ? \Carbon\Carbon::parse($tenant->subscribtion_created)->format('Y-m-d') : 'N/A' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Remaining Days:</strong><br>
                                <span class="font-weight-bold {{ $tenant->remaining_days <= 7 ? 'text-danger' : 'text-success' }}">
                                    {{ $tenant->remaining_days }} days
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <strong>Amount Paid:</strong><br>
                                ${{ number_format($tenant->subscribtion_amount, 2) }}
                            </div>
                        </div>
                    </div>

                    @if(!$tenant->hasActiveSubscription())
                        <div class="alert alert-warning mt-4">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Warning:</strong> Your subscription has expired. 
                            Please contact the system administrator to renew your subscription.
                        </div>
                    @endif

                    <div class="mt-4 text-center">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.subscription-status {
    border: 1px solid #dee2e6;
}

.badge {
    padding: 0.5em 1em;
    font-size: 0.9em;
}

.alert {
    border-radius: 0.25rem;
    padding: 1rem;
}
</style>
@endsection
