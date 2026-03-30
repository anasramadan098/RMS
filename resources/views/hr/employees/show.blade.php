@extends('layouts.app')
@section('page_name', $employee->name)

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>تفاصيل الموظف - {{ $employee->name }}</h6>
                    <div class="d-flex gap-2">
                        <a href="{{ route('hr.attendance', ['employee_id' => $employee->id]) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-clock me-1"></i>
                            تسجيل حضور/انصراف
                        </a>
                        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-warning btn-sm">
                            <i class="fa fa-edit me-1"></i>
                            {{ __('app.edit') }}
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

    <!-- Employee Info -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>المعلومات الأساسية</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">الاسم</small>
                        <p class="mb-0 font-weight-bold">{{ $employee->name }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">البريد الإلكتروني</small>
                        <p class="mb-0">{{ $employee->email }}</p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">رقم الهاتف</small>
                        <p class="mb-0">{{ $employee->phone ?? '-' }}</p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">الحالة</small>
                        <p class="mb-0">
                            <span class="badge bg-{{ $employee->is_active ? 'success' : 'secondary' }}">
                                {{ $employee->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                        </p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">تاريخ الانضمام</small>
                        <p class="mb-0">{{ $employee->created_at->format('Y-m-d') }}</p>
                    </div>

                    @if($employee->notes)
                    <div class="mb-3">
                        <small class="text-muted">ملاحظات</small>
                        <p class="mb-0">{{ $employee->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>معلومات الراتب</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">{{ __('app.hr.default_salary') }}</small>
                        <p class="mb-0 font-weight-bold text-primary">{{ number_format($employee->default_salary, 2) }} جنيه</p>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">{{ __('app.hr.hourly_rate') }}</small>
                        <p class="mb-0 font-weight-bold text-success">{{ number_format($employee->hourly_rate, 2) }} جنيه</p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">{{ __('app.hr.working_hours_per_day') }}</small>
                        <p class="mb-0">{{ $employee->working_hours_per_day }} ساعة</p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">معدل الساعات الإضافية</small>
                        <p class="mb-0">{{ number_format($employee->hourly_rate * 1.25, 2) }} جنيه (1.25x)</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>إحصائيات عامة</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">إجمالي أيام الحضور</small>
                        <p class="mb-0 font-weight-bold">{{ $employee->attendances()->whereNotNull('check_in')->count() }} يوم</p>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">إجمالي الساعات المسجلة</small>
                        <p class="mb-0 font-weight-bold">{{ number_format($employee->attendances()->sum('total_hours'), 2) }} ساعة</p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">عدد التقارير المُنشأة</small>
                        <p class="mb-0">{{ $employee->salaryReports()->count() }} تقرير</p>
                    </div>

                    @php
                        $todayAttendance = $employee->getTodayAttendance();
                    @endphp
                    <div class="mb-3">
                        <small class="text-muted">حالة اليوم</small>
                        <p class="mb-0">
                            @if(!$todayAttendance || !$todayAttendance->check_in)
                                <span class="badge bg-secondary">لم يسجل دخول</span>
                            @elseif(!$todayAttendance->check_out)
                                <span class="badge bg-warning">في العمل</span>
                            @else
                                <span class="badge bg-success">انتهى العمل</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Attendance -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>آخر 10 أيام حضور</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.hr.date') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.hr.check_in') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.hr.check_out') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.hr.total_hours') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الحالة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employee->attendances->take(10) as $attendance)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $attendance->date->format('Y-m-d') }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $attendance->date->format('l') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $attendance->formatted_check_in ?? '-' }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $attendance->formatted_check_out ?? '-' }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            {{ $attendance->total_hours ? number_format($attendance->total_hours, 2) : '-' }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        @if(!$attendance->check_in)
                                            <span class="badge badge-sm bg-gradient-secondary">غير مسجل</span>
                                        @elseif(!$attendance->check_out)
                                            <span class="badge badge-sm bg-gradient-warning">في العمل</span>
                                        @else
                                            <span class="badge badge-sm bg-gradient-success">مكتمل</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fa fa-clock fa-2x mb-2"></i>
                                            <p>لا يوجد سجل حضور</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Salary Reports -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>تقارير المرتبات</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الشهر/السنة</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">أيام الحضور</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الساعات الفعلية</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الساعات الإضافية</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الراتب النهائي</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employee->salaryReports as $report)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $report->month_name }} {{ $report->year }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $report->attendance_days }}/{{ $report->days_in_month }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ number_format($report->actual_hours, 2) }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-{{ $report->extra_hours > 0 ? 'success' : 'secondary' }} text-xs font-weight-bold">
                                            {{ number_format($report->extra_hours, 2) }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-primary text-xs font-weight-bold">{{ number_format($report->final_salary, 2) }} جنيه</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fa fa-file-alt fa-2x mb-2"></i>
                                            <p>لا توجد تقارير مرتبات</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Attachments Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>المرفقات والصور</h6>
                </div>
                <div class="card-body">
                    @if($employee->attachments && count ( json_decode($employee->attachments , true) ) > 0)
                        <div class="row g-3">
                            @foreach(json_decode($employee->attachments) as $index => $attachment)
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="card h-100 shadow-sm">
                                            <div class="position-relative">
                                                <img src="{{ asset($attachment) }}" 
                                                     class="card-img-top" 
                                                     alt='Employee Image'
                                                     style="height: 200px; object-fit: cover; cursor: pointer;"
                                                     data-bs-toggle="modal" 
                                                     data-bs-target="#imageModal-{{$index}}">
                                                <div class="position-absolute top-0 end-0 p-2">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Image Modal -->
                                        <div class="modal fade" id="imageModal-{{$index}}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{ 'صورة الموظف' }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset( $attachment) }}" 
                                                             class="img-fluid" 
                                                             alt="{{ 'Employee Image' }}">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="{{ asset( $attachment) }}" 
                                                           download="{{ asset( $attachment) }}" 
                                                           class="btn btn-primary">
                                                            <i class="fa fa-download me-1"></i>
                                                            تحميل الصورة
                                                        </a>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="text-muted">
                                <i class="fa fa-image fa-3x mb-3"></i>
                                <h5>لا توجد صور مرفقة</h5>
                                <p class="mb-0">لم يتم رفع أي صور لهذا الموظف</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
