@props([
    'filters' => [],
    'currentFilters' => [],
    'modelName' => '',
    'route' => ''
])

@if(!empty($filters))
<!-- Filter Toggle Button -->
<div class="filter-toggle-container">
    <button class="btn btn-primary filter-toggle-btn" type="button" onclick="toggleFilterSidebar()">
        <i class="fas fa-filter me-2"></i>
        {{ __('app.filters.filters') }}
        @if(!empty(array_filter($currentFilters)))
            <span class="badge bg-light text-primary ms-2">{{ count(array_filter($currentFilters)) }}</span>
        @endif
    </button>
</div>

<!-- Filter Sidebar Overlay -->
<div class="filter-overlay" id="filterOverlay" onclick="closeFilterSidebar()"></div>

<!-- Filter Sidebar -->
<div class="filter-sidebar" id="filterSidebar">
    <div class="filter-sidebar-content">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-gradient-primary">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="text-white mb-0">
                        <i class="fas fa-filter me-2"></i>
                        {{ __('app.filters.filter') }} {{ $modelName }}
                    </h6>
                    <div class="d-flex gap-2">
                        @if(!empty(array_filter($currentFilters)))
                            <a href="{{ $route }}" class="btn btn-sm btn-outline-light">
                                <i class="fas fa-times me-1"></i>
                                {{ __('app.filters.clear') }}
                            </a>
                        @endif
                        <button type="button" class="btn btn-sm btn-outline-light" onclick="closeFilterSidebar()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body p-3">
                <form method="GET" action="{{ $route }}" id="filterForm">
                    @foreach($filters as $filter)
                        <x-filter-input
                            :field="$filter['field'] "
                            :type="$filter['type']"
                            :label="$filter['label'] "
                            :placeholder="$filter['placeholder'] ?? ''"
                            :value="$filter['value'] "
                            :options="$filter['options'] ?? [] "
                            :required="$filter['required'] ?? false"
                        />
                    @endforeach

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-search me-2"></i>
                            {{__('app.filters.apply_filters')}}
                        </button>

                        @if(!empty(array_filter($currentFilters)))
                            <a href="{{ $route }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-undo me-2"></i>
                                {{__('app.filters.reset')}}
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Active Filters Display -->
            @if(!empty(array_filter($currentFilters)))
                <div class="card-footer bg-light">
                    <small class="text-muted d-block mb-2">{{__('app.filters.active_filters')}}:</small>
                    <div class="d-flex flex-wrap gap-1">
                        @foreach($currentFilters as $field => $value)
                            @if(!empty($value))
                                @php
                                    $filterConfig = collect($filters)->firstWhere('field', $field);
                                    $displayValue = $value;

                                    // For select fields, show the label instead of value
                                    if ($filterConfig && $filterConfig['type'] === 'select' && isset($filterConfig['options'][$value])) {
                                        $displayValue = $filterConfig['options'][$value];
                                    }
                                @endphp
                                <span class="badge bg-primary">
                                    {{ $filterConfig['label'] ?? $field }}: {{ $displayValue }}
                                    <a href="{{ request()->fullUrlWithQuery([$field => null]) }}" class="text-white ms-1">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
    </div>
</div>

<style>
/* Filter Toggle Button */
.filter-toggle-container {
    position: fixed;
    top: 10%;
    right: 20px;
    z-index: 1050;
    animation: fadeInBounce 0.6s ease-out;
}

@keyframes fadeInBounce {
    0% {
        opacity: 0;
        transform: scale(0.3) translateY(-20px);
    }
    50% {
        opacity: 1;
        transform: scale(1.05);
    }
    70% {
        transform: scale(0.95);
    }
    100% {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.filter-toggle-btn {
    border-radius: 25px;
    padding: 10px 20px;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.filter-toggle-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

/* Filter Overlay */
.filter-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1040;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.filter-overlay.active {
    opacity: 1;
    visibility: visible;
}

/* Filter Sidebar */
.filter-sidebar {
    position: fixed;
    top: 0;
    right: -400px;
    width: 380px;
    height: 100vh;
    z-index: 1045;
    transition: right 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    background: transparent;
}

.filter-sidebar.active {
    right: 0;
}

.filter-sidebar-content {
    height: 100%;
    padding: 20px;
    background: #f8f9fa;
}

.filter-sidebar .card {
    border-radius: 15px;
    overflow: hidden;
    border: none;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.filter-sidebar .card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 20px;
}

.filter-sidebar .card-body {
    padding: 25px;
    max-height: calc(100vh - 200px);
    overflow-y: auto;
}

.filter-sidebar .form-control {
    border-radius: 8px;
    border: 2px solid #e3e6f0;
    transition: all 0.3s ease;
    padding: 12px 15px;
}

.filter-sidebar .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    transform: translateY(-1px);
}

.filter-sidebar .form-label {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 8px;
}

.filter-sidebar .btn {
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.filter-sidebar .btn:hover {
    transform: translateY(-1px);
}

.filter-sidebar .badge {
    font-size: 0.75rem;
    border-radius: 15px;
    padding: 5px 10px;
}

.filter-sidebar .badge a {
    text-decoration: none;
    color: inherit;
}

.filter-sidebar .badge a:hover {
    opacity: 0.8;
}

/* Custom Scrollbar */
.filter-sidebar .card-body::-webkit-scrollbar {
    width: 6px;
}

.filter-sidebar .card-body::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.filter-sidebar .card-body::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.filter-sidebar .card-body::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Responsive Design */
@media (max-width: 768px) {
    .filter-sidebar {
        width: 100%;
        right: -100%;
    }

    .filter-sidebar-content {
        padding: 10px;
    }

    .filter-toggle-container {
        top: 15px;
        right: 15px;
    }
}

@media (max-width: 480px) {
    .filter-sidebar-content {
        padding: 5px;
    }

    .filter-sidebar .card-body {
        padding: 20px;
    }
}

/* Animation for smooth entrance */
@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.filter-sidebar.active .filter-sidebar-content {
    animation: slideInRight 0.4s ease-out;
}
</style>

<script>
// Filter Sidebar Functions
function toggleFilterSidebar() {
    const sidebar = document.getElementById('filterSidebar');
    const overlay = document.getElementById('filterOverlay');

    if (sidebar.classList.contains('active')) {
        closeFilterSidebar();
    } else {
        openFilterSidebar();
    }
}

function openFilterSidebar() {
    const sidebar = document.getElementById('filterSidebar');
    const overlay = document.getElementById('filterOverlay');
    const body = document.body;

    sidebar.classList.add('active');
    overlay.classList.add('active');
    body.style.overflow = 'hidden'; // Prevent background scrolling

    // Add event listener for escape key
    document.addEventListener('keydown', handleEscapeKey);
}

function closeFilterSidebar() {
    const sidebar = document.getElementById('filterSidebar');
    const overlay = document.getElementById('filterOverlay');
    const body = document.body;

    sidebar.classList.remove('active');
    overlay.classList.remove('active');
    body.style.overflow = ''; // Restore scrolling

    // Remove event listener for escape key
    document.removeEventListener('keydown', handleEscapeKey);
}

function handleEscapeKey(event) {
    if (event.key === 'Escape') {
        closeFilterSidebar();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form on input change (optional)
    const autoSubmit = false; // Set to true for instant filtering

    if (autoSubmit) {
        const filterInputs = document.querySelectorAll('.filter-input');
        filterInputs.forEach(input => {
            input.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        });
    }

    // Handle filter form submission
    const filterForm = document.getElementById('filterForm');
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            // Remove empty inputs before submission
            const inputs = this.querySelectorAll('input, select');
            inputs.forEach(input => {
                if (!input.value || input.value === '') {
                    input.removeAttribute('name');
                }
            });

            // Close sidebar after form submission
            setTimeout(() => {
                closeFilterSidebar();
            }, 100);
        });
    }

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            // On larger screens, ensure sidebar is closed
            closeFilterSidebar();
        }
    });

    // Prevent sidebar from closing when clicking inside it
    const sidebar = document.getElementById('filterSidebar');
    if (sidebar) {
        sidebar.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});
</script>
@endif
