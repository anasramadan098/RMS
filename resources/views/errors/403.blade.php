@extends('layouts.app')

@section('page_name', '403 - Access Forbidden')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5 text-center">
                    <!-- Error Icon -->
                    <div class="error-icon mb-4">
                        <i class="fas fa-lock text-danger" style="font-size: 5rem;"></i>
                    </div>
                    
                    <!-- Error Code -->
                    <h1 class="display-1 fw-bold text-danger mb-3">403</h1>
                    
                    <!-- Error Title -->
                    <h2 class="h3 text-dark mb-3">Access Forbidden</h2>
                    
                    <!-- Error Description -->
                    <p class="text-muted mb-4 lead">
                        You don't have permission to access this resource. 
                        Please contact your administrator if you believe this is an error.
                    </p>
                    
                    <!-- Status Message -->
                    <div class="alert alert-danger d-inline-block mb-4">
                        <i class="fas fa-shield-alt me-2"></i>
                        This area is restricted and requires proper authorization.
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap justify-content-center gap-3 mb-4">
                        <a href="{{ url('/') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-home me-2"></i>
                            Go Home
                        </a>
                        <button onclick="history.back()" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>
                            Go Back
                        </button>
                        @auth
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-warning btn-lg">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Logout
                            </button>
                        </form>
                        @else
                        <a href="{{ route('login') }}" class="btn btn-outline-success btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Login
                        </a>
                        @endauth
                    </div>
                    
                    <!-- Information -->
                    <div class="row text-start">
                        <div class="col-12">
                            <h5 class="text-dark mb-3">Possible reasons:</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="fas fa-times-circle text-danger me-2"></i>
                                            Insufficient permissions
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-times-circle text-danger me-2"></i>
                                            Account not activated
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-times-circle text-danger me-2"></i>
                                            Session expired
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="fas fa-times-circle text-danger me-2"></i>
                                            Wrong user role
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-times-circle text-danger me-2"></i>
                                            Resource is private
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-times-circle text-danger me-2"></i>
                                            Access temporarily restricted
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Information -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6 class="text-dark mb-2">Need Help?</h6>
                        <p class="text-muted mb-0">
                            Contact your system administrator or support team for assistance with access permissions.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-icon {
    animation: shake 1s infinite;
}

@keyframes shake {
    0%, 100% {
        transform: translateX(0);
    }
    25% {
        transform: translateX(-5px);
    }
    75% {
        transform: translateX(5px);
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
