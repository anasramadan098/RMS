@extends('layouts.app')

@section('page_name', 'Add Booking')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex align-items-center">
            <h6 class="mb-0">Add New Booking</h6>
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary btn-sm {{ $isRtl ? 'me-auto' : 'ms-auto' }}">
              <i class="fas fa-arrow-left {{ $isRtl ? 'ms-1' : 'me-1' }}"></i>
              Back to Bookings
            </a>
          </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3" role="alert">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card-body">
          <form action="{{ route('bookings.store') }}" method="POST">
            @csrf
            
            <div class="row">
              <!-- Customer Information -->
              <div class="col-md-6">
                <h6 class="mb-3 text-sm">Customer Information</h6>
                
                <div class="form-group mb-3">
                  <label for="name" class="form-control-label">Customer Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" 
                         id="name" name="name" value="{{ old('name') }}" required>
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group mb-3">
                  <label for="phone" class="form-control-label">Phone Number <span class="text-danger">*</span></label>
                  <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                         id="phone" name="phone" value="{{ old('phone') }}" required>
                  @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group mb-3">
                  <label for="client_id" class="form-control-label">Link to Client (Optional)</label>
                  <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id">
                    <option value="">Select a client (optional)</option>
                    @foreach($clients as $client)
                      <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                        {{ $client->name }} - {{ $client->email }}
                      </option>
                    @endforeach
                  </select>
                  @error('client_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- Booking Details -->
              <div class="col-md-6">
                <h6 class="mb-3 text-sm">Booking Details</h6>
                
                <div class="form-group mb-3">
                  <label for="guests" class="form-control-label">Number of Guests <span class="text-danger">*</span></label>
                  <input type="number" class="form-control @error('guests') is-invalid @enderror" 
                         id="guests" name="guests" value="{{ old('guests', 1) }}" min="1" max="100" required>
                  @error('guests')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group mb-3">
                  <label for="datetime" class="form-control-label">Date & Time <span class="text-danger">*</span></label>
                  <input type="datetime-local" class="form-control @error('datetime') is-invalid @enderror" 
                         id="datetime" name="datetime" value="{{ old('datetime') }}" required>
                  @error('datetime')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group mb-3">
                  <label for="status" class="form-control-label">Status</label>
                  <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                    <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                  </select>
                  @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <!-- Event Description -->
            <div class="row">
              <div class="col-12">
                <div class="form-group mb-3">
                  <label for="event" class="form-control-label">Event Description <span class="text-danger">*</span></label>
                  <textarea class="form-control @error('event') is-invalid @enderror" 
                            id="event" name="event" rows="4" required 
                            placeholder="Describe the event details (birthday party, business meeting, etc.)">{{ old('event') }}</textarea>
                  @error('event')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <!-- Submit Buttons -->
            <div class="d-flex justify-content-end">
              <a href="{{ route('bookings.index') }}" class="btn btn-light {{ $isRtl ? 'ms-2' : 'me-2' }}">Cancel</a>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save {{ $isRtl ? 'ms-1' : 'me-1' }}"></i>
                Create Booking
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  // Set minimum datetime to current time
  document.addEventListener('DOMContentLoaded', function() {
    const datetimeInput = document.getElementById('datetime');
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    
    const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
    datetimeInput.setAttribute('min', minDateTime);
  });
</script>
@endpush

@endsection