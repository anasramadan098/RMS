@extends('layouts.app')
@section('page_name', __('app.hr.hr_system'))

@section('content')
<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span class="alert-icon"><i class="fa fa-check"></i></span>
        <span class="alert-text">{{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span class="alert-icon"><i class="fa fa-exclamation-triangle"></i></span>
        <span class="alert-text">{{ session('error') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>{{ __('app.hr.hr_system') }}</h6>
                    <div class="d-flex gap-2">
                        <a href="{{ route('hr.attendance') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-clock me-1"></i>
                            {{ __('app.hr.record_attendance') }}
                        </a>
                        <a href="{{ route('employees.create') }}" class="btn btn-success btn-sm">
                            <i class="fa fa-plus me-1"></i>
                            {{ __('app.hr.add_employee') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">{{ __('app.hr.employees') }}</p>
                                <h5 class="font-weight-bolder mb-0">{{ $employees->count() }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fa fa-users text-lg opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">حضور اليوم</p>
                                <h5 class="font-weight-bolder mb-0">{{ $todayAttendance->count() }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                <i class="fa fa-check text-lg opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">تقارير الشهر</p>
                                <h5 class="font-weight-bolder mb-0">{{ $salaryReports->count() }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                <i class="fa fa-file-alt text-lg opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">إجمالي المرتبات</p>
                                <h5 class="font-weight-bolder mb-0">{{ number_format($salaryReports->sum('final_salary'), 2) }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                <i class="fa fa-money-bill text-lg opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Employees Table -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h6>{{ __('app.hr.employees') }}</h6>
                    <a href="{{ route('employees.index') }}" class="btn btn-outline-primary btn-sm">عرض الكل</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.hr.employee_name') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('app.hr.default_salary') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.hr.hourly_rate') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.status') }}</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employees->take(5) as $employee)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $employee->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $employee->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ number_format($employee->default_salary, 2) }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-secondary text-xs font-weight-bold">{{ number_format($employee->hourly_rate, 2) }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="badge badge-sm bg-gradient-{{ $employee->is_active ? 'success' : 'secondary' }}">
                                            {{ $employee->is_active ? __('app.active') : __('app.inactive') }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('employees.show', $employee) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="{{ __('users.actions.view') }}">
                                            {{ __('app.view') }}
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">{{ __('app.no_data') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Attendance and Salary Reports -->
    <div class="row">
        <!-- Today's Attendance -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h6>{{ __('app.hr.attendance') }} - اليوم</h6>
                    <a href="{{ route('hr.attendance') }}" class="btn btn-outline-primary btn-sm">عرض الكل</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الموظف</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">الدخول</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الخروج</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الساعات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($todayAttendance->take(5) as $attendance)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $attendance->employee->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $attendance->formatted_check_in ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $attendance->formatted_check_out ?? '-' }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $attendance->total_hours ?? '-' }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">لا يوجد حضور اليوم</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Month Salary Reports -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h6>{{ __('app.hr.salary_reports') }} - الشهر الحالي</h6>
                    <a href="{{ route('hr.salary-reports') }}" class="btn btn-outline-primary btn-sm">عرض الكل</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الموظف</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">أيام الحضور</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الساعات</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الراتب</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($salaryReports->take(5) as $report)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $report->employee->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $report->attendance_days }}/{{ $report->days_in_month }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $report->actual_hours }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ number_format($report->final_salary, 2) }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">لا توجد تقارير للشهر الحالي</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
