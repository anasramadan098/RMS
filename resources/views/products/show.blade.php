@extends('layouts.app')

@section('page_name', __('meals.meal_details'))

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header Card -->
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $meal->getLocalizedName() }}</h4>
                            @if(app()->getLocale() === 'ar' && $meal->name_en)
                                <small class="text-muted">{{ $meal->name_en }}</small>
                            @elseif(app()->getLocale() === 'en' && $meal->name_ar)
                                <small class="text-muted">{{ $meal->name_ar }}</small>
                            @endif
                            <p class="text-sm mb-0">{{ __('meals.meal_details') }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            @if($meal->is_available)
                                <span class="badge bg-success">{{ __('meals.available') }}</span>
                            @else
                                <span class="badge bg-warning">{{ __('meals.unavailable') }}</span>
                            @endif

                            @if($meal->is_active)
                                <span class="badge bg-primary">{{ __('meals.active') }}</span>
                            @else
                                <span class="badge bg-secondary">{{ __('meals.inactive') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- معلومات الوجبة الأساسية -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>{{ __('meals.basic_information') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="form-label text-muted">{{ __('meals.meal_name_ar') }}</label>
                                        <p class="fw-bold">{{ $meal->name_ar }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="form-label text-muted">{{ __('meals.meal_name_en') }}</label>
                                        <p class="fw-bold">{{ $meal->name_en }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="form-label text-muted">{{ __('meals.description_ar') }}</label>
                                        <p>{{ $meal->description_ar ?: __('app.no_data') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="form-label text-muted">{{ __('meals.description_en') }}</label>
                                        <p>{{ $meal->description_en ?: __('app.no_data') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="form-label text-muted">{{ __('meals.price') }}</label>
                                        <p class="fw-bold text-success">{{ number_format($meal->price, 2) }} {{ __('app.currency') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="form-label text-muted">{{ __('meals.expiration_date') }}</label>
                                        <p>{{ $meal->expiration_date ?? __('app.no_data') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="form-label text-muted">{{ __('meals.discount_number') }}</label>
                                        <p>{{ $meal->discount_number ?? __('app.no_data') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="form-label text-muted">{{ __('meals.category') }}</label>
                                        <p class="fw-bold">{{ $meal->category->name ?? __('app.no_data') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-item mb-3">
                                        <label class="form-label text-muted">{{ __('meals.preparation_time') }}</label>
                                        <p class="fw-bold">
                                            @if($meal->preparation_time)
                                                {{ $meal->preparation_time }} {{ __('meals.minutes') }}
                                            @else
                                                {{ __('app.no_data') }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-item mb-3">
                                        <label class="form-label text-muted">ترتيب العرض</label>
                                        <p class="fw-bold">{{ $meal->order ?? 0 }}</p>
                                    </div>
                                </div>
                            </div>

                            @if($meal->description)
                                <div class="info-item mb-3">
                                    <label class="form-label text-muted">{{ __('meals.description') }}</label>
                                    <p>{{ $meal->description }}</p>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="form-label text-muted">{{ __('app.created_at') }}</label>
                                        <p>{{ $meal->created_at->format('Y-m-d H:i') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="form-label text-muted">{{ __('app.updated_at') }}</label>
                                        <p>{{ $meal->updated_at->format('Y-m-d H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- قسم المكونات -->
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6>{{ __('meals.ingredients') }}</h6>
                                <span class="badge bg-info">{{ $meal->ingredients->count() }} {{ __('meals.ingredient') }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($meal->ingredients->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>{{ __('meals.ingredient') }}</th>
                                                <th>{{ __('meals.quantity') }}</th>
                                                <th>{{ __('meals.unit') }}</th>
                                                <th>{{ __('ingredients.available_stock') }}</th>
                                                <th>{{ __('meals.notes') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($meal->ingredients as $ingredient)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-3">
                                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                    <i class="fas fa-leaf text-white"></i>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">{{ $ingredient->name }}</h6>
                                                                @if($ingredient->description)
                                                                    <small class="text-muted">{{ Str::limit($ingredient->description, 50) }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-primary">{{ $ingredient->pivot->quantity }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark">{{ $ingredient->unit }}</span>
                                                    </td>
                                                    <td>
                                                        @if($ingredient->stock_quantity > 0)
                                                            <span class="text-success fw-bold">{{ $ingredient->stock_quantity }} {{ $ingredient->unit }}</span>
                                                        @else
                                                            <span class="text-danger fw-bold">{{ __('ingredients.out_of_stock') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($ingredient->pivot->notes)
                                                            <small class="text-muted">{{ $ingredient->pivot->notes }}</small>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-list-ul text-muted" style="font-size: 3rem;"></i>
                                    <h6 class="mt-3 text-muted">{{ __('meals.no_ingredients') }}</h6>
                                    <p class="text-muted">{{ __('meals.no_ingredients_description') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- قسم الأحجام -->
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6><i class="fas fa-expand-arrows-alt me-2"></i>{{ __('meals.meal_sizes') }}</h6>
                                <span class="badge bg-success">{{ $meal->sizes->count() }} {{ __('meals.no_sizes') }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($meal->sizes->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>الحجم</th>
                                                <th>السعر</th>
                                                <th>الحالة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($meal->sizes->sortBy('sort_order') as $size)
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <h6 class="mb-0">{{ $size->name_ar }}</h6>
                                                            @if($size->name_en)
                                                                <small class="text-muted">{{ $size->name_en }}</small>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-success">{{ number_format($size->price, 2) }} ج.م</span>
                                                    </td>
                                                    <td>
                                                        @if($size->is_active)
                                                            <span class="badge bg-success">نشط</span>
                                                        @else
                                                            <span class="badge bg-secondary">غير نشط</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-expand-arrows-alt text-muted" style="font-size: 3rem;"></i>
                                    <h6 class="mt-3 text-muted">لا توجد أحجام مضافة</h6>
                                    <p class="text-muted">لم يتم إضافة أحجام لهذه الوجبة</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- قسم الإضافات -->
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6><i class="fas fa-plus-circle me-2"></i>{{ __('meals.meal_extras') }}</h6>
                                <span class="badge bg-info">{{ $meal->extras->count() }} {{ __('meals.no_extras') }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($meal->extras->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>الإضافة</th>
                                                <th>السعر</th>
                                                <th>الفئة</th>
                                                <th>الحالة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($meal->extras->sortBy('sort_order') as $extra)
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <h6 class="mb-0">{{ $extra->name_ar }}</h6>
                                                            @if($extra->name_en)
                                                                <small class="text-muted">{{ $extra->name_en }}</small>
                                                            @endif
                                                            @if($extra->description)
                                                                <br><small class="text-muted">{{ $extra->description }}</small>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-primary">{{ number_format($extra->price, 2) }} ج.م</span>
                                                    </td>
                                                    <td>
                                                        @if($extra->category)
                                                            <span class="badge bg-light text-dark">{{ $extra->category }}</span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($extra->is_active)
                                                            <span class="badge bg-success">نشط</span>
                                                        @else
                                                            <span class="badge bg-secondary">غير نشط</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-plus-circle text-muted" style="font-size: 3rem;"></i>
                                    <h6 class="mt-3 text-muted">لا توجد إضافات مضافة</h6>
                                    <p class="text-muted">لم يتم إضافة إضافات لهذه الوجبة</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- الصورة والإجراءات -->
                <div class="col-lg-4">
                    <!-- صورة الوجبة -->
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>{{ __('meals.meal_image') }}</h6>
                        </div>
                        <div class="card-body text-center">
                            @if($meal->image)
                                <img src="{{ asset("storage/{$meal->image}") }}" alt="{{ $meal->getLocalizedName() }}" class="img-fluid rounded shadow" style="max-width: 100%; max-height: 300px;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <div class="text-center">
                                        <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                                        <p class="text-muted mt-2">{{ __('meals.no_image') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- إحصائيات سريعة -->
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>{{ __('meals.quick_stats') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 col-lg-12 col-xl-6">
                                    <div class="border-end border-lg-0 border-xl-end mb-3 mb-lg-2 mb-xl-0">
                                        <h4 class="text-primary mb-0">{{ $meal->ingredients->count() }}</h4>
                                        <small class="text-muted">{{ __('meals.ingredients') }}</small>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-12 col-xl-6">
                                    <div class="mb-3 mb-lg-2 mb-xl-0">
                                        <h4 class="text-success mb-0">{{ number_format($meal->price, 2) }}</h4>
                                        <small class="text-muted">{{ __('meals.price') }}</small>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-12 col-xl-6">
                                    <div class="border-end border-lg-0 border-xl-end mb-3 mb-lg-0">
                                        <h4 class="text-warning mb-0">{{ $meal->sizes->count() }}</h4>
                                        <small class="text-muted">الأحجام</small>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-12 col-xl-6">
                                    <h4 class="text-info mb-0">{{ $meal->extras->count() }}</h4>
                                    <small class="text-muted">الإضافات</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- الإجراءات -->
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>{{ __('app.actions') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('meals.edit', $meal) }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-2"></i>
                                    {{ __('meals.edit_meal') }}
                                </a>

                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fas fa-trash me-2"></i>
                                    {{ __('meals.delete_meal') }}
                                </button>

                                <a href="{{ route('meals.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    {{ __('app.back_to_list') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">{{ __('meals.delete_meal_confirm') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                    <h6 class="mt-3">{{ __('meals.delete_warning') }}</h6>
                    <p class="text-muted">{{ __('meals.delete_warning_description') }}</p>
                    <div class="alert alert-warning">
                        <strong>{{ __('meals.meal_name') }}:</strong> {{ $meal->getLocalizedName() }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('app.cancel') }}</button>
                <form action="{{ route('meals.destroy', $meal) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>
                        {{ __('meals.delete_meal') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
.info-item label {
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.info-item p {
    margin-bottom: 0;
    font-size: 1rem;
}

.table th {
    font-weight: 600;
    font-size: 0.875rem;
    color: #6c757d;
    border-bottom: 2px solid #dee2e6;
}

.table td {
    vertical-align: middle;
    border-bottom: 1px solid #f1f3f4;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.badge {
    font-size: 0.75rem;
}

.btn {
    font-weight: 500;
}

.modal-content {
    border-radius: 0.5rem;
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.modal-header {
    border-bottom: 1px solid #dee2e6;
    background-color: #f8f9fa;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
    background-color: #f8f9fa;
}
</style>
@endsection