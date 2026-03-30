@extends('layouts.app')

@section('page_name', __('orders.order_details'))

@section('content')
<div class="container {{ $textAlign }}">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('orders.order_details') }}</h1>
        <!-- Print Icon Button -->
        <form action="{{ route('bills.create', $order->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success" title="{{ __('orders.create_bill') }}">
                <i class="fas fa-file-invoice"></i>
            </button>
        </form>
    </div>

    <div id="order-bill">
        <div class="card mb-4">
            <div class="card-header {{ $textAlign }}">
                <strong>{{ __('orders.order') }} #{{ $order->order_number }}</strong>
            </div>
            <div class="card-body {{ $textAlign }}">
                <div class="row mb-2">
                    <div class="col-md-4">
                        <strong>{{ __('clients.client_name') }}:</strong> {{ $order->client->name ?? __('app.no_data') }}
                    </div>
                    <div class="col-md-4">
                        <strong>{{ __('clients.client_id') }}:</strong> {{ $order->client->id ?? __('app.no_data') }}
                    </div>
                    <div class="col-md-4">
                        <strong>{{ __('clients.email') }}:</strong> {{ $order->client->email ?? __('app.no_data') }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <strong>{{ __('orders.order_date') }}:</strong> @formatDate($order->created_at)
                    </div>
                    <div class="col-md-4">
                        <strong>{{ __('orders.status') }}:</strong> {{ __('orders.statuses.' . $order->status) }}
                    </div>
                    <div class="col-md-4">
                        <strong>{{ __('orders.table_number') }}:</strong> {{ $order->table_number ?? '-' }}
                    </div>
                    <div class="col-md-4">
                        <strong>{{ __('orders.quantity') }}:</strong> {{ $order->orderItems->sum('quantity') }}
                    </div>
                    <div class="col-md-4">
                        <strong>{{ __('orders.discount') }}:</strong> {{ $order->discount_amount }}
                    </div>
                    <div class="col-md-4">
                        <strong>{{ __('orders.size') }}:</strong> {{ $order->orderItems->first()->size ?? '-' }}
                    </div>
                    <div class="col-md-4">
                        <strong>{{ __('orders.total_amount') }}:</strong> @formatCurrency($order->total_amount)
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <strong>{{ __('orders.notes') }}:</strong> {{ $order->notes ?? __('app.no_data') }}
                    </div>
                </div>
            </div>
        </div>

        @if(isset($order->orderItems) && count($order->orderItems) > 0)
        <div class="card mb-4">
            <div class="card-header {{ $textAlign }}">
                <strong>{{ __('orders.order_items') }}</strong>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="{{ $isRtl ? 'pe-3' : 'ps-3' }}">{{ __('meals.meal_id') }}</th>
                            <th class="{{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('meals.meal_name') }}</th>
                            <th class="{{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('meals.price') }}</th>
                            <th class="{{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('orders.quantity') }}</th>
                            <th class="{{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('orders.total_amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->meal->id ?? __('app.no_data') }}</td>
                            <td>{{ $item->meal->name_en?? __('app.no_data') }}</td>
                            <td>@formatCurrency($item->unit_price ?? 0)</td>
                            <td>{{ $item->quantity ?? 1 }}</td>
                            <td>@formatCurrency(($item->unit_price ?? 0) * $item->quantity)</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="{{ $isRtl ? 'text-start' : 'text-end' }} p-3">
                    <strong>{{ __('orders.total') }}: @formatCurrency($order->total_amount)</strong>
                </div>
            </div>
        </div>
        @endif
    </div>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary">{{ __('orders.back_to_orders_list') }}</a>
</div>


@endsection