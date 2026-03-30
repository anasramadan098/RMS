@extends('layouts.app')
@section('page_name', __('ingredients.ingredients'))
@section('content')<!-- Filter Sidebar Component -->
@if(!empty($filterData))    <x-filter-sidebar
        :filters="$filterData"        :currentFilters="$filters"
        modelName="Ingredients"        :route="route('ingredients.index')"
    />@endif
<div class="container-fluid py-4">
    <div class="row">        <div class="col-12">
            <div class="card mb-4">                <div class="card-header pb-0 d-flex justify-content-between">
                    <h6>{{ __('ingredients.ingredient_list') }}</h6>                    <a href="{{ route('ingredients.create') }}" class="btn btn-primary btn-sm {{ $isRtl ? 'float-start' : 'float-end' }}" type="button">
                        <i class="fa fa-plus {{ $isRtl ? 'ms-1' : 'me-1' }}"></i>                        {{ __('ingredients.add_ingredient') }}
                    </a>                </div>
                @if(session('success'))
                    <div class="alert alert-success mx-3 mt-3">{{ session('success') }}</div>                @endif
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">                        <table class="table align-items-center justify-content-center mb-0">
                            <thead>                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-3' : 'ps-3' }}">{{ __('ingredients.table.id') }}</th>                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('ingredients.table.name') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('ingredients.table.quantity') }}</th>                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('ingredients.table.unit') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('ingredients.table.cost') }}</th>                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('ingredients.table.created_at') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('ingredients.table.actions') }}</th>                                </tr>
                            </thead>                            <tbody>
                                @forelse($ingredients as $ingredient)                                    <tr>
                                        <td class="{{ $isRtl ? 'pe-3' : 'ps-3' }}">                                            <span class="text-sm font-weight-bold">#{{ $ingredient->id }}</span>
                                        </td>                                        <td>
                                            <span class="text-sm">{{ $ingredient->name }}</span>                                        </td>
                                        <td>                                            <span class="text-sm">{{ $ingredient->stock_quantity }}</span>
                                        </td>                                        <td>
                                            <span class="text-sm">{{ $ingredient->unit }}</span>                                        </td>
                                        <td>                                            <span class="text-sm">{{ number_format($ingredient->price_per_unit, 2) }}</span>
                                        </td>                                        <td>
                                            <span class="text-sm">{{ $ingredient->created_at->format('Y-m-d') }}</span>                                        </td>
                                        <td class="align-middle">                                            <div class="d-flex gap-2">
                                                <a href="{{ route('ingredients.show', $ingredient->id) }}" class="btn btn-link text-success mb-0">                                                    <i class="fa fa-eye text-xs"></i>
                                                </a>                                                <a href="{{ route('ingredients.edit', $ingredient->id) }}" class="btn btn-link text-secondary mb-0">                                                    <i class="fa fa-edit text-xs"></i>
                                                </a>                                                <form action="{{ route('ingredients.destroy', $ingredient->id) }}" method="POST" class="d-inline">
                                                    @csrf                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger mb-0" onclick="return confirm('{{ __('ingredients.confirm_delete') }}')">                                                        <i class="fa fa-trash text-xs"></i>
                                                    </button>                                                </form>
                                            </div>                                        
                                        </td>
                                    </tr>                                @empty
                                    <tr>                                        <td colspan="7" class="text-center">{{ __('ingredients.no_ingredients_found') }}</td>
                                    </tr>                                @endforelse
                            </tbody>                        </table>
                    </div>                    @if($ingredients->hasPages())
                        <div class="card-footer py-3">                            {{ $ingredients->links() }}
                        </div>                    @endif
                </div>            </div>
        </div>    </div>
</div>
@endsection

















































