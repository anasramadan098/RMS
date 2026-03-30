<?php

namespace App\Helpers;

use Carbon\Carbon;

class WorkingDaysHelper
{
    /**
     * Get working days in a month (excluding Fridays)
     */
    public static function getWorkingDaysInMonth(int $year, int $month): int
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
     * Get working days between two dates (excluding Fridays)
     */
    public static function getWorkingDaysBetween(Carbon $startDate, Carbon $endDate): int
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
     * Check if a date is a working day (not Friday)
     */
    public static function isWorkingDay(Carbon $date): bool
    {
        return $date->dayOfWeek !== Carbon::FRIDAY;
    }

    /**
     * Get all working days in a month
     */
    public static function getWorkingDaysArray(int $year, int $month): array
    {
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();
        $workingDays = [];

        while ($startDate->lte($endDate)) {
            if ($startDate->dayOfWeek !== Carbon::FRIDAY) {
                $workingDays[] = $startDate->copy();
            }
            $startDate->addDay();
        }

        return $workingDays;
    }

    /**
     * Get next working day
     */
    public static function getNextWorkingDay(Carbon $date): Carbon
    {
        $nextDay = $date->copy()->addDay();
        
        while ($nextDay->dayOfWeek === Carbon::FRIDAY) {
            $nextDay->addDay();
        }

        return $nextDay;
    }

    /**
     * Get previous working day
     */
    public static function getPreviousWorkingDay(Carbon $date): Carbon
    {
        $previousDay = $date->copy()->subDay();
        
        while ($previousDay->dayOfWeek === Carbon::FRIDAY) {
            $previousDay->subDay();
        }

        return $previousDay;
    }

    /**
     * Calculate expected working hours for a month
     */
    public static function getExpectedWorkingHours(int $year, int $month, int $hoursPerDay = 8): float
    {
        $workingDays = self::getWorkingDaysInMonth($year, $month);
        return $workingDays * $hoursPerDay;
    }

    /**
     * Get working days statistics for a month
     */
    public static function getMonthStatistics(int $year, int $month): array
    {
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();
        
        $totalDays = $startDate->daysInMonth;
        $workingDays = self::getWorkingDaysInMonth($year, $month);
        $weekends = $totalDays - $workingDays;

        return [
            'total_days' => $totalDays,
            'working_days' => $workingDays,
            'weekends' => $weekends,
            'working_percentage' => round(($workingDays / $totalDays) * 100, 2),
        ];
    }

    /**
     * Get working days remaining in current month
     */
    public static function getRemainingWorkingDays(): int
    {
        $today = Carbon::today();
        $endOfMonth = $today->copy()->endOfMonth();
        
        return self::getWorkingDaysBetween($today, $endOfMonth);
    }

    /**
     * Get working days passed in current month
     */
    public static function getPassedWorkingDays(): int
    {
        $today = Carbon::today();
        $startOfMonth = $today->copy()->startOfMonth();
        
        return self::getWorkingDaysBetween($startOfMonth, $today);
    }

    /**
     * Check if today is a working day
     */
    public static function isTodayWorkingDay(): bool
    {
        return self::isWorkingDay(Carbon::today());
    }

    /**
     * Get working hours statistics for a period
     */
    public static function getWorkingHoursStatistics(Carbon $startDate, Carbon $endDate, int $hoursPerDay = 8): array
    {
        $workingDays = self::getWorkingDaysBetween($startDate, $endDate);
        $expectedHours = $workingDays * $hoursPerDay;
        
        return [
            'working_days' => $workingDays,
            'expected_hours' => $expectedHours,
            'hours_per_day' => $hoursPerDay,
            'period_days' => $startDate->diffInDays($endDate) + 1,
        ];
    }
}
