@extends('layouts.app')
@section('page_name', __('app.hr.attendance'))

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
                    <h6>{{ __('app.hr.record_attendance') }}</h6>
                    <a href="{{ route('hr.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fa fa-arrow-left me-1"></i>
                        {{ __('app.back') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Form -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>{{ __('app.hr.record_attendance') }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('hr.record-attendance') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">{{ __('app.hr.select_employee') }}</label>
                            <select class="form-select" id="employee_id" name="employee_id" required>
                                <option value="">{{ __('app.hr.select_employee') }}</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">نوع التسجيل</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="action" id="check_in" value="check_in" required>
                                    <label class="form-check-label" for="check_in">
                                        {{ __('app.hr.check_in_now') }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="action" id="check_out" value="check_out" required>
                                    <label class="form-check-label" for="check_out">
                                        {{ __('app.hr.check_out_now') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-1"></i>
                                {{ __('app.hr.record_attendance') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Current Time Display -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>الوقت الحالي</h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <h2 id="current-time" class="text-primary"></h2>
                        <p id="current-date" class="text-muted"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Attendance -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>{{ __('app.hr.attendance') }} - اليوم ({{ \Carbon\Carbon::today()->format('Y-m-d') }})</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.hr.employee_name') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('app.hr.check_in') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.hr.check_out') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.hr.total_hours') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الحالة</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($todayAttendance as $attendance)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $attendance->employee->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $attendance->employee->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ $attendance->formatted_check_in ?? '-' }}
                                        </p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            {{ $attendance->formatted_check_out ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            {{ $attendance->total_hours ? number_format($attendance->total_hours, 2) . ' ساعة' : '-' }}
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
                                    <td class="align-middle">
                                        @if($attendance->check_in && !$attendance->check_out)
                                            <form action="{{ route('hr.record-attendance') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="employee_id" value="{{ $attendance->employee_id }}">
                                                <input type="hidden" name="action" value="check_out">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    تسجيل خروج
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fa fa-clock fa-2x mb-2"></i>
                                            <p>لا يوجد حضور مسجل اليوم</p>
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
</div>

<script>
function updateTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('ar-EG', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });
    const dateString = now.toLocaleDateString('ar-EG', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
    
    document.getElementById('current-time').textContent = timeString;
    document.getElementById('current-date').textContent = dateString;
}

// Update time every second
setInterval(updateTime, 1000);
updateTime(); // Initial call

// Auto-select employee based on URL parameter or last selection
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const employeeId = urlParams.get('employee_id');
    if (employeeId) {
        document.getElementById('employee_id').value = employeeId;
    }
});
</script>
@endsection
