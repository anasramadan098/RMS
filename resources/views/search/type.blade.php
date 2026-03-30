@extends('layouts.app')

@section('page_name', __('search.categories.' . $type) . ' ' . __('search.search_results'))

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Search Header -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-2">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('search.index') }}">{{ __('search.search') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ __('search.categories.' . $type) }}</li>
                                </ol>
                            </nav>
                            <h4 class="mb-0">
                                <i class="fas fa-{{ $type === 'meals' ? 'box' : ($type === 'clients' ? 'users' : ($type === 'orders' ? 'chart-line' : ($type === 'costs' ? 'coins' : ($type === 'suppliers' ? 'truck' : 'project-diagram')))) }} me-2 text-primary"></i>
                                {{ __('search.categories.' . $type) }} {{ __('search.search_results') }}
                            </h4>
                            @if(!empty($query))
                                <p class="text-muted mb-0">
                                    {{ __('search.result_for') }} "<strong>{{ $query }}</strong>" {{ __('search.in') }} {{ __('search.categories.' . $type) }}
                                    <span class="badge bg-primary ms-2">{{ $results->count() }} {{ __('search.found') }}</span>
                                </p>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <!-- Search Form -->
                            <form method="GET" action="{{ route('search.type', $type) }}" class="d-flex">
                                <div class="input-group">
                                    <input type="text"
                                           name="q"
                                           class="form-control"
                                           placeholder="{{ __('search.placeholders.search_' . $type) }}"
                                           value="{{ $query }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if($results->isEmpty())
                <!-- No Results -->
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-search-minus text-muted mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-muted">{{ __('search.messages.no_' . $type . '_found') }}</h5>
                        @if(!empty($query))
                            <p class="text-muted">{{ __('search.messages.no_match_search', ['type' => __('search.categories.' . $type), 'query' => $query]) }}</p>
                        @else
                            <p class="text-muted">{{ __('search.messages.enter_search_to_find', ['type' => __('search.categories.' . $type)]) }}</p>
                        @endif

                        <div class="mt-4">
                            <a href="{{ route($type . '.index') }}" class="btn btn-primary me-2">
                                <i class="fas fa-list me-2"></i>
                                {{ __('search.buttons.view_all_' . $type) }}
                            </a>
                            <a href="{{ route('search.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-search me-2"></i>
                                {{ __('search.global_search') }}
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Results Table -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{ $results->count() }} {{ __('search.categories.' . $type) }} {{ __('search.found') }}</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center justify-content-center mb-0">
                                <thead>
                                    <tr>
                                        @switch($type)
                                            @case('meals')
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">{{ __('search.headers.meal') }}</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('search.headers.category') }}</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('search.headers.price') }}</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('search.headers.stock') }}</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('search.headers.supplier') }}</th>
                                                @break
                                            @case('clients')
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">{{ __('search.headers.client') }}</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('search.headers.email') }}</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('search.headers.phone') }}</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('search.headers.location') }}</th>
                                                @break
                                            @case('orders')
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">{{ __('search.headers.order') }}</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('search.headers.client') }}</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('search.headers.meal') }}</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('search.headers.total') }}</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('search.headers.status') }}</th>
                                                @break
                                            @case('costs')
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">{{ __('search.headers.cost') }}</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('search.headers.amount') }}</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('search.headers.date') }}</th>
                                                @break
                                            @case('suppliers')
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">{{ __('search.headers.supplier') }}</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('search.headers.contact') }}</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('search.headers.email') }}</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('search.headers.meals_count') }}</th>
                                                @break
                                            @case('projects')
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">{{ __('search.headers.project') }}</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('search.headers.status') }}</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('search.headers.date') }}</th>
                                                @break
                                        @endswitch
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('search.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results as $item)
                                        <tr>
                                            @switch($type)
                                                @case('meals')
                                                    <td class="ps-3">
                                                        <span class="text-sm font-weight-bold">{{ $item->name }}</span>
                                                        @if($item->description)
                                                            <br><small class="text-muted">{{ Str::limit($item->description, 50) }}</small>
                                                        @endif
                                                    </td>
                                                    <td><span class="text-sm">{{ $item->category ?? '-' }}</span></td>
                                                    <td><span class="text-sm font-weight-bold">${{ number_format($item->price, 2) }}</span></td>
                                                    <td><span class="text-sm">{{ $item->stock }}</span></td>
                                                    <td><span class="text-sm">{{ $item->supply->supplier_name ?? $item->supplier ?? '-' }}</span></td>
                                                    @break
                                                @case('clients')
                                                    <td class="ps-3"><span class="text-sm font-weight-bold">{{ $item->name }}</span></td>
                                                    <td><span class="text-sm">{{ $item->email }}</span></td>
                                                    <td><span class="text-sm">{{ $item->phone }}</span></td>
                                                    <td><span class="text-sm">{{ $item->city }}, {{ $item->country }}</span></td>
                                                    @break
                                                @case('orders')
                                                    <td class="ps-3"><span class="text-sm font-weight-bold">order #{{ $item->id }}</span></td>
                                                    <td><span class="text-sm">{{ $item->client->name ?? 'N/A' }}</span></td>
                                                    <td><span class="text-sm">{{ $item->meal->name_en?? 'N/A' }}</span></td>
                                                    <td><span class="text-sm font-weight-bold">${{ number_format($item->total ?? $item->price, 2) }}</span></td>
                                                    <td><span class="badge bg-{{ $item->status === 'completed' ? 'success' : 'warning' }}">{{ ucfirst($item->status ?? 'pending') }}</span></td>
                                                    @break
                                                @case('costs')
                                                    <td class="ps-3"><span class="text-sm font-weight-bold">{{ $item->name }}</span></td>
                                                    <td><span class="text-sm font-weight-bold">${{ number_format($item->amount, 2) }}</span></td>
                                                    <td><span class="text-xs">{{ $item->created_at->format('Y-m-d') }}</span></td>
                                                    @break
                                                @case('suppliers')
                                                    <td class="ps-3"><span class="text-sm font-weight-bold">{{ $item->supplier_name }}</span></td>
                                                    <td><span class="text-sm">{{ $item->contact_number }}</span></td>
                                                    <td><span class="text-sm">{{ $item->email }}</span></td>
                                                    <td><span class="badge bg-primary">{{ $item->meals_count ?? 0 }}</span></td>
                                                    @break
                                                @case('projects')
                                                    <td class="ps-3">
                                                        <span class="text-sm font-weight-bold">{{ $item->name }}</span>
                                                        @if($item->description)
                                                            <br><small class="text-muted">{{ Str::limit($item->description, 50) }}</small>
                                                        @endif
                                                    </td>
                                                    <td><span class="badge bg-info">{{ ucfirst($item->status) }}</span></td>
                                                    <td><span class="text-xs">{{ $item->created_at->format('Y-m-d') }}</span></td>
                                                {{-- ingredients --}}
                                                @case('ingredients')
                                                    <td class="ps-3"><span class="text-sm font-weight-bold">{{ $item->name }}</span></td>
                                                    <td><span class="text-sm">{{ $item->stock_quantity }}</span></td>
                                                    <td><span class="text-sm">{{ $item->unit }}</span></td>
                                                    <td><span class="text-sm">{{ number_format($item->price_per_unit, 2) }}</span></td>
                                                    <td><span class="text-sm">{{ $item->expiry_date ? $item->expiry_date->format('Y-m-d') : '-' }}</span></td>
                                                    @break
                                            @endswitch
                                            <td>
                                                @switch($type)
                                                    @case('meals')
                                                        <a href="{{ route('meals.show', $item->id) }}" class="btn btn-sm btn-info" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @break
                                                    @case('clients')
                                                        <a href="{{ route('clients.show', $item->id) }}" class="btn btn-sm btn-info" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @break
                                                    @case('orders')
                                                        <a href="{{ route('orders.show', $item->id) }}" class="btn btn-sm btn-info" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @break
                                                    @case('costs')
                                                        <a href="{{ route('costs.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @break
                                                    @case('suppliers')
                                                        <a href="{{ route('supply.show', $item->id) }}" class="btn btn-sm btn-info" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @break
                                                    @case('projects')
                                                        <a href="{{ route('projects.show', $item->id) }}" class="btn btn-sm btn-info" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @case('ingredients')
                                                        <a href="{{ route('ingredients.show', $item->id) }}" class="btn btn-sm btn-info" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @break
                                                @endswitch
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
