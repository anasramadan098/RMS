<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'employee_id',
        'date',
        'check_in',
        'check_out',
        'total_hours',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime:H:i',
        'check_out' => 'datetime:H:i',
        'total_hours' => 'decimal:2',
    ];

    /**
     * Get the employee (user) that owns the attendance.
     */
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Get the user that owns the attendance.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Calculate total hours worked
     */
    public function calculateTotalHours()
    {
        if ($this->check_in && $this->check_out) {
            $checkIn = Carbon::parse($this->check_in);
            $checkOut = Carbon::parse($this->check_out);
            
            // Calculate difference in hours
            $totalMinutes = $checkOut->diffInMinutes($checkIn);
            $totalHours = $totalMinutes / 60;
            
            $this->total_hours = round($totalHours, 2);
            $this->save();
            
            return $this->total_hours;
        }
        
        return 0;
    }

    /**
     * Check if attendance is complete (has both check in and check out)
     */
    public function isComplete()
    {
        return $this->check_in && $this->check_out;
    }

    /**
     * Get formatted check in time
     */
    public function getFormattedCheckInAttribute()
    {
        return $this->check_in ? Carbon::parse($this->check_in)->format('H:i') : null;
    }

    /**
     * Get formatted check out time
     */
    public function getFormattedCheckOutAttribute()
    {
        return $this->check_out ? Carbon::parse($this->check_out)->format('H:i') : null;
    }

    /**
     * Get status of attendance
     */
    public function getStatusAttribute()
    {
        if (!$this->check_in) {
            return 'غير مسجل';
        } elseif (!$this->check_out) {
            return 'في العمل';
        } else {
            return 'مكتمل';
        }
    }

    /**
     * Scope for today's attendance
     */
    public function scopeToday($query)
    {
        return $query->where('date', Carbon::today());
    }

    /**
     * Scope for current month attendance
     */
    public function scopeCurrentMonth($query)
    {
        return $query->whereMonth('date', Carbon::now()->month)
                    ->whereYear('date', Carbon::now()->year);
    }

    /**
     * Scope for specific month attendance
     */
    public function scopeForMonth($query, $year, $month)
    {
        return $query->whereYear('date', $year)
                    ->whereMonth('date', $month);
    }
}
