@extends('layouts.app')

@section('page_name', 'Booking Details')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex align-items-center">
            <h6 class="mb-0">Booking Details #{{ $booking->id }}</h6>
            <div class="{{ $isRtl ? 'me-auto' : 'ms-auto' }}">
              <a href="{{ route('bookings.index') }}" class="btn btn-secondary btn-sm {{ $isRtl ? 'ms-1' : 'me-1' }}">
                <i class="fas fa-arrow-left {{ $isRtl ? 'ms-1' : 'me-1' }}"></i>
                Back to Bookings
              </a>
              <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit {{ $isRtl ? 'ms-1' : 'me-1' }}"></i>
                Edit
              </a>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <!-- Customer Information -->
            <div class="col-md-6">
              <div class="card shadow-none border">
                <div class="card-header bg-gradient-primary p-3">
                  <h6 class="text-white mb-0">
                    <i class="fas fa-user {{ $isRtl ? 'ms-1' : 'me-1' }}"></i>
                    Customer Information
                  </h6>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-6">
                      <h6 class="text-sm mb-1">Name</h6>
                      <p class="text-sm font-weight-bold">{{ $booking->name }}</p>
                    </div>
                    <div class="col-6">
                      <h6 class="text-sm mb-1">Phone</h6>
                      <p class="text-sm">
                        <a href="tel:{{ $booking->phone }}" class="text-primary">
                          {{ $booking->phone }}
                        </a>
                      </p>
                    </div>
                  </div>

                  @if($booking->client)
                    <hr class="horizontal dark my-3">
                    <h6 class="text-sm mb-1">Linked Client</h6>
                    <p class="text-sm">
                      <a href="{{ route('clients.show', $booking->client) }}" class="text-info">
                        <i class="fas fa-external-link-alt {{ $isRtl ? 'ms-1' : 'me-1' }}"></i>
                        {{ $booking->client->name }}
                      </a>
                      <br>
                      <small class="text-muted">{{ $booking->client->email }}</small>
                    </p>
                  @else
                    <hr class="horizontal dark my-3">
                    <p class="text-sm text-muted">No linked client</p>
                  @endif
                </div>
              </div>
            </div>

            <!-- Booking Details -->
            <div class="col-md-6">
              <div class="card shadow-none border">
                <div class="card-header bg-gradient-info p-3">
                  <h6 class="text-white mb-0">
                    <i class="fas fa-calendar {{ $isRtl ? 'ms-1' : 'me-1' }}"></i>
                    Booking Details
                  </h6>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-6">
                      <h6 class="text-sm mb-1">Date</h6>
                      <p class="text-sm font-weight-bold">{{ $booking->formatted_date }}</p>
                    </div>
                    <div class="col-6">
                      <h6 class="text-sm mb-1">Time</h6>
                      <p class="text-sm font-weight-bold">{{ $booking->formatted_time }}</p>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-6">
                      <h6 class="text-sm mb-1">Guests</h6>
                      <p class="text-sm">
                        <span class="badge bg-info">{{ $booking->guests }} {{ $booking->guests == 1 ? 'Guest' : 'Guests' }}</span>
                      </p>
                    </div>
                    <div class="col-6">
                      <h6 class="text-sm mb-1">Status</h6>
                      <p class="text-sm">
                        <span class="badge {{ $booking->status_badge_class }}">{{ $booking->status_display }}</span>
                      </p>
                    </div>
                  </div>

                  <hr class="horizontal dark my-3">
                  
                  <div class="row">
                    <div class="col-6">
                      <h6 class="text-sm mb-1">Upcoming</h6>
                      <p class="text-sm {{ $booking->is_upcoming ? 'text-success' : 'text-muted' }}">
                        <i class="fas {{ $booking->is_upcoming ? 'fa-check-circle' : 'fa-times-circle' }} {{ $isRtl ? 'ms-1' : 'me-1' }}"></i>
                        {{ $booking->is_upcoming ? 'Yes' : 'No' }}
                      </p>
                    </div>
                    <div class="col-6">
                      <h6 class="text-sm mb-1">Past</h6>
                      <p class="text-sm {{ $booking->is_past ? 'text-warning' : 'text-muted' }}">
                        <i class="fas {{ $booking->is_past ? 'fa-check-circle' : 'fa-times-circle' }} {{ $isRtl ? 'ms-1' : 'me-1' }}"></i>
                        {{ $booking->is_past ? 'Yes' : 'No' }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Event Description -->
          <div class="row mt-4">
            <div class="col-12">
              <div class="card shadow-none border">
                <div class="card-header bg-gradient-success p-3">
                  <h6 class="text-white mb-0">
                    <i class="fas fa-calendar-alt {{ $isRtl ? 'ms-1' : 'me-1' }}"></i>
                    Event Description
                  </h6>
                </div>
                <div class="card-body">
                  <p class="text-sm mb-0">{{ $booking->event }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Timestamps -->
          <div class="row mt-4">
            <div class="col-12">
              <div class="card shadow-none border">
                <div class="card-header bg-gradient-secondary p-3">
                  <h6 class="text-white mb-0">
                    <i class="fas fa-clock {{ $isRtl ? 'ms-1' : 'me-1' }}"></i>
                    Record Information
                  </h6>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <h6 class="text-sm mb-1">Created At</h6>
                      <p class="text-xs text-muted">{{ $booking->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>
                    <div class="col-md-6">
                      <h6 class="text-sm mb-1">Last Updated</h6>
                      <p class="text-xs text-muted">{{ $booking->updated_at->format('Y-m-d H:i:s') }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Status Update (if booking is not completed or cancelled) -->
          @if(!in_array($booking->status, ['completed', 'cancelled']))
            <div class="row mt-4">
              <div class="col-12">
                <div class="card shadow-none border">
                  <div class="card-header bg-gradient-warning p-3">
                    <h6 class="text-white mb-0">
                      <i class="fas fa-edit {{ $isRtl ? 'ms-1' : 'me-1' }}"></i>
                      Quick Status Update
                    </h6>
                  </div>
                  <div class="card-body">
                    <form id="statusForm" method="POST" action="{{ route('bookings.update', $booking) }}">
                      @csrf
                      @method('PUT')
                      
                      <!-- Hidden fields to maintain current data -->
                      <input type="hidden" name="name" value="{{ $booking->name }}">
                      <input type="hidden" name="phone" value="{{ $booking->phone }}">
                      <input type="hidden" name="guests" value="{{ $booking->guests }}">
                      <input type="hidden" name="datetime" value="{{ $booking->formatted_datetime }}">
                      <input type="hidden" name="event" value="{{ $booking->event }}">
                      <input type="hidden" name="client_id" value="{{ $booking->client_id }}">
                      
                      <div class="row align-items-end">
                        <div class="col-md-8">
                          <label for="status" class="form-control-label">Update Status</label>
                          <select class="form-select" id="status" name="status">
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <button type="submit" class="btn btn-warning btn-sm w-100">
                            <i class="fas fa-save {{ $isRtl ? 'ms-1' : 'me-1' }}"></i>
                            Update Status
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @endif
          
        </div>
      </div>
    </div>
  </div>
</div>

@endsection