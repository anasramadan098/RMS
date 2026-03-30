@extends('layouts.app')

@section('page_name', __('search.search_results'))

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Search Header -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-0">
                                <i class="fas fa-search me-2 text-primary"></i>
                                {{ __('search.global_search') }}
                            </h4>
                            @if(!empty($query))
                                <p class="text-muted mb-0">
                                    {{ __('search.showing_results_for') }} "<strong>{{ $query }}</strong>"
                                    <span class="badge bg-primary ms-2">{{ $totalCount }} {{ __('search.results') }}</span>
                                </p>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <!-- Enhanced Search Form -->
                            @include('components.search')
                        </div>
                    </div>
                </div>
            </div>

            @if(empty($query))
                <!-- Search Tips -->
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-search text-muted mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-muted">{{ __('search.start_searching') }}</h5>
                        <p class="text-muted">
                            {{ __('search.search_across') }}
                        </p>

                        <!-- Quick Search Categories -->
                        <div class="row mt-4">
                            <div class="col-md-2 col-6 mb-3">
                                <a href="{{ route('meals.index') }}" class="text-decoration-none">
                                    <div class="card bg-primary text-white h-100">
                                        <div class="card-body text-center">                                            
                                            <i class="fa-solid fa-bowl-rice fa-2x mb-2"></i>
                                            <h6 class="mb-0">{{ __('search.categories.meals') }}</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-2 col-6 mb-3">
                                <a href="{{ route('ingredients.index') }}" class="text-decoration-none">
                                    <div class="card bg-secondary text-white h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-utensils fa-2x mb-2"></i>
                                            <h6 class="mb-0">{{ __('search.categories.ingredients') }}</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-2 col-6 mb-3">
                                <a href="{{ route('clients.index') }}" class="text-decoration-none">
                                    <div class="card bg-success text-white h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-users fa-2x mb-2"></i>
                                            <h6 class="mb-0">{{ __('search.categories.clients') }}</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-2 col-6 mb-3">
                                <a href="{{ route('orders.index') }}" class="text-decoration-none">
                                    <div class="card bg-info text-white h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-chart-line fa-2x mb-2"></i>
                                            <h6 class="mb-0">{{ __('search.categories.orders') }}</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-2 col-6 mb-3">
                                <a href="{{ route('costs.index') }}" class="text-decoration-none">
                                    <div class="card bg-warning text-white h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-coins fa-2x mb-2"></i>
                                            <h6 class="mb-0">{{ __('search.categories.costs') }}</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-2 col-6 mb-3">
                                <a href="{{ route('supply.index') }}" class="text-decoration-none">
                                    <div class="card bg-secondary text-white h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-truck fa-2x mb-2"></i>
                                            <h6 class="mb-0">{{ __('search.categories.suppliers') }}</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($totalCount == 0)
                <!-- No Results -->
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-search-minus text-muted mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-muted">{{ __('search.no_results_for') }} "{{ $query }}"</h5>
                        <p class="text-muted">{{ __('search.try_different_keywords') }}</p>

                        <div class="mt-4">
                            <a href="{{ route('search.index') }}" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>
                                {{ __('search.new_search') }}
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Search Results -->
                @foreach($formattedResults as $type => $data)
                    @if($data['count'] > 0)
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    <i class="fas fa-{{ $type === 'meals' ? 'box' : ($type === 'clients' ? 'users' : ($type === 'orders' ? 'chart-line' : ($type === 'costs' ? 'coins' : ($type === 'suppliers' ? 'truck' : 'project-diagram')))) }} me-2"></i>
                                    {{ __('search.categories.' . $type) }}
                                    <span class="badge bg-primary ms-2">{{ $data['count'] }}</span>
                                </h6>
                                <a href="{{ route('search.type', ['type' => $type, 'q' => $query]) }}" class="btn btn-sm btn-outline-primary">
                                    {{ __('search.view_all') }}
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($data['items'] as $item)
                                        <div class="col-md-6 col-lg-4 mb-3">
                                            <div class="card h-100 search-result-card">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-start">
                                                        <div class="flex-shrink-0">
                                                            <div class="avatar avatar-sm bg-gradient-{{ $item['color'] }} rounded-circle">
                                                                <i class="{{ $item['icon'] }} text-white"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="mb-1">
                                                                <a href="{{ $item['url'] }}" class="text-decoration-none">
                                                                    {{ $item['title'] }}
                                                                </a>
                                                            </h6>
                                                            <p class="text-sm text-muted mb-1">{{ $item['subtitle'] }}</p>
                                                            @if($item['description'])
                                                                <p class="text-xs text-muted mb-2">{{ Str::limit($item['description'], 60) }}</p>
                                                            @endif
                                                            @if(isset($item['price']))
                                                                <span class="badge bg-success">{{ $item['price'] }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</div>

<style>
.search-result-card {
    transition: all 0.3s ease;
    border: 1px solid #e3e6f0;
}

.search-result-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-color: #5e72e4;
}

.avatar {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border-bottom: 1px solid #e3e6f0;
}
</style>

<script>
// Auto-focus search input
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('globalSearchInput');
    if (searchInput && !searchInput.value) {
        searchInput.focus();
    }
});
</script>
@endsection
