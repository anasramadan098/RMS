@extends('layouts.app')

@section('page_name', $__env->yieldContent('code', 'Error') . ' - ' . $__env->yieldContent('title', 'Something went wrong'))

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5 text-center">
                    <!-- Error Icon -->
                    <div class="error-icon mb-4">
                        @yield('icon', '<i class="fas fa-exclamation-circle text-danger" style="font-size: 5rem;"></i>')
                    </div>
                    
                    <!-- Error Code -->
                    <h1 class="display-1 fw-bold text-primary mb-3">
                        @yield('code', 'Error')
                    </h1>
                    
                    <!-- Error Title -->
                    <h2 class="h3 text-dark mb-3">
                        @yield('title', 'Something went wrong')
                    </h2>
                    
                    <!-- Error Description -->
                    <p class="text-muted mb-4 lead">
                        @yield('message', 'An unexpected error occurred. Please try again later.')
                    </p>
                    
                    <!-- Custom Content -->
                    @yield('custom_content')
                    
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
                        <button onclick="location.reload()" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-redo me-2"></i>
                            Try Again
                        </button>
                    </div>
                    
                    <!-- Additional Actions -->
                    @yield('additional_actions')
                    
                    <!-- Error Details for Development -->
                    @if(config('app.debug') && isset($exception))
                    <div class="mt-4">
                        <details class="text-start">
                            <summary class="btn btn-outline-info btn-sm">
                                <i class="fas fa-bug me-2"></i>
                                Show Technical Details
                            </summary>
                            <div class="mt-3 p-3 bg-light rounded">
                                <h6>Exception Details:</h6>
                                <p><strong>File:</strong> {{ $exception->getFile() }}</p>
                                <p><strong>Line:</strong> {{ $exception->getLine() }}</p>
                                <p><strong>Message:</strong> {{ $exception->getMessage() }}</p>
                            </div>
                        </details>
                    </div>
                    @endif
                    
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
    animation: fadeInUp 0.8s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    border-radius: 15px;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    animation: slideInUp 0.6s ease-out;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.btn {
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

details summary {
    cursor: pointer;
    border: none;
    outline: none;
}

details[open] summary {
    margin-bottom: 10px;
}
</style>

@yield('scripts')
@endsection
