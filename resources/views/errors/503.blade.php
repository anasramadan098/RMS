@extends('errors.layout')

@section('code', '503')
@section('title', 'Service Unavailable')

@section('icon')
<i class="fas fa-tools text-warning" style="font-size: 5rem;"></i>
@endsection

@section('message')
The service is temporarily unavailable due to maintenance. We'll be back shortly!
@endsection

@section('custom_content')
<div class="alert alert-info d-inline-block mb-4">
    <i class="fas fa-wrench me-2"></i>
    We're performing scheduled maintenance to improve your experience.
</div>

<!-- Maintenance Status -->
<div class="row text-start mt-4">
    <div class="col-12">
        <h5 class="text-dark mb-3">Maintenance Status:</h5>
        <div class="row">
            <div class="col-md-6">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Database optimization
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-spinner fa-spin text-primary me-2"></i>
                        Server updates in progress
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-clock text-warning me-2"></i>
                        Security patches pending
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title">Estimated Time</h6>
                        <p class="card-text">
                            <i class="fas fa-clock me-2"></i>
                            <span id="maintenanceTime">15-30 minutes</span>
                        </p>
                        <small class="text-muted">Started: {{ now()->format('H:i') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_actions')
<div class="mt-3">
    <button onclick="checkStatus()" class="btn btn-info btn-lg" id="checkBtn">
        <i class="fas fa-sync me-2"></i>
        Check Status
    </button>
</div>
@endsection

@section('scripts')
<style>
.error-icon {
    animation: rotate 2s linear infinite;
}

@keyframes rotate {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>

<script>
function checkStatus() {
    const btn = document.getElementById('checkBtn');
    const originalText = btn.innerHTML;
    
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Checking...';
    btn.disabled = true;
    
    // Simulate status check
    setTimeout(() => {
        // Try to reload the page
        location.reload();
    }, 2000);
}

// Auto-check every 30 seconds
setInterval(() => {
    fetch(window.location.href, { method: 'HEAD' })
        .then(response => {
            if (response.ok) {
                location.reload();
            }
        })
        .catch(() => {
            // Service still unavailable
        });
}, 30000);
</script>
@endsection
