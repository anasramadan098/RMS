<?php

namespace App\Services;

use App\Models\User;
use App\Models\SalaryReport;
use Carbon\Carbon;

class SalaryCalculationService
{
    /**
     * Calculate salary for an employee (user) for a specific month
     */
    public function calculateSalary(User $employee, int $year, int $month): array
    {
        // Get days in month
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;
        
        // Get attendance data for the month
        $attendances = $employee->attendances()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        $attendanceDays = $attendances->where('check_in', '!=', null)->count();
        $absenceDays = $this->getWorkingDaysInMonth($year, $month) - $attendanceDays;
        $actualHours = $attendances->sum('total_hours');
        
        // Calculate required hours (working days * hours per day)
        $workingDays = $this->getWorkingDaysInMonth($year, $month);
        $requiredHours = $workingDays * $employee->working_hours_per_day;
        
        // Calculate extra and missing hours
        $extraHours = max(0, $actualHours - $requiredHours);
        $missingHours = max(0, $requiredHours - $actualHours);
        
        // Calculate salary components
        $baseSalary = $employee->default_salary;
        $overtimeAmount = $extraHours * $employee->hourly_rate * 1.25; // 25% extra for overtime
        $deductionAmount = $missingHours * $employee->hourly_rate;
        
        // Final salary calculation: (actual_hours × hourly_rate) + (extra_hours × hourly_rate × 1.25) - (missing_hours × hourly_rate)
        $finalSalary = ($actualHours * $employee->hourly_rate) + ($extraHours * $employee->hourly_rate * 0.25) - ($missingHours * $employee->hourly_rate);
        
        return [
            'days_in_month' => $daysInMonth,
            'attendance_days' => $attendanceDays,
            'absence_days' => max(0, $absenceDays),
            'required_hours' => $requiredHours,
            'actual_hours' => $actualHours,
            'extra_hours' => $extraHours,
            'missing_hours' => $missingHours,
            'base_salary' => $baseSalary,
            'overtime_amount' => $overtimeAmount,
            'deduction_amount' => $deductionAmount,
            'final_salary' => max(0, $finalSalary), // Ensure salary is not negative
        ];
    }

    /**
     * Generate and save salary report for an employee (user)
     */
    public function generateSalaryReport(User $employee, int $year, int $month): SalaryReport
    {
        $calculation = $this->calculateSalary($employee, $year, $month);
        
        return SalaryReport::updateOrCreate(
            [
                'employee_id' => $employee->id,
                'year' => $year,
                'month' => $month,
            ],
            $calculation
        );
    }

    /**
     * Generate salary reports for all active employees
     */
    public function generateAllSalaryReports(int $year, int $month): int
    {
        $employees = User::activeEmployees()->get();
        $count = 0;

        foreach ($employees as $employee) {
            $this->generateSalaryReport($employee, $year, $month);
            $count++;
        }

        return $count;
    }

    /**
     * Get working days in a month (excluding Fridays)
     */
    private function getWorkingDaysInMonth(int $year, int $month): int
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
     * Get attendance statistics for an employee (user)
     */
    public function getAttendanceStatistics(User $employee, int $year = null, int $month = null): array
    {
        $query = $employee->attendances();

        if ($year) {
            $query->whereYear('date', $year);
        }

        if ($month) {
            $query->whereMonth('date', $month);
        }

        $attendances = $query->get();

        return [
            'total_days' => $attendances->count(),
            'present_days' => $attendances->whereNotNull('check_in')->count(),
            'absent_days' => $attendances->whereNull('check_in')->count(),
            'total_hours' => $attendances->sum('total_hours'),
            'average_hours_per_day' => $attendances->whereNotNull('total_hours')->avg('total_hours'),
            'earliest_check_in' => $attendances->whereNotNull('check_in')->min('check_in'),
            'latest_check_out' => $attendances->whereNotNull('check_out')->max('check_out'),
        ];
    }

    /**
     * Calculate overtime hours for an employee (user) in a specific period
     */
    public function calculateOvertime(User $employee, Carbon $startDate, Carbon $endDate): float
    {
        $attendances = $employee->attendances()
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $totalHours = $attendances->sum('total_hours');
        $workingDays = $this->getWorkingDaysBetween($startDate, $endDate);
        $requiredHours = $workingDays * $employee->working_hours_per_day;

        return max(0, $totalHours - $requiredHours);
    }

    /**
     * Get working days between two dates (excluding Fridays)
     */
    private function getWorkingDaysBetween(Carbon $startDate, Carbon $endDate): int
    {
        $workingDays = 0;
        $current = $startDate->copy();

        while ($current->lte($endDate)) {
            if ($current->dayOfWeek !== Carbon::FRIDAY) {
                $workingDays++;
            }
            $current->addDay();
        }

        return $workingDays;
    }

    /**
     * Get salary breakdown for display
     */
    public function getSalaryBreakdown(SalaryReport $report): array
    {
        return [
            'base_calculation' => [
                'actual_hours' => $report->actual_hours,
                'hourly_rate' => $report->employee->hourly_rate,
                'base_amount' => $report->actual_hours * $report->employee->hourly_rate,
            ],
            'overtime_calculation' => [
                'extra_hours' => $report->extra_hours,
                'overtime_rate' => $report->employee->hourly_rate * 1.25,
                'overtime_amount' => $report->overtime_amount,
            ],
            'deduction_calculation' => [
                'missing_hours' => $report->missing_hours,
                'hourly_rate' => $report->employee->hourly_rate,
                'deduction_amount' => $report->deduction_amount,
            ],
            'final_calculation' => [
                'gross_salary' => ($report->actual_hours * $report->employee->hourly_rate) + $report->overtime_amount,
                'deductions' => $report->deduction_amount,
                'net_salary' => $report->final_salary,
            ],
        ];
    }
}
