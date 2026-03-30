@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-lg-flex">
            <div>
              <h5 class="mb-0">
                <i class="fab fa-whatsapp text-success me-2"></i>
                {{ __('whatsapp.settings.whatsapp_settings') }}
              </h5>
              <p class="text-sm mb-0">
                {{ __('whatsapp.settings.api_configuration') }}
              </p>
            </div>
            <div class="ms-auto my-auto mt-lg-0 mt-4">
              <div class="ms-auto my-auto">
                <button type="button" class="btn btn-outline-primary btn-sm mb-0" onclick="testWhatsAppConnection()">
                  <i class="fas fa-vial me-1"></i>
                  {{ __('whatsapp.settings.test_connection') }}
                </button>
              </div>
            </div>
          </div>
        </div>
        
        <div class="card-body">
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <span class="alert-icon"><i class="ni ni-like-2"></i></span>
              <span class="alert-text">{{ session('success') }}</span>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <span class="alert-icon"><i class="ni ni-support-16"></i></span>
              <span class="alert-text">{{ session('error') }}</span>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <!-- WhatsApp Status -->
          <div class="row mb-4">
            <div class="col-md-6">
              <div class="card border">
                <div class="card-body text-center">
                  <div class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-lg mb-3">
                    <i class="fab fa-whatsapp text-white"></i>
                  </div>
                  <h6 class="mb-1">{{ __('whatsapp.status.status') }}</h6>
                  <p class="text-sm mb-0" id="whatsapp-status">
                    <span class="badge bg-secondary">{{ __('app.loading') }}</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card border">
                <div class="card-body text-center">
                  <div class="icon icon-shape icon-lg bg-gradient-info shadow text-center border-radius-lg mb-3">
                    <i class="fas fa-phone text-white"></i>
                  </div>
                  <h6 class="mb-1">{{ __('whatsapp.settings.whatsapp_number') }}</h6>
                  <p class="text-sm mb-0" id="whatsapp-number">
                    {{ config('services.twilio.whatsapp_from') ?: __('app.not_configured') }}
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Configuration Form -->
          <form action="{{ route('whatsapp.settings.save') }}" method="POST">
            @csrf
            
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="twilio_sid" class="form-label">{{ __('whatsapp.settings.twilio_sid') }}</label>
                <input type="text" name="twilio_sid" class="form-control" id="twilio_sid" 
                       value="{{ old('twilio_sid', config('services.twilio.sid')) }}" 
                       placeholder="ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx">
                <small class="form-text text-muted">{{ __('whatsapp.settings.twilio_sid_help') }}</small>
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="twilio_token" class="form-label">{{ __('whatsapp.settings.twilio_token') }}</label>
                <input type="password" name="twilio_token" class="form-control" id="twilio_token" 
                       value="{{ old('twilio_token') }}" 
                       placeholder="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx">
                <small class="form-text text-muted">{{ __('whatsapp.settings.twilio_token_help') }}</small>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="whatsapp_from" class="form-label">{{ __('whatsapp.settings.whatsapp_number') }}</label>
                <input type="text" name="whatsapp_from" class="form-control" id="whatsapp_from" 
                       value="{{ old('whatsapp_from', config('services.twilio.whatsapp_from')) }}" 
                       placeholder="whatsapp:+14155238886">
                <small class="form-text text-muted">{{ __('whatsapp.settings.whatsapp_number_help') }}</small>
              </div>
              
              <div class="col-md-6 mb-3 d-flex align-items-end">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="whatsapp_enabled" id="whatsapp_enabled" 
                         value="1" {{ config('services.twilio.whatsapp_enabled') ? 'checked' : '' }}>
                  <label class="form-check-label" for="whatsapp_enabled">
                    {{ __('whatsapp.settings.enable_service') }}
                  </label>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save me-1"></i>
                  {{ __('whatsapp.settings.save_settings') }}
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary ms-2">
                  {{ __('app.cancel') }}
                </a>
              </div>
            </div>
          </form>

          <!-- Test Connection Section -->
          <hr class="my-4">
          <div class="row">
            <div class="col-12">
              <h6>{{ __('whatsapp.settings.test_connection') }}</h6>
              <p class="text-sm text-muted">{{ __('whatsapp.settings.test_connection_help') }}</p>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group">
                    <input type="text" class="form-control" id="test_phone" 
                           placeholder="{{ __('whatsapp.form.phone_number') }}">
                    <button class="btn btn-outline-primary" type="button" onclick="testWhatsAppConnection()">
                      <i class="fas fa-paper-plane me-1"></i>
                      {{ __('whatsapp.buttons.test_whatsapp') }}
                    </button>
                  </div>
                </div>
              </div>
              
              <div id="test-result" class="mt-3" style="display: none;"></div>
            </div>
          </div>

          <!-- Statistics -->
          <hr class="my-4">
          <div class="row">
            <div class="col-12">
              <h6>{{ __('whatsapp.stats.title') }}</h6>
              <div class="row">
                <div class="col-md-3">
                  <div class="card border">
                    <div class="card-body text-center">
                      <h4 class="text-primary mb-0" id="total-clients">{{ $totalClients ?? 0 }}</h4>
                      <p class="text-sm mb-0">{{ __('whatsapp.stats.total_clients') }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="card border">
                    <div class="card-body text-center">
                      <h4 class="text-success mb-0" id="whatsapp-clients">{{ $whatsappClients ?? 0 }}</h4>
                      <p class="text-sm mb-0">{{ __('whatsapp.stats.clients_with_whatsapp') }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="card border">
                    <div class="card-body text-center">
                      <h4 class="text-info mb-0" id="enabled-clients">{{ $enabledClients ?? 0 }}</h4>
                      <p class="text-sm mb-0">{{ __('whatsapp.stats.whatsapp_enabled_clients') }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="card border">
                    <div class="card-body text-center">
                      <h4 class="text-warning mb-0" id="messages-sent">{{ $messagesSent ?? 0 }}</h4>
                      <p class="text-sm mb-0">{{ __('whatsapp.stats.total_sent') }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Check WhatsApp status on page load
document.addEventListener('DOMContentLoaded', function() {
    checkWhatsAppStatus();
});

function checkWhatsAppStatus() {
    fetch('{{ route("whatsapp.status") }}')
        .then(response => response.json())
        .then(data => {
            const statusElement = document.getElementById('whatsapp-status');
            if (data.enabled && data.configured) {
                statusElement.innerHTML = '<span class="badge bg-success">{{ __("whatsapp.status.enabled") }}</span>';
            } else if (data.configured) {
                statusElement.innerHTML = '<span class="badge bg-warning">{{ __("whatsapp.status.disabled") }}</span>';
            } else {
                statusElement.innerHTML = '<span class="badge bg-danger">{{ __("whatsapp.status.not_configured") }}</span>';
            }
        })
        .catch(error => {
            console.error('Error checking WhatsApp status:', error);
            document.getElementById('whatsapp-status').innerHTML = '<span class="badge bg-danger">{{ __("app.error") }}</span>';
        });
}

function testWhatsAppConnection() {
    const phone = document.getElementById('test_phone').value;
    const resultDiv = document.getElementById('test-result');
    
    if (!phone) {
        alert('{{ __("whatsapp.validation.phone_required") }}');
        return;
    }
    
    resultDiv.style.display = 'block';
    resultDiv.innerHTML = '<div class="alert alert-info"><i class="fas fa-spinner fa-spin me-1"></i> {{ __("app.testing") }}</div>';
    
    fetch('{{ route("whatsapp.test.connection") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ phone: phone })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.innerHTML = '<div class="alert alert-success"><i class="fas fa-check me-1"></i> ' + data.message + '</div>';
        } else {
            resultDiv.innerHTML = '<div class="alert alert-danger"><i class="fas fa-times me-1"></i> ' + data.message + '</div>';
        }
    })
    .catch(error => {
        console.error('Error testing WhatsApp connection:', error);
        resultDiv.innerHTML = '<div class="alert alert-danger"><i class="fas fa-times me-1"></i> {{ __("whatsapp.errors.connection_failed") }}</div>';
    });
}
</script>
@endsection
