@extends('layouts.app')
@section('page_name', __('app.hr.employees'))

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>{{ __('app.hr.employees') }}</h6>
                    <div class="d-flex gap-2">
                        <a href="{{ route('employees.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus me-1"></i>
                            {{ __('app.hr.add_employee') }}
                        </a>
                        <a href="{{ route('hr.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa fa-arrow-left me-1"></i>
                            {{ __('app.back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Employees Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>قائمة الموظفين ({{ $employees->total() }} موظف)</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.hr.employee_name') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">البريد الإلكتروني</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الهاتف</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.hr.default_salary') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.hr.hourly_rate') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ساعات العمل</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('app.status') }}</th>
                                    <th class="text-secondary opacity-7">{{ __('app.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employees as $employee)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $employee->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    انضم في {{ $employee->created_at->format('Y-m-d') }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $employee->email }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $employee->phone ?? '-' }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ number_format($employee->default_salary, 2) }} جنيه</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ number_format($employee->hourly_rate, 2) }} جنيه</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $employee->working_hours_per_day }} ساعة</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="badge badge-sm bg-gradient-{{ $employee->is_active ? 'success' : 'secondary' }}">
                                            {{ $employee->is_active ? __('app.active') : __('app.inactive') }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('employees.show', $employee) }}" class="btn btn-sm btn-outline-info" title="{{ __('users.actions.view') }}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-outline-warning" title="{{ __('users.actions.edit') }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('employees.toggle-status', $employee) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-{{ $employee->is_active ? 'secondary' : 'success' }}" 
                                                        title="{{ $employee->is_active ? __('users.actions.deactivate') : __('users.actions.activate') }}">
                                                    <i class="fa fa-{{ $employee->is_active ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="d-inline" 
                                                  onsubmit="return confirm('{{ __('hr.employees.delete_employee_confirm') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="{{ __('users.actions.delete') }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fa fa-users fa-2x mb-2"></i>
                                            <p>لا يوجد موظفين مسجلين</p>
                                            <a href="{{ route('employees.create') }}" class="btn btn-primary btn-sm">
                                                إضافة موظف جديد
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($employees->hasPages())
                <div class="card-footer">
                    {{ $employees->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
