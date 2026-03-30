<?php

namespace Database\Factories;

use App\Models\SalaryReport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SalaryReport>
 */
class SalaryReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalaryReport::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $year = $this->faker->numberBetween(2023, 2025);
        $month = $this->faker->numberBetween(1, 12);
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;
        
        $attendanceDays = $this->faker->numberBetween(20, 26);
        $absenceDays = max(0, 26 - $attendanceDays); // Assuming 26 working days
        
        $workingHoursPerDay = 8;
        $requiredHours = $attendanceDays * $workingHoursPerDay;
        $actualHours = $this->faker->randomFloat(2, $requiredHours - 20, $requiredHours + 30);
        
        $extraHours = max(0, $actualHours - $requiredHours);
        $missingHours = max(0, $requiredHours - $actualHours);
        
        $hourlyRate = $this->faker->randomFloat(2, 15, 50);
        $baseSalary = $this->faker->randomFloat(2, 3000, 8000);
        $overtimeAmount = $extraHours * $hourlyRate * 1.25;
        $deductionAmount = $missingHours * $hourlyRate;
        
        $finalSalary = ($actualHours * $hourlyRate) + ($extraHours * $hourlyRate * 0.25) - ($missingHours * $hourlyRate);
        $finalSalary = max(0, $finalSalary);

        return [
            'employee_id' => User::factory(),
            'year' => $year,
            'month' => $month,
            'days_in_month' => $daysInMonth,
            'attendance_days' => $attendanceDays,
            'absence_days' => $absenceDays,
            'required_hours' => $requiredHours,
            'actual_hours' => $actualHours,
            'extra_hours' => $extraHours,
            'missing_hours' => $missingHours,
            'base_salary' => $baseSalary,
            'overtime_amount' => $overtimeAmount,
            'deduction_amount' => $deductionAmount,
            'final_salary' => $finalSalary,
            'notes' => $this->faker->optional(0.3)->sentence(),
        ];
    }

    /**
     * Create a report for current month.
     */
    public function currentMonth(): static
    {
        return $this->state(fn (array $attributes) => [
            'year' => Carbon::now()->year,
            'month' => Carbon::now()->month,
        ]);
    }

    /**
     * Create a report for last month.
     */
    public function lastMonth(): static
    {
        $lastMonth = Carbon::now()->subMonth();
        
        return $this->state(fn (array $attributes) => [
            'year' => $lastMonth->year,
            'month' => $lastMonth->month,
        ]);
    }

    /**
     * Create a report with perfect attendance.
     */
    public function perfectAttendance(): static
    {
        return $this->state(function (array $attributes) {
            $workingDays = 26;
            $workingHoursPerDay = 8;
            $requiredHours = $workingDays * $workingHoursPerDay;
            $actualHours = $requiredHours;
            $hourlyRate = 25.00;
            
            return [
                'attendance_days' => $workingDays,
                'absence_days' => 0,
                'required_hours' => $requiredHours,
                'actual_hours' => $actualHours,
                'extra_hours' => 0,
                'missing_hours' => 0,
                'overtime_amount' => 0,
                'deduction_amount' => 0,
                'final_salary' => $actualHours * $hourlyRate,
            ];
        });
    }

    /**
     * Create a report with overtime.
     */
    public function withOvertime(): static
    {
        return $this->state(function (array $attributes) {
            $workingDays = 26;
            $workingHoursPerDay = 8;
            $requiredHours = $workingDays * $workingHoursPerDay;
            $extraHours = $this->faker->randomFloat(2, 10, 40);
            $actualHours = $requiredHours + $extraHours;
            $hourlyRate = 25.00;
            
            $overtimeAmount = $extraHours * $hourlyRate * 1.25;
            $finalSalary = ($actualHours * $hourlyRate) + ($extraHours * $hourlyRate * 0.25);
            
            return [
                'attendance_days' => $workingDays,
                'absence_days' => 0,
                'required_hours' => $requiredHours,
                'actual_hours' => $actualHours,
                'extra_hours' => $extraHours,
                'missing_hours' => 0,
                'overtime_amount' => $overtimeAmount,
                'deduction_amount' => 0,
                'final_salary' => $finalSalary,
                'notes' => 'ساعات إضافية',
            ];
        });
    }

    /**
     * Create a report with absences.
     */
    public function withAbsences(): static
    {
        return $this->state(function (array $attributes) {
            $workingDays = 26;
            $attendanceDays = $this->faker->numberBetween(18, 24);
            $absenceDays = $workingDays - $attendanceDays;
            $workingHoursPerDay = 8;
            $requiredHours = $workingDays * $workingHoursPerDay;
            $actualHours = $attendanceDays * $workingHoursPerDay;
            $missingHours = $requiredHours - $actualHours;
            $hourlyRate = 25.00;
            
            $deductionAmount = $missingHours * $hourlyRate;
            $finalSalary = ($actualHours * $hourlyRate) - $deductionAmount;
            
            return [
                'attendance_days' => $attendanceDays,
                'absence_days' => $absenceDays,
                'required_hours' => $requiredHours,
                'actual_hours' => $actualHours,
                'extra_hours' => 0,
                'missing_hours' => $missingHours,
                'overtime_amount' => 0,
                'deduction_amount' => $deductionAmount,
                'final_salary' => max(0, $finalSalary),
                'notes' => 'أيام غياب',
            ];
        });
    }

    /**
     * Create a report for specific month and year.
     */
    public function forMonth(int $year, int $month): static
    {
        return $this->state(fn (array $attributes) => [
            'year' => $year,
            'month' => $month,
            'days_in_month' => Carbon::create($year, $month)->daysInMonth,
        ]);
    }
}
