@extends('layouts.app')
@section('page_name', __('app.hr.salary_reports'))

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>{{ __('app.hr.salary_reports') }}</h6>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#generateReportModal">
                            <i class="fa fa-plus me-1"></i>
                            {{ __('app.hr.generate_report') }}
                        </button>
                        <a href="{{ route('hr.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa fa-arrow-left me-1"></i>
                            {{ __('app.back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>{{ __('app.filter') }}</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('hr.salary-reports') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="year" class="form-label">السنة</label>
                                <select class="form-select" id="year" name="year">
                                    @for($year = 2020; $year <= 2030; $year++)
                                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="month" class="form-label">{{ __('app.hr.select_month') }}</label>
                                <select class="form-select" id="month" name="month">
                                    @php
                                        $months = [
                                            1 => 'يناير', 2 => 'فبراير', 3 => 'مارس', 4 => 'أبريل',
                                            5 => 'مايو', 6 => 'يونيو', 7 => 'يوليو', 8 => 'أغسطس',
                                            9 => 'سبتمبر', 10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر'
                                        ];
                                    @endphp
                                    @foreach($months as $num => $name)
                                        <option value="{{ $num }}" {{ $selectedMonth == $num ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="employee_id" class="form-label">{{ __('app.hr.select_employee') }}</label>
                                <select class="form-select" id="employee_id" name="employee_id">
                                    <option value="">جميع الموظفين</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ $selectedEmployee == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fa fa-search me-1"></i>
                                    {{ __('app.filter') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Salary Reports Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h6>تقارير المرتبات - {{ $months[$selectedMonth] ?? '' }} {{ $selectedYear }}</h6>
                    @if($salaryReports->count() > 0)
                        <div class="d-flex gap-2">
                            <button onclick="window.print()" class="btn btn-outline-primary btn-sm">
                                <i class="fa fa-print me-1"></i>
                                {{ __('app.hr.print_report') }}
                            </button>
                            <a href="{{ route('hr.salary-reports.export-pdf', request()->query()) }}"
                               target="_blank" class="btn btn-outline-success btn-sm">
                                <i class="fa fa-file-pdf me-1"></i>
                                {{ __('app.hr.export_pdf') }}
                            </a>
                            <button onclick="exportToExcel()" class="btn btn-outline-info btn-sm">
                                <i class="fa fa-file-excel me-1"></i>
                                تصدير Excel
                            </button>
                        </div>
                    @endif
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.hr.employee_name') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.hr.days_in_month') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.hr.attendance_days') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.hr.absence_days') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.hr.required_hours') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.hr.actual_hours') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.hr.extra_hours') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.hr.missing_hours') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.hr.final_salary') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($salaryReports as $report)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $report->employee->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $report->employee->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $report->days_in_month }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-success text-xs font-weight-bold">{{ $report->attendance_days }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-{{ $report->absence_days > 0 ? 'danger' : 'secondary' }} text-xs font-weight-bold">{{ $report->absence_days }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ number_format($report->required_hours, 2) }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ number_format($report->actual_hours, 2) }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-{{ $report->extra_hours > 0 ? 'success' : 'secondary' }} text-xs font-weight-bold">{{ number_format($report->extra_hours, 2) }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-{{ $report->missing_hours > 0 ? 'danger' : 'secondary' }} text-xs font-weight-bold">{{ number_format($report->missing_hours, 2) }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-primary text-xs font-weight-bold">{{ number_format($report->final_salary, 2) }} جنيه</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fa fa-file-alt fa-2x mb-2"></i>
                                            <p>لا توجد تقارير للفترة المحددة</p>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#generateReportModal">
                                                إنشاء تقرير جديد
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            @if($salaryReports->count() > 0)
                            <tfoot>
                                <tr class="bg-light">
                                    <td class="text-center font-weight-bold">الإجمالي</td>
                                    <td class="text-center font-weight-bold">-</td>
                                    <td class="text-center font-weight-bold text-success">{{ $salaryReports->sum('attendance_days') }}</td>
                                    <td class="text-center font-weight-bold text-danger">{{ $salaryReports->sum('absence_days') }}</td>
                                    <td class="text-center font-weight-bold">{{ number_format($salaryReports->sum('required_hours'), 2) }}</td>
                                    <td class="text-center font-weight-bold">{{ number_format($salaryReports->sum('actual_hours'), 2) }}</td>
                                    <td class="text-center font-weight-bold text-success">{{ number_format($salaryReports->sum('extra_hours'), 2) }}</td>
                                    <td class="text-center font-weight-bold text-danger">{{ number_format($salaryReports->sum('missing_hours'), 2) }}</td>
                                    <td class="text-center font-weight-bold text-primary">{{ number_format($salaryReports->sum('final_salary'), 2) }} جنيه</td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Generate Report Modal -->
<div class="modal fade" id="generateReportModal" tabindex="-1" aria-labelledby="generateReportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="generateReportModalLabel">{{ __('app.hr.generate_report') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('hr.generate-salary-report') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="generate_year" class="form-label">السنة</label>
                        <select class="form-select" id="generate_year" name="year" required>
                            @for($year = 2020; $year <= 2030; $year++)
                                <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="generate_month" class="form-label">الشهر</label>
                        <select class="form-select" id="generate_month" name="month" required>
                            @foreach($months as $num => $name)
                                <option value="{{ $num }}" {{ $num == date('n') ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="generate_employee_id" class="form-label">الموظف</label>
                        <select class="form-select" id="generate_employee_id" name="employee_id">
                            <option value="">جميع الموظفين</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('app.cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('app.hr.generate_report') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .modal, .card-header .d-flex, .navbar, .sidebar {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    .table {
        font-size: 12px;
    }
}
</style>

<script>
// Export to Excel functionality
function exportToExcel() {
    const table = document.querySelector('.table');
    const workbook = XLSX.utils.table_to_book(table, {sheet: "تقارير المرتبات"});
    const monthName = '{{ $months[$selectedMonth] ?? "" }}';
    const year = '{{ $selectedYear }}';
    const filename = `تقارير_المرتبات_${monthName}_${year}.xlsx`;

    XLSX.writeFile(workbook, filename);
}

// Auto-submit form when filters change
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.querySelector('form[method="GET"]');
    const selects = filterForm.querySelectorAll('select');

    selects.forEach(select => {
        select.addEventListener('change', function() {
            // Add a small delay to allow user to make multiple selections
            setTimeout(() => {
                filterForm.submit();
            }, 300);
        });
    });

    // Highlight current month/year
    const currentMonth = {{ date('n') }};
    const currentYear = {{ date('Y') }};
    const selectedMonth = {{ $selectedMonth }};
    const selectedYear = {{ $selectedYear }};

    if (selectedMonth === currentMonth && selectedYear === currentYear) {
        document.querySelector('.card-header h6').innerHTML += ' <span class="badge bg-primary">الشهر الحالي</span>';
    }
});

// Add loading state to generate button
document.querySelector('form[action="{{ route('hr.generate-salary-report') }}"]').addEventListener('submit', function() {
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> جاري الإنشاء...';
    submitBtn.disabled = true;
});

// Tooltip initialization
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<!-- Include XLSX library for Excel export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
@endsection
