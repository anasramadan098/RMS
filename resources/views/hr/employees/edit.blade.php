@extends('layouts.app')
@section('page_name', __('app.hr.edit_employee'))

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>{{ __('app.hr.edit_employee') }} - {{ $employee->name }}</h6>
                    <div class="d-flex gap-2">
                        <a href="{{ route('employees.show', $employee) }}" class="btn btn-outline-info btn-sm">
                            <i class="fa fa-eye me-1"></i>
                            {{ __('app.view') }}
                        </a>
                        <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa fa-arrow-left me-1"></i>
                            {{ __('app.back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Employee Form -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>تعديل بيانات الموظف</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('employees.update', $employee) }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ __('app.hr.employee_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $employee->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $employee->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">رقم الهاتف</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $employee->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="working_hours_per_day" class="form-label">{{ __('app.hr.working_hours_per_day') }} <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('working_hours_per_day') is-invalid @enderror" 
                                           id="working_hours_per_day" name="working_hours_per_day" 
                                           value="{{ old('working_hours_per_day', $employee->working_hours_per_day) }}" min="1" max="24" required>
                                    @error('working_hours_per_day')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="default_salary" class="form-label">{{ __('app.hr.default_salary') }} (جنيه) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('default_salary') is-invalid @enderror" 
                                           id="default_salary" name="default_salary" value="{{ old('default_salary', $employee->default_salary) }}" 
                                           step="0.01" min="0" required>
                                    @error('default_salary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hourly_rate" class="form-label">{{ __('app.hr.hourly_rate') }} (جنيه) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('hourly_rate') is-invalid @enderror" 
                                           id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate', $employee->hourly_rate) }}" 
                                           step="0.01" min="0" required>
                                    @error('hourly_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                               value="1" {{ old('is_active', $employee->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            موظف نشط
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">
                                الملحقات
                            </label>
                            <input type="file" multiple class="form-control @error('attachments') is-invalid @enderror" 
                                      id="attachments" name="attachments[]"  accept=".jpg,.pdf,.jpeg,.png,.webp">
                            @error('attachments')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            @if($employee->attachments)
                                <div class="mt-2">
                                    <small class="text-muted">الملحقات الحالية:</small>
                                    <div class="d-flex flex-wrap gap-2 mt-1">
                                        @foreach(json_decode($employee->attachments) as $attachment)
                                            <div class="border rounded p-2 bg-light">
                                                <a href="{{ asset($attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary ms-1">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">ملاحظات</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3">{{ old('notes', $employee->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                                {{ __('app.cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-1"></i>
                                {{ __('app.update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Employee Info -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>معلومات الموظف</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">تاريخ الانضمام</small>
                        <p class="mb-0">{{ $employee->created_at->format('Y-m-d') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">آخر تحديث</small>
                        <p class="mb-0">{{ $employee->updated_at->format('Y-m-d H:i') }}</p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">الحالة الحالية</small>
                        <p class="mb-0">
                            <span class="badge bg-{{ $employee->is_active ? 'success' : 'secondary' }}">
                                {{ $employee->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                        </p>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <h6>إحصائيات سريعة</h6>
                        <div class="text-sm">
                            <div class="d-flex justify-content-between mb-1">
                                <span>إجمالي أيام الحضور:</span>
                                <span>{{ $employee->attendances()->whereNotNull('check_in')->count() }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>إجمالي الساعات:</span>
                                <span>{{ number_format($employee->attendances()->sum('total_hours'), 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>التقارير المُنشأة:</span>
                                <span>{{ $employee->salaryReports()->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('employees.show', $employee) }}" class="btn btn-outline-info btn-sm">
                            عرض التفاصيل الكاملة
                        </a>
                        <a href="{{ route('hr.attendance', ['employee_id' => $employee->id]) }}" class="btn btn-outline-primary btn-sm">
                            تسجيل حضور/انصراف
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const defaultSalaryInput = document.getElementById('default_salary');
    const hourlyRateInput = document.getElementById('hourly_rate');
    const workingHoursInput = document.getElementById('working_hours_per_day');
    
    // Auto-calculate hourly rate based on default salary
    defaultSalaryInput.addEventListener('input', function() {
        const defaultSalary = parseFloat(this.value) || 0;
        const workingHours = parseInt(workingHoursInput.value) || 8;
        const workingDaysPerMonth = 26; // Assuming 26 working days per month
        
        if (defaultSalary > 0) {
            const hourlyRate = defaultSalary / (workingDaysPerMonth * workingHours);
            // Only update if hourly rate is empty or user confirms
           
                hourlyRateInput.value = hourlyRate.toFixed(2);
        }
    });
});
</script>
@endsection
