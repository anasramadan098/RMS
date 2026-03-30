@extends('layouts.app')
@section('page_name', __('app.hr.add_employee'))

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>{{ __('app.hr.add_employee') }}</h6>
                    <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fa fa-arrow-left me-1"></i>
                        {{ __('app.back') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Employee Form -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>بيانات الموظف</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('employees.store') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ __('app.hr.employee_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
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
                                           id="phone" name="phone" value="{{ old('phone') }}">
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
                                           value="{{ old('working_hours_per_day', 8) }}" min="1" max="24" required>
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
                                           id="default_salary" name="default_salary" value="{{ old('default_salary') }}" 
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
                                           id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate') }}" 
                                           step="0.01" min="0" required>
                                    @error('hourly_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                        </div>

                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">ملاحظات</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
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
                                {{ __('app.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Salary Calculation Info -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>{{ __('app.hr.salary_calculation') }}</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6 class="text-white">معادلة حساب الراتب:</h6>
                        <p class="text-white mb-2">
                            <strong>الراتب النهائي = (الساعات الفعلية × قيمة الساعة) + (الساعات الإضافية × قيمة الساعة × 1.25) - (الساعات الناقصة × قيمة الساعة)</strong>
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6>ملاحظات مهمة:</h6>
                        <ul class="text-sm">
                            <li>الراتب الافتراضي يُستخدم كمرجع فقط</li>
                            <li>الحساب الفعلي يعتمد على الساعات المسجلة</li>
                            <li>{{ __('app.hr.overtime_rate') }}</li>
                            <li>يتم خصم قيمة الساعات الناقصة</li>
                            <li>أيام الجمعة لا تُحسب كأيام عمل</li>
                        </ul>
                    </div>

                    <div class="calculator-preview" id="salaryCalculator">
                        <h6>معاينة الحساب:</h6>
                        <div class="text-sm">
                            <div class="d-flex justify-content-between">
                                <span>الراتب الافتراضي:</span>
                                <span id="previewDefaultSalary">0.00 جنيه</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>قيمة الساعة:</span>
                                <span id="previewHourlyRate">0.00 جنيه</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>ساعات العمل اليومية:</span>
                                <span id="previewWorkingHours">8 ساعة</span>
                            </div>
                        </div>
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
    
    function updatePreview() {
        const defaultSalary = parseFloat(defaultSalaryInput.value) || 0;
        const hourlyRate = parseFloat(hourlyRateInput.value) || 0;
        const workingHours = parseInt(workingHoursInput.value) || 8;
        
        document.getElementById('previewDefaultSalary').textContent = defaultSalary.toFixed(2) + ' جنيه';
        document.getElementById('previewHourlyRate').textContent = hourlyRate.toFixed(2) + ' جنيه';
        document.getElementById('previewWorkingHours').textContent = workingHours + ' ساعة';
    }
    
    defaultSalaryInput.addEventListener('input', updatePreview);
    hourlyRateInput.addEventListener('input', updatePreview);
    workingHoursInput.addEventListener('input', updatePreview);
    
    // Auto-calculate hourly rate based on default salary
    defaultSalaryInput.addEventListener('input', function() {
        const defaultSalary = parseFloat(this.value) || 0;
        const workingHours = parseInt(workingHoursInput.value) || 8;
        const workingDaysPerMonth = 26; // Assuming 26 working days per month
        
        if (defaultSalary > 0) {
            const hourlyRate = defaultSalary / (workingDaysPerMonth * workingHours);
            hourlyRateInput.value = hourlyRate.toFixed(2);
            updatePreview();
        }
    });

    updatePreview();
});
</script>
@endsection
