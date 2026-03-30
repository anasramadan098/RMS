@extends('layouts.app')

@section('page_name', __('clients.client_details'))

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Client Information Card -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6>{{ __('clients.client_information') }}</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if ($client->profile_picture)
                            <img src="{{ asset($client->profile_picture) }}" class="avatar avatar-xl rounded-circle" alt="{{ $client->name }}">
                        @else
                            <div class="avatar avatar-xl bg-gradient-primary rounded-circle mx-auto">
                                <i class="fas fa-user text-white fs-4"></i>
                            </div>
                        @endif
                        <h5 class="mt-3 mb-0">{{ $client->name }}</h5>
                        <span class="badge bg-{{ $client->type === 'customer' ? 'success' : ($client->type === 'lead' ? 'warning' : 'info') }}">
                            {{ ucfirst($client->type) }}
                        </span>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-2">
                            <strong>{{ __('clients.email') }}:</strong>
                            <span class="text-sm">{{ $client->email }}</span>
                        </div>
                        <div class="col-12 mb-2">
                            <strong>{{ __('clients.phone') }}:</strong>
                            <span class="text-sm">{{ $client->phone ?? '-' }}</span>
                        </div>
                        <div class="col-12 mb-2">
                            <strong>{{ __('clients.address') }}:</strong>
                            <span class="text-sm">{{ $client->address ?? '-' }}</span>
                        </div>
                        <div class="col-6 mb-2">
                            <strong>{{ __('clients.city') }}:</strong>
                            <span class="text-sm">{{ $client->city ?? '-' }}</span>
                        </div>
                        <div class="col-6 mb-2">
                            <strong>{{ __('clients.country') }}:</strong>
                            <span class="text-sm">{{ $client->country ?? '-' }}</span>
                        </div>
                        @if($client->notes)
                        <div class="col-12 mb-2">
                            <strong>{{ __('clients.notes') }}:</strong>
                            <span class="text-sm">{{ $client->notes }}</span>
                        </div>
                        @endif
                        <div class="col-12 mb-2">
                            <strong>{{ __('clients.registration_date') }}:</strong>
                            <span class="text-sm">@formatDate($client->created_at)</span>
                        </div>
                        <div class="col-12 mb-2">
                            <strong>{{ __('clients.last_activity') }}:</strong>
                            <span class="text-sm">{{ $client->last_activity ? $client->last_activity->format('Y-m-d H:i') : '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="col-lg-8 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6>{{ __('clients.statistics') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card bg-gradient-primary">
                                <div class="card-body p-3 text-center">
                                    <div class="text-white">
                                        <h4 class="text-white mb-0">{{ $statistics['total_orders'] }}</h4>
                                        <p class="mb-0 text-sm">{{ __('clients.total_orders') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card bg-gradient-success">
                                <div class="card-body p-3 text-center">
                                    <div class="text-white">
                                        <h4 class="text-white mb-0">{{ number_format($statistics['total_spent'], 2) }}</h4>
                                        <p class="mb-0 text-sm">{{ __('clients.total_spent') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card bg-gradient-info">
                                <div class="card-body p-3 text-center">
                                    <div class="text-white">
                                        <h4 class="text-white mb-0">{{ number_format($statistics['average_order_value'], 2) }}</h4>
                                        <p class="mb-0 text-sm">{{ __('clients.average_order_value') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card bg-gradient-warning">
                                <div class="card-body p-3 text-center">
                                    <div class="text-white">
                                        <h4 class="text-white mb-0">{{ $statistics['orders_this_month'] }}</h4>
                                        <p class="mb-0 text-sm">{{ __('clients.orders_this_month') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($statistics['last_order_date'])
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <strong>{{ __('clients.last_order') }}:</strong>
                                {{ $statistics['last_order_date']->format('Y-m-d H:i') }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Orders History -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>{{ __('clients.orders_history') }}</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addOrderModal">
                        <i class="fas fa-plus me-1"></i>
                        {{ __('clients.add_new_order') }}
                    </button>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if($client->orders->count() > 0)
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('orders.order_number') }}</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('orders.order_type') }}</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('orders.table_number') }}</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('orders.status') }}</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('orders.total_amount') }}</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('orders.created_at') }}</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('orders.items') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($client->orders as $order)
                                        <tr>
                                            <td class="ps-3">
                                                <span class="text-sm font-weight-bold">{{ $order->order_number }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ ucfirst($order->order_type) }}</span>
                                            </td>
                                            <td>
                                                <span class="text-sm">{{ $order->table_number ?? '-' }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-sm font-weight-bold">{{ number_format($order->total_amount, 2) }}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs">{{ $order->created_at->format('Y-m-d H:i') }}</span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#order-items-{{ $order->id }}">
                                                    <i class="fas fa-eye"></i> {{ __('orders.view_items') }}
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="order-items-{{ $order->id }}">
                                            <td colspan="7" class="bg-light">
                                                <div class="p-3">
                                                    <h6>{{ __('orders.order_items') }}:</h6>
                                                    @if($order->orderItems->count() > 0)
                                                        <div class="row">
                                                            @foreach($order->orderItems as $item)
                                                                <div class="col-md-6 col-lg-4 mb-2">
                                                                    <div class="card card-body p-2">
                                                                        <div class="d-flex align-items-center">
                                                                            @if($item->meal && $item->meal->image)
                                                                                <img src="{{ asset($item->meal->image) }}" class="avatar avatar-sm me-2" alt="{{ $item->meal->name_en ?? 'Deleted Meal' }}">
                                                                            @else
                                                                                <div class="avatar avatar-sm bg-gradient-secondary me-2">
                                                                                    <i class="fas fa-utensils text-white"></i>
                                                                                </div>
                                                                            @endif
                                                                            <div>
                                                                                <h6 class="mb-0 text-sm">{{ $item->meal->name_en ?? 'وجبة محذوفة' }}</h6>
                                                                                <p class="text-xs mb-0">
                                                                                    {{ __('orders.quantity') }}: {{ $item->quantity }} |
                                                                                    {{ __('orders.price') }}: {{ number_format($item->unit_price, 2) }}
                                                                                </p>
                                                                                @if($item->special_instructions)
                                                                                    <p class="text-xs text-muted mb-0">{{ $item->special_instructions }}</p>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <p class="text-muted">{{ __('orders.no_items_found') }}</p>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">{{ __('clients.no_orders_found') }}</h5>
                            <p class="text-muted">{{ __('clients.no_orders_description') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Favorite Meals -->
    @if($statistics['favorite_meals']->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>{{ __('clients.favorite_meals') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($statistics['favorite_meals'] as $meal)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card card-body">
                                    <div class="d-flex align-items-center">
                                        @if($meal->image)
                                            <img src="{{ asset($meal->image) }}" class="avatar avatar-lg me-3" alt="{{ $meal->name_en }}">
                                        @else
                                            <div class="avatar avatar-lg bg-gradient-primary me-3">
                                                <i class="fas fa-utensils text-white"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ $meal->name_en }}</h6>
                                            <p class="text-sm text-muted mb-0">{{ __('clients.ordered') }}: {{ $meal->total_ordered }} {{ __('clients.times') }}</p>
                                            <p class="text-sm mb-0">{{ __('meals.price') }}: {{ number_format($meal->price, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit me-1"></i>
                        {{ __('clients.edit_client') }}
                    </a>
                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger me-2" onclick="return confirm('{{ __('clients.delete_client_confirm') }}')">
                            <i class="fas fa-trash me-1"></i>
                            {{ __('clients.delete_client') }}
                        </button>
                    </form>
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        {{ __('app.back') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection