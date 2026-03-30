@extends('layouts.app')

@section('page_name', __('app.errors.404_title'))

@section('content')
<div class="container-fluid py-4 {{ $textAlign }}">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5 text-center">
                    <!-- Error Icon -->
                    <div class="error-icon mb-4">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 5rem;"></i>
                    </div>

                    <!-- Error Code -->
                    <h1 class="display-1 fw-bold text-primary mb-3">404</h1>

                    <!-- Error Title -->
                    <h2 class="h3 text-dark mb-3">{{ __('app.errors.404_title') }}</h2>

                    <!-- Error Description -->
                    <p class="text-muted mb-4 lead">
                        {{ __('app.errors.404_description') }}
                    </p>

                    <!-- Search Box -->
                    <div class="row justify-content-center mb-4">
                        <div class="col-md-8">
                            @include('components.search')
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap justify-content-center gap-3 mb-4">
                        <a href="{{ url('/') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-home {{ $isRtl ? 'ms-2' : 'me-2' }}"></i>
                            {{ __('app.go_home') }}
                        </a>
                        <button onclick="history.back()" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-{{ $isRtl ? 'right' : 'left' }} {{ $isRtl ? 'ms-2' : 'me-2' }}"></i>
                            {{ __('app.go_back') }}
                        </button>
                    </div>

                    <!-- Quick Links -->
                    <div class="row {{ $textAlign }}">
                        <div class="col-12">
                            <h5 class="text-dark mb-3">{{ __('app.quick_links.title') }}:</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <a href="{{ route('products.index') }}" class="text-decoration-none">
                                                <i class="fas fa-box text-primary {{ $isRtl ? 'ms-2' : 'me-2' }}"></i>
                                                {{ __('products.products') }}
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('clients.index') }}" class="text-decoration-none">
                                                <i class="fas fa-users text-success {{ $isRtl ? 'ms-2' : 'me-2' }}"></i>
                                                {{ __('clients.clients') }}
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('sales.index') }}" class="text-decoration-none">
                                                <i class="fas fa-chart-line text-info {{ $isRtl ? 'ms-2' : 'me-2' }}"></i>
                                                {{ __('sales.sales') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <a href="{{ route('costs.index') }}" class="text-decoration-none">
                                                <i class="fas fa-coins text-warning {{ $isRtl ? 'ms-2' : 'me-2' }}"></i>
                                                {{ __('costs.costs') }}
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('supply.index') }}" class="text-decoration-none">
                                                <i class="fas fa-truck text-secondary {{ $isRtl ? 'ms-2' : 'me-2' }}"></i>
                                                {{ __('suppliers.suppliers') }}
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ url('/') }}" class="text-decoration-none">
                                                <i class="fas fa-tachometer-alt text-primary {{ $isRtl ? 'ms-2' : 'me-2' }}"></i>
                                                {{ __('app.dashboard') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-icon {
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
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

.list-unstyled a {
    transition: all 0.3s ease;
    padding: 5px 10px;
    border-radius: 5px;
    display: inline-block;
    width: 100%;
}

.list-unstyled a:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}
</style>

@endsection
