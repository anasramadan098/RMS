@extends('layouts.app')

@section('page_name', '500 - Internal Server Error')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5 text-center">
                    <!-- Error Icon -->
                    <div class="error-icon mb-4">
                        <i class="fas fa-server text-danger" style="font-size: 5rem;"></i>
                    </div>
                    
                    <!-- Error Code -->
                    <h1 class="display-1 fw-bold text-danger mb-3">500</h1>
                    
                    <!-- Error Title -->
                    <h2 class="h3 text-dark mb-3">Internal Server Error</h2>
                    
                    <!-- Error Description -->
                    <p class="text-muted mb-4 lead">
                        Something went wrong on our end. We're working to fix this issue. 
                        Please try again later or contact support if the problem persists.
                    </p>
                    
                    <!-- Status Message -->
                    <div class="alert alert-warning d-inline-block mb-4">
                        <i class="fas fa-tools me-2"></i>
                        Our team has been notified and is working on a solution.
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap justify-content-center gap-3 mb-4">
                        <a href="{{ url('/') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-home me-2"></i>
                            Go Home
                        </a>
                        <button onclick="location.reload()" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-redo me-2"></i>
                            Try Again
                        </button>
                        <button onclick="history.back()" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>
                            Go Back
                        </button>
                    </div>
                    
                    <!-- Troubleshooting Tips -->
                    <div class="row text-start">
                        <div class="col-12">
                            <h5 class="text-dark mb-3">What you can do:</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Refresh the page
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Clear your browser cache
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Try again in a few minutes
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Check your internet connection
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Contact support if issue persists
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Return to the homepage
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Error ID for support -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <small class="text-muted">
                            <strong>Error ID:</strong> {{ uniqid() }} | 
                            <strong>Time:</strong> {{ now()->format('Y-m-d H:i:s') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-icon {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
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
@endsection
