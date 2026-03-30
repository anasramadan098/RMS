@extends('layouts.app')

@section('page_name', __('suppliers.suppliers'))

@section('content')
<!-- Filter Sidebar Component -->
@if(!empty($filterData))
    <x-filter-sidebar
        :filters="$filterData"
        :currentFilters="$filters"
        modelName="Suppliers"
        :route="route('supply.index')"
    />
@endif

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h6>{{ __('suppliers.supplier_list') }}</h6>
                    <a href="{{ route('supply.create') }}" class="btn btn-primary btn-sm {{ $isRtl ? 'float-start' : 'float-end' }}" type="button">
                        <i class="fa fa-plus {{ $isRtl ? 'ms-1' : 'me-1' }}"></i>
                        {{ __('suppliers.add_supplier') }}
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success mx-3 mt-3">{{ session('success') }}</div>
                @endif

                @if(session('msg'))
                    <div class="alert alert-success mx-3 mt-3">{{ session('msg') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger mx-3 mt-3">{{ session('error') }}</div>
                @endif

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center justify-content-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-3' : 'ps-3' }}">#</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('suppliers.table.supplier_name') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('suppliers.table.phone') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('suppliers.table.email') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('products.products') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('suppliers.table.created_at') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('suppliers.table.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($supply as $supplier)
                                    <tr>
                                        <td class="{{ $isRtl ? 'pe-3' : 'ps-3' }}">
                                            <span class="text-sm font-weight-bold">#{{ $supplier->id }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm font-weight-bold">{{ $supplier->supplier_name }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm">{{ $supplier->contact_number }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm">{{ $supplier->email }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $supplier->products_count ?? 0 }}</span>
                                        </td>
                                        <td>
                                            <span class="text-xs">@formatDate($supplier->created_at)</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('supply.show', $supplier) }}" class="btn btn-md btn-info {{ $isRtl ? 'ms-1' : 'me-1' }}" title="{{ __('suppliers.view_supplier') }}">
                                                <i class="fa fa-eye fa-lg"></i>
                                            </a>
                                            <a href="{{ route('supply.edit', $supplier) }}" class="btn btn-md btn-warning {{ $isRtl ? 'ms-1' : 'me-1' }}" title="{{ __('suppliers.edit_supplier') }}">
                                                <i class="fa fa-edit fa-lg"></i>
                                            </a>
                                            <form action="{{ route('supply.destroy', $supplier) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-md btn-danger" title="{{ __('suppliers.delete_supplier') }}" onclick="return confirm('{{ __('suppliers.delete_supplier_confirm') }}')">
                                                    <i class="fa fa-trash fa-lg"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <span class="text-muted">{{ __('suppliers.no_suppliers_found') }}</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if($supply->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-center">
                            {{ $supply->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection