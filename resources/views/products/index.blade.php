@extends('layouts.app')

@section('page_name', __('meals.meals'))

@section('content')
<!-- Filter Sidebar Component -->
@if(!empty($filterData))
    <x-filter-sidebar
        :filters="$filterData"
        :currentFilters="$filters"
        modelName="meals"
        :route="route('meals.index')"
    />
@endif

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between">
              <h6>{{ __('meals.meal_list') }}</h6>
              <a href="{{route('meals.create')}}" class="btn btn-primary btn-sm {{ $isRtl ? 'float-start' : 'float-end' }}" type="button">
                <i class="fa fa-plus {{ $isRtl ? 'ms-1' : 'me-1' }}"></i>
                {{ __('meals.add_meal') }}
              </a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-3' : 'ps-3' }}">{{ __('meals.table.image') }}</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('meals.table.name') }}</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('meals.table.description') }}</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('meals.table.status') }}</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('meals.table.category_id') }}</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $isRtl ? 'pe-2' : 'ps-2' }}">{{ __('meals.table.created_at') }}</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('meals.table.actions') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($meals as $meal)
                      <tr>
                        <td class="ps-3">
                          <img src="{{ asset($meal->image) }}" class="avatar avatar-sm rounded-circle" alt="{{ $meal->getLocalizedName() }}">
                        </td>
                        <td>
                          <span class="text-sm">{{ $meal->getLocalizedName() }}</span>
                          @if(app()->getLocale() === 'ar' && $meal->name_en)
                            <br><small class="text-muted">{{ $meal->name_en }}</small>
                          @elseif(app()->getLocale() === 'en' && $meal->name_ar)
                            <br><small class="text-muted">{{ $meal->name_ar }}</small>
                          @endif
                        </td>
                        <td>
                          <span class="text-sm">{{ Str::limit($meal->getLocalizedDescription(), 30) }}</span>
                        </td>
                        <td>
                          <span class="text-sm">{{ $meal->is_active ? __('meals.active') : __('meals.inactive') }}</span>
                        </td>
                        <td>
                          <span class="text-sm">{{ $meal->category->name ?? '-' }}</span>
                        </td>
                        <td>
                          <span class="text-xs">{{ $meal->created_at->format('Y-m-d') }}</span>
                        </td>
                        <td>
                          <a href="{{ route('meals.edit', $meal->id) }}" class="btn btn-md btn-warning {{ $isRtl ? 'ms-1' : 'me-1' }}" title="{{ __('meals.edit_meal') }}">
                            <i class="fa fa-edit fa-lg"></i>
                          </a>
                          <form action="{{ route('meals.destroy', $meal->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-md btn-danger {{ $isRtl ? 'ms-1' : 'me-1' }}" title="{{ __('meals.delete_meal') }}" onclick="return confirm('{{ __('meals.delete_meal_confirm') }}')">
                                <i class="fa fa-trash fa-lg"></i>
                            </button>
                          </form>
                          <a href="{{route('meals.show', $meal->id)}}" class="btn btn-md btn-success" title="{{ __('meals.view_meal') }}">
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
            @if($meals->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        {{ $meals->links() }}
                    </div>
                </div>
            @endif
          </div>
        </div>
    </div>
</div>
@endsection