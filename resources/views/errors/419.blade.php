@extends('layouts.app')

@section('page_name', '419 - ' . __('app.errors.419_title'))

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5 text-center">
                    <!-- Error Icon -->
                    <div class="error-icon mb-4">
                        <i class="fas fa-clock text-warning" style="font-size: 5rem;"></i>
                    </div>

                    <!-- Error Code -->
                    <h1 class="display-1 fw-bold text-warning mb-3">419</h1>

                    <!-- Error Title -->
                    <h2 class="h3 text-dark mb-3">{{ __('app.errors.419_title') }}</h2>

                    <!-- Error Description -->
                    <p class="text-muted mb-4 lead">
                        {{ __('app.errors.419_description') }}
                    </p>

                    <!-- Status Message -->
                    <div class="alert alert-warning d-inline-block mb-4">
                        <i class="fas fa-shield-alt me-2"></i>
                        {{ __('app.errors.security_measure') }}
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap justify-content-center gap-3 mb-4">
                        <button onclick="location.reload()" class="btn btn-primary btn-lg">
                            <i class="fas fa-redo me-2"></i>
                            {{ __('app.errors.refresh_page') }}
                        </button>
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-home me-2"></i>
                            {{ __('app.quick_links.go_home') }}
                        </a>
                        <button onclick="history.back()" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>
                            {{ __('app.quick_links.go_back') }}
                        </button>
                    </div>
                    
                    <!-- Information -->
                    <div class="row text-start">
                        <div class="col-12">
                            <h5 class="text-dark mb-3">{{ __('app.errors.why_happened') }}</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="fas fa-info-circle text-info me-2"></i>
                                            {{ __('app.errors.session_timeout') }}
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-info-circle text-info me-2"></i>
                                            {{ __('app.errors.page_open_too_long') }}
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-info-circle text-info me-2"></i>
                                            {{ __('app.errors.browser_cache_issues') }}
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="fas fa-lightbulb text-warning me-2"></i>
                                            {{ __('app.errors.simply_refresh') }}
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-lightbulb text-warning me-2"></i>
                                            {{ __('app.errors.data_safe') }}
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-lightbulb text-warning me-2"></i>
                                            {{ __('app.errors.no_action_required') }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Auto-refresh countdown -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <p class="text-muted mb-0">
                            <i class="fas fa-clock me-2"></i>
                            {{ __('app.errors.auto_refreshing') }} <span id="countdown">10</span> {{ __('app.errors.seconds') }}...
                            <button onclick="clearAutoRefresh()" class="btn btn-sm btn-outline-secondary ms-2">{{ __('app.cancel') }}</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-icon {
    animation: tick 1s infinite;
}

@keyframes tick {
    0%, 50% {
        transform: rotate(0deg);
    }
    25% {
        transform: rotate(-10deg);
    }
    75% {
        transform: rotate(10deg);
    }
}

.card {
    border-radius: 15px;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

.btn {
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.list-unstyled li {
    transition: all 0.3s ease;
    padding: 5px 10px;
    border-radius: 5px;
}

.list-unstyled li:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}
</style>

<script>
let countdownTimer;
let timeLeft = 10;

function startCountdown() {
    countdownTimer = setInterval(function() {
        timeLeft--;
        document.getElementById('countdown').textContent = timeLeft;
        
        if (timeLeft <= 0) {
            location.reload();
        }
    }, 1000);
}

function clearAutoRefresh() {
    clearInterval(countdownTimer);
    document.querySelector('.bg-light').style.display = 'none';
}

// Start countdown when page loads
document.addEventListener('DOMContentLoaded', startCountdown);
</script>
@endsection
