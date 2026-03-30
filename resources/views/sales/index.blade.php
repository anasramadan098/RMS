@extends('layouts.app')

@section('page_name', __('orders.orders'))

@section('content')
<!-- Filter Sidebar Component -->
@if(!empty($filterData))
    <x-filter-sidebar
        :filters="$filterData"
        :currentFilters="$filters"
        modelName="orders"
        :route="route('orders.index')"
    />
@endif

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h6>{{ __('orders.orders_list') }}</h6>
                    <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm {{ $isRtl ? 'float-start' : 'float-end' }}" type="button">
                        <i class="fa fa-plus {{ $isRtl ? 'ms-1' : 'me-1' }}"></i>
                        {{ __('orders.add_order') }}
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success mx-3 mt-3">{{ session('success') }}</div>
                @endif

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center justify-content-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-3' : 'ps-3' }}">#</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('orders.table.client') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('meals.meal') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('orders.quantity') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('orders.table.total_amount') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('orders.table.order_status') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('orders.table.order_date') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('orders.table.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td class="{{ $isRtl ? 'pe-3' : 'ps-3' }}">
                                            <span class="text-sm font-weight-bold">#{{ $order->order_number }}</span>
                                        </td>
                                        <td>   
                                            <span class="text-sm">{{ $order->client->name ?? __('app.no_data') }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm">{{ $order->meal->name_en?? __('app.no_data') }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm">{{ $order->quantity ?? 1 }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm font-weight-bold">@formatCurrency($order->total ?? $order->price)</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'secondary') }}">
                                                {{ __('orders.statuses.' . ($order->status ?? 'pending')) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-xs">@formatDate($order->created_at)</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-md btn-success {{ $isRtl ? 'ms-1' : 'me-1' }}" title="{{ __('orders.view_order') }}">
                                                <i class="fa fa-eye fa-lg"></i>
                                            </a>
                                            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-md btn-warning {{ $isRtl ? 'ms-1' : 'me-1' }}" title="{{ __('orders.edit_order') }}">
                                                <i class="fa fa-edit fa-lg"></i>
                                            </a>
                                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-md btn-danger" title="{{ __('orders.delete_order') }}" onclick="return confirm('{{ __('orders.delete_order_confirm') }}')">
                                                    <i class="fa fa-trash fa-lg"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <span class="text-muted">{{ __('orders.no_orders_found') }}</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-center">
                            {{ $orders->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection