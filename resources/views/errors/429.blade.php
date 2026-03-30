@extends('errors.layout')

@section('code', '429')
@section('title', __('app.errors.429_title'))

@section('icon')
<i class="fas fa-tachometer-alt text-danger" style="font-size: 5rem;"></i>
@endsection

@section('message')
{{ __('app.errors.429_description') }}
@endsection

@section('custom_content')
<div class="alert alert-danger d-inline-block mb-4">
    <i class="fas fa-stopwatch me-2"></i>
    {{ __('app.errors.rate_limit_exceeded') }}
</div>

<!-- Countdown Timer -->
<div class="mt-3 p-3 bg-light rounded">
    <p class="text-muted mb-0">
        <i class="fas fa-clock me-2"></i>
        {{ __('app.errors.try_again_in') }} <span id="countdown">60</span> {{ __('app.errors.seconds') }}...
    </p>
    <div class="progress mt-2" style="height: 5px;">
        <div class="progress-bar bg-primary" id="progressBar" style="width: 100%;"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let timeLeft = 60;
const countdownElement = document.getElementById('countdown');
const progressBar = document.getElementById('progressBar');

const timer = setInterval(function() {
    timeLeft--;
    countdownElement.textContent = timeLeft;
    
    // Update progress bar
    const percentage = (timeLeft / 60) * 100;
    progressBar.style.width = percentage + '%';
    
    if (timeLeft <= 0) {
        clearInterval(timer);
        location.reload();
    }
}, 1000);
</script>
@endsection
