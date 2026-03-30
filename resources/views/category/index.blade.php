@extends('layouts.app')
@section('page_name', __('categories.categories'))
@section('content') <!-- Filter Sidebar Component -->
    @if(!empty($filterData)) <x-filter-sidebar :filters="$filterData" :currentFilters="$filters" modelName="Categories"
    :route="route('category.index')" />@endif
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4"> <div class="card-header pb-0 d-flex justify-content-between">
                        <h6>{{ __('categories.category_list') }}</h6> <a href="{{ route('category.create') }}"
                            class="btn btn-primary btn-sm {{ $isRtl ? 'float-start' : 'float-end' }}" type="button">
                            <i class="fa fa-plus {{ $isRtl ? 'ms-1' : 'me-1' }}"></i> {{ __('categories.add_category') }}
                        </a>
                    </div>
                    @if(session('success'))
                    <div class="alert alert-success mx-3 mt-3">{{ session('success') }}</div> @endif
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center justify-content-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">
                                            #</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">
                                            {{ __('categories.table.name') }}</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">
                                            {{ __('categories.table.description') }}</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">
                                            {{ __('categories.table.products_count') }}</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">
                                            {{ __('categories.table.type') }}</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">
                                            {{ __('categories.display_order') }}</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">
                                            {{ __('categories.table.created_at') }}</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">
                                            {{ __('categories.table.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody> @forelse($categories as $category)
                                    <tr>
                                        <td class="{{ $isRtl ? 'pe-3' : 'ps-3' }}">
                                            <span class="text-sm font-weight-bold">#{{ $category->id }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm font-weight-bold">{{ $category->getLocalizedName() }}</span>
                                            @if(app()->getLocale() === 'ar' && $category->name_en)
                                                <br><small class="text-muted">{{ $category->name_en }}</small>
                                            @elseif(app()->getLocale() === 'en' && $category->name_ar)
                                                <br><small class="text-muted">{{ $category->name_ar }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-sm font-weight-bold">{{ Str::limit($category->getLocalizedDescription(), 50) }}</span>
                                        </td>
                                        <td> <span class="text-sm font-weight-bold">{{ $category->meals_count ?? 0 }}</span>
                                        </td>
                                        <td> <span class="text-sm font-weight-bold">{{ $category->type ?? '-' }}</span>
                                        </td>
                                        <td> <span class="text-sm font-weight-bold">{{ $category->order ?? 0 }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-sm font-weight-bold">{{ $category->created_at->format('Y-m-d') ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('category.edit', $category) }}"
                                                    class="btn btn-link text-secondary mb-0"> <i
                                                        class="fa fa-edit text-xs"></i>
                                                </a>
                                                <form action="{{ route('category.destroy', $category) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger mb-0"
                                                        onclick="return confirm('{{ __('categories.confirm_delete') }}')">
                                                        <i class="fa fa-trash text-xs"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                </tr> @empty
                                        <tr>
                                            <td colspan="7" class="text-center">{{ __('categories.no_categories_found') }}</td>
                                    </tr> @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($categories->hasPages())
                        <div class="card-footer"> {{ $categories->links() }}
                    </div> @endif
                </div>
            </div>
        </div>
    </div>
@endsection