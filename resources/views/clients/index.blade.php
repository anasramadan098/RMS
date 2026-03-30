@extends('layouts.app')

@section('page_name', __('clients.clients'))

@section('content')
<!-- Filter Sidebar Component -->
@if(!empty($filterData))
    <x-filter-sidebar
        :filters="$filterData"
        :currentFilters="$filters"
        modelName="Clients"
        :route="route('clients.index')"
    />
@endif

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
      <div class="card-header pb-0 d-flex justify-content-between">
        <h6>{{ __('clients.client_list') }}</h6>
        <a href="{{ route('clients.create') }}" class="btn btn-primary btn-sm {{ $isRtl ? 'float-start' : 'float-end' }}" type="button">
          <i class="fa fa-plus {{ $isRtl ? 'ms-1' : 'me-1' }}"></i>
          {{ __('clients.add_client') }}
        </a>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center justify-content-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-3' : 'ps-3' }}">{{ __('clients.table.image') }}</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('clients.table.name') }}</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('clients.table.email') }}</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('clients.table.phone') }}</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('clients.table.type') }}</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('clients.table.orders_count') }}</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('clients.table.registration_date') }}</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('clients.table.last_activity') }}</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('clients.table.actions') }}</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($clients as $client)
                <tr>
                  <td class="{{ $isRtl ? 'pe-3' : 'ps-3' }}">
                    @if ($client->profile_picture)
                        <img src="{{ asset($client->profile_picture) }}" class="avatar avatar-sm rounded-circle" alt="{{ $client->name }}">
                    @else
                        <div class="avatar avatar-sm bg-gradient-success rounded-circle">
                            <i class="fas fa-user text-white"></i>
                        </div>
                    @endif
                  </td>
                  <td>
                    <span class="text-sm">{{ $client->name }}</span>
                  </td>
                  <td>
                    <span class="text-sm">{{ $client->email }}</span>
                  </td>
                  <td>
                    <span class="text-sm">{{ $client->phone ?? '-' }}</span>
                  </td>
                  <td>
                    <span class="text-sm">{{ $client->type ?? '-' }}</span>
                  </td>
                  <td>
                    <span class="badge bg-primary">{{ $client->orders_count ?? 0 }}</span>
                  </td>
                  <td>
                    <span class="text-xs">{{ \App\Helpers\LocalizationHelper::formatDate($client->created_at) }}</span>
                  </td>
                  <td>
                    <span class="text-xs">{{ $client->last_activity }}</span>
                  </td>
                  <td>
                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-md btn-warning {{ $isRtl ? 'ms-1' : 'me-1' }}" title="{{ __('clients.edit_client') }}">
                      <i class="fa fa-edit fa-lg"></i>
                    </a>
                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-md btn-danger {{ $isRtl ? 'ms-1' : 'me-1' }}" title="{{ __('clients.delete_client') }}" onclick="return confirm('{{ __('clients.delete_client_confirm') }}')">
                        <i class="fa fa-trash fa-lg"></i>
                      </button>
                    </form>
                    <a href="{{route('clients.show' , $client->id)}}" class="btn btn-md btn-success" title="{{ __('clients.view_client') }}">
                      <i class="fa-solid fa-eye"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <!-- Pagination -->
      @if($clients->hasPages())
          <div class="card-footer">
              <div class="d-flex justify-content-center">
                  {{ $clients->links() }}
              </div>
          </div>
      @endif
    </div>
  </div>
</div>
@endsection
