@extends('layouts.app')

@section('page_name', __('bookings.bookings'))

@section('content')
<!-- Filter Sidebar Component -->
@if(!empty($filterData))
    <x-filter-sidebar
        :filters="$filterData"
        :currentFilters="$filters"
        modelName="Bookings"
        :route="route('bookings.index')"
    />
@endif

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0 d-flex justify-content-between">
          <h6>{{ __('bookings.booking_list') }}</h6>
          <a href="{{ route('bookings.create') }}" class="btn btn-primary btn-sm {{ $isRtl ? 'float-start' : 'float-end' }}" type="button">
            <i class="fa fa-plus {{ $isRtl ? 'ms-1' : 'me-1' }}"></i>
            {{ __('bookings.add_booking') }}
          </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3" role="alert">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center justify-content-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-3' : 'ps-3' }}">Name</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">Phone</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">Guests</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">Date & Time</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">Event</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">Client</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">Status</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($bookings as $booking)
                  <tr>
                    <td class="{{ $isRtl ? 'pe-3' : 'ps-3' }}">
                      <span class="text-sm font-weight-bold">{{ $booking->name }}</span>
                    </td>
                    <td>
                      <span class="text-sm">{{ $booking->phone }}</span>
                    </td>
                    <td>
                      <span class="badge bg-info">{{ $booking->guests }} {{ $booking->guests == 1 ? 'Guest' : 'Guests' }}</span>
                    </td>
                    <td>
                      <span class="text-sm">
                        {{ $booking->formatted_date }}<br>
                        <small class="text-xs text-muted">{{ $booking->formatted_time }}</small>
                      </span>
                    </td>
                    <td>
                      <span class="text-sm" title="{{ $booking->event }}">
                        {{ Str::limit($booking->event, 30) }}
                      </span>
                    </td>
                    <td>
                      @if($booking->client)
                        <span class="text-sm">{{ $booking->client->name }}</span>
                      @else
                        <span class="text-xs text-muted">No Client</span>
                      @endif
                    </td>
                    <td>
                      <span class="badge {{ $booking->status_badge_class }}">{{ $booking->status_display }}</span>
                    </td>
                    <td>
                      <div class="d-flex">
                        <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-info {{ $isRtl ? 'ms-1' : 'me-1' }}" title="View Booking">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-warning {{ $isRtl ? 'ms-1' : 'me-1' }}" title="Edit Booking">
                          <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this booking?')">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger" title="Delete Booking">
                            <i class="fas fa-trash"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8" class="text-center py-4">
                      <div class="text-muted">
                        <i class="fas fa-calendar-times fa-2x mb-2"></i><br>
                        No bookings found
                      </div>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <!-- Pagination -->
        @if($bookings->hasPages())
            <div class="card-footer">
                <div class="d-flex justify-content-center">
                    {{ $bookings->links() }}
                </div>
            </div>
        @endif
      </div>
    </div>
  </div>
</div>

@endsection