@extends('layouts.app')

@section('page_name', 'Edit Booking')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex align-items-center">
            <h6 class="mb-0">Edit Booking #{{ $booking->id }}</h6>
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
          <form action="{{ route('bookings.update', $booking) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
              <!-- Customer Information -->
              <div class="col-md-6">
                <h6 class="mb-3 text-sm">Customer Information</h6>
                
                <div class="form-group mb-3">
                  <label for="name" class="form-control-label">Customer Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" 
                         id="name" name="name" value="{{ old('name', $booking->name) }}" required>
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group mb-3">
                  <label for="phone" class="form-control-label">Phone Number <span class="text-danger">*</span></label>
                  <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                         id="phone" name="phone" value="{{ old('phone', $booking->phone) }}" required>
                  @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group mb-3">
                  <label for="client_id" class="form-control-label">Link to Client (Optional)</label>
                  <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id">
                    <option value="">Select a client (optional)</option>
                    @foreach($clients as $client)
                      <option value="{{ $client->id }}" 
                              {{ old('client_id', $booking->client_id) == $client->id ? 'selected' : '' }}>
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
                         id="guests" name="guests" value="{{ old('guests', $booking->guests) }}" min="1" max="100" required>
                  @error('guests')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group mb-3">
                  <label for="datetime" class="form-control-label">Date & Time <span class="text-danger">*</span></label>
                  <input type="datetime-local" class="form-control @error('datetime') is-invalid @enderror" 
                         id="datetime" name="datetime" value="{{ old('datetime', $booking->formatted_datetime) }}" required>
                  @error('datetime')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group mb-3">
                  <label for="status" class="form-control-label">Status <span class="text-danger">*</span></label>
                  <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="completed" {{ old('status', $booking->status) == 'completed' ? 'selected' : '' }}>Completed</option>
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
                            placeholder="Describe the event details (birthday party, business meeting, etc.)">{{ old('event', $booking->event) }}</textarea>
                  @error('event')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <!-- Booking Information -->
            <div class="row">
              <div class="col-12">
                <div class="alert alert-info">
                  <strong>Booking Information:</strong><br>
                  <small>Created: {{ $booking->created_at->format('Y-m-d H:i:s') }}</small><br>
                  <small>Last Updated: {{ $booking->updated_at->format('Y-m-d H:i:s') }}</small>
                </div>
              </div>
            </div>

            <!-- Submit Buttons -->
            <div class="d-flex justify-content-end">
              <a href="{{ route('bookings.index') }}" class="btn btn-light {{ $isRtl ? 'ms-2' : 'me-2' }}">Cancel</a>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save {{ $isRtl ? 'ms-1' : 'me-1' }}"></i>
                Update Booking
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection