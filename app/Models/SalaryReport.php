<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SalaryReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'year',
        'month',
        'days_in_month',
        'attendance_days',
        'absence_days',
        'required_hours',
        'actual_hours',
        'extra_hours',
        'missing_hours',
        'base_salary',
        'overtime_amount',
        'deduction_amount',
        'final_salary',
        'notes',
    ];

    protected $casts = [
        'required_hours' => 'decimal:2',
        'actual_hours' => 'decimal:2',
        'extra_hours' => 'decimal:2',
        'missing_hours' => 'decimal:2',
        'base_salary' => 'decimal:2',
        'overtime_amount' => 'decimal:2',
        'deduction_amount' => 'decimal:2',
        'final_salary' => 'decimal:2',
    ];

    /**
     * Get the employee (user) that owns the salary report.
     */
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Get the user that owns the salary report.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Generate salary report for an employee (user) for a specific month
     */
    public static function generateForEmployee(User $employee, $year, $month)
    {
        $salaryService = app(\App\Services\SalaryCalculationService::class);
        return $salaryService->generateSalaryReport($employee, $year, $month);
    }

    /**
     * Get working days in a month (excluding Fridays)
     */
    private static function getWorkingDaysInMonth($year, $month)
    {
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();
        $workingDays = 0;

        while ($startDate->lte($endDate)) {
            // Skip Fridays (5 = Friday in Carbon)
            if ($startDate->dayOfWeek !== Carbon::FRIDAY) {
                $workingDays++;
            }
            $startDate->addDay();
        }

        return $workingDays;
    }

    /**
     * Get formatted month name
     */
    public function getMonthNameAttribute()
    {
        $months = [
            1 => 'يناير', 2 => 'فبراير', 3 => 'مارس', 4 => 'أبريل',
            5 => 'مايو', 6 => 'يونيو', 7 => 'يوليو', 8 => 'أغسطس',
            9 => 'سبتمبر', 10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر'
        ];

        return $months[$this->month] ?? '';
    }

    /**
     * Get attendance percentage
     */
    public function getAttendancePercentageAttribute()
    {
        if ($this->days_in_month == 0) return 0;
        return round(($this->attendance_days / $this->days_in_month) * 100, 2);
    }

    /**
     * Scope for current year
     */
    public function scopeCurrentYear($query)
    {
        return $query->where('year', Carbon::now()->year);
    }

    /**
     * Scope for specific year
     */
    public function scopeForYear($query, $year)
    {
        return $query->where('year', $year);
    }
}
