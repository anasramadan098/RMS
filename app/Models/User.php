<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Enums\UserRole;
use App\Traits\BelongsToTenant;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, BelongsToTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'tenant_id',
        'phone',
        'default_salary',
        'hourly_rate',
        'working_hours_per_day',
        'is_active',
        'notes',
        'attachments'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function tenant() 
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'default_salary' => 'decimal:2',
            'hourly_rate' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }


    /**
     * Check if user is an owner
     */
    public function isOwner(): bool
    {
        return $this->role === UserRole::OWNER;
    }

    /**
     * Check if user is an employee
     */
    public function isEmployee(): bool
    {
        return $this->role === UserRole::EMPLOYEE;
    }

    /**
     * Check if user is an admin
     */
    // public function isAdmin(): bool
    // {
    //     return $this->role === UserRole::ADMIN;
    // }

    /**
     * Check if user is a manager
     */
    public function isManager(): bool
    {
        return $this->role === UserRole::MANAGER;
    }

    /**
     * Check if user is a cashier
     */
    public function isCashier(): bool
    {
        return $this->role === UserRole::CASHIER;
    }

    /**
     * Check if user is a kitchen staff
     */
    // public function isKitchen(): bool
    // {
    //     return $this->role === UserRole::KITCHEN;
    // }

    /**
     * Check if user is a waiter
     */
    // public function isWaiter(): bool
    // {
    //     return $this->role === UserRole::WAITER;
    // }




    /**
     * Get the attendances for the employee.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'employee_id');
    }

    /**
     * Get the salary reports for the employee.
     */
    public function salaryReports()
    {
        return $this->hasMany(SalaryReport::class, 'employee_id');
    }

    /**
     * Get attendance for a specific date
     */
    public function getAttendanceForDate($date)
    {
        return $this->attendances()->where('date', $date)->first();
    }

    /**
     * Get attendance for current month
     */
    public function getCurrentMonthAttendance()
    {
        $startOfMonth = \Carbon\Carbon::now()->startOfMonth();
        $endOfMonth = \Carbon\Carbon::now()->endOfMonth();

        return $this->attendances()
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->get();
    }

    /**
     * Calculate total working hours for a specific month
     */
    public function getTotalHoursForMonth($year, $month)
    {
        return $this->attendances()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->sum('total_hours');
    }

    /**
     * Calculate attendance days for a specific month
     */
    public function getAttendanceDaysForMonth($year, $month)
    {
        return $this->attendances()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->whereNotNull('check_in')
            ->count();
    }

    /**
     * Check if employee has checked in today
     */
    public function hasCheckedInToday()
    {
        $today = \Carbon\Carbon::today();
        $attendance = $this->getAttendanceForDate($today);
        return $attendance && $attendance->check_in;
    }

    /**
     * Check if employee has checked out today
     */
    public function hasCheckedOutToday()
    {
        $today = \Carbon\Carbon::today();
        $attendance = $this->getAttendanceForDate($today);
        return $attendance && $attendance->check_out;
    }

    /**
     * Get today's attendance record
     */
    public function getTodayAttendance()
    {
        return $this->getAttendanceForDate(\Carbon\Carbon::today());
    }

    /**
     * Scope for active employees
     */
    public function scopeActiveEmployees($query)
    {
        return $query->where('role', UserRole::EMPLOYEE)
                    ->where('is_active', true);
    }

    /**
     * Scope for all employees (active and inactive)
     */
    public function scopeEmployees($query)
    {
        return $query->where('role', UserRole::EMPLOYEE);
    }

    /**
     * Scope for owners
     */
    public function scopeOwners($query)
    {
        return $query->where('role', UserRole::OWNER);
    }

    /**
     * Get the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the orders completed by this user.
     */
    public function completedOrders()
    {
        return $this->hasMany(Order::class, 'completed_by');
    }

    /**
     * Get the tasks for the user.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
