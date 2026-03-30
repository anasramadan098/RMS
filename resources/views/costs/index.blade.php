@extends('layouts.app')

@section('page_name', __('costs.costs'))

@section('content')
<!-- Filter Sidebar Component -->
@if(!empty($filterData))
    <x-filter-sidebar
        :filters="$filterData"
        :currentFilters="$filters"
        modelName="Costs"
        :route="route('costs.index')"
    />
@endif

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h6>{{ __('costs.cost_list') }}</h6>
                    <a href="{{ route('costs.create') }}" class="btn btn-primary btn-sm {{ $isRtl ? 'float-start' : 'float-end' }}" type="button">
                        <i class="fa fa-plus {{ $isRtl ? 'ms-1' : 'me-1' }}"></i>
                        {{ __('costs.add_cost') }}
                    </a>
                </div>

                @if(session('msg'))
                    <div class="alert alert-success mx-3 mt-3">{{ session('msg') }}</div>
                @endif

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center justify-content-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-3' : 'ps-3' }}">#</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('costs.table.name') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('costs.table.amount') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('costs.table.employee') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('costs.table.date') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('costs.table.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($costs as $cost)
                                    <tr>
                                        <td class="{{ $isRtl ? 'pe-3' : 'ps-3' }}">
                                            <span class="text-sm font-weight-bold">#{{ $cost->id }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm">{{ $cost->name }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm font-weight-bold">@formatCurrency($cost->amount)</span>
                                        </td>
                                        <td>
                                            <span class="text-sm">{{ $cost->user->name ?? __('app.no_data') }}</span>
                                        </td>
                                        <td>
                                            <span class="text-xs">@formatDate($cost->created_at)</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('costs.edit', $cost->id) }}" class="btn btn-md btn-warning {{ $isRtl ? 'ms-1' : 'me-1' }}" title="{{ __('costs.edit_cost') }}">
                                                <i class="fa fa-edit fa-lg"></i>
                                            </a>
                                            <form action="{{ route('costs.destroy', $cost->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-md btn-danger" title="{{ __('costs.delete_cost') }}" onclick="return confirm('{{ __('costs.delete_cost_confirm') }}')">
                                                    <i class="fa fa-trash fa-lg"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <span class="text-muted">{{ __('costs.no_costs_found') }}</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if($costs->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-center">
                            {{ $costs->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection