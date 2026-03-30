<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use App\Models\SalaryReport;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HRController extends Controller
{
    /**
     * Display the HR system dashboard
     */
    public function index()
    {
        // Get all employees (users with employee role)
        $employees = User::activeEmployees()->get();
        
        // Get today's attendance
        $todayAttendance = Attendance::today()
            ->with('employee')
            ->orderBy('check_in', 'desc')
            ->get();
        
        // Get current month salary reports
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $salaryReports = SalaryReport::with('employee')
            ->where('year', $currentYear)
            ->where('month', $currentMonth)
            ->get();

        return view('hr.index', compact('employees', 'todayAttendance', 'salaryReports'));
    }

    /**
     * Show attendance recording page
     */
    public function attendance()
    {
        $employees = User::activeEmployees()->get();
        $todayAttendance = Attendance::today()
            ->with('employee')
            ->orderBy('check_in', 'desc')
            ->get();

        return view('hr.attendance', compact('employees', 'todayAttendance'));
    }

    /**
     * Record check-in or check-out
     */
    public function recordAttendance(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'action' => 'required|in:check_in,check_out',
        ]);

        $employee = User::findOrFail($request->employee_id);
        $today = Carbon::today();
        $now = Carbon::now();

        // Get or create today's attendance record
        $attendance = Attendance::firstOrCreate(
            [
                'employee_id' => $employee->id,
                'date' => $today,
            ]
        );

        if ($request->action === 'check_in') {
            if ($attendance->check_in) {
                return redirect()->back()->with('error', __('app.hr.already_checked_in'));
            }
            
            $attendance->check_in = $now->format('H:i:s');
            $attendance->save();
            
            return redirect()->back()->with('success', 'تم تسجيل الدخول بنجاح في ' . $now->format('H:i'));
        } else {
            if (!$attendance->check_in) {
                return redirect()->back()->with('error', __('app.hr.no_attendance_today'));
            }
            
            if ($attendance->check_out) {
                return redirect()->back()->with('error', __('app.hr.already_checked_out'));
            }
            
            $attendance->check_out = $now->format('H:i:s');
            $attendance->calculateTotalHours();
            
            return redirect()->back()->with('success', 'تم تسجيل الخروج بنجاح في ' . $now->format('H:i') . ' - إجمالي الساعات: ' . $attendance->total_hours);
        }
    }

    /**
     * Show salary reports page
     */
    public function salaryReports(Request $request)
    {
        $employees = User::activeEmployees()->get();
        $selectedMonth = $request->get('month', Carbon::now()->month);
        $selectedYear = $request->get('year', Carbon::now()->year);
        $selectedEmployee = $request->get('employee_id');

        $query = SalaryReport::with('employee')
            ->where('year', $selectedYear)
            ->where('month', $selectedMonth);

        if ($selectedEmployee) {
            $query->where('employee_id', $selectedEmployee);
        }

        $salaryReports = $query->get();

        return view('hr.salary-reports', compact(
            'employees', 
            'salaryReports', 
            'selectedMonth', 
            'selectedYear', 
            'selectedEmployee'
        ));
    }

    /**
     * Generate salary report for specific month
     */
    public function generateSalaryReport(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:2030',
            'employee_id' => 'nullable|exists:users,id',
        ]);

        $month = $request->month;
        $year = $request->year;
        $employeeId = $request->employee_id;

        if ($employeeId) {
            // Generate for specific employee
            $employee = User::findOrFail($employeeId);
            SalaryReport::generateForEmployee($employee, $year, $month);
        } else {
            // Generate for all active employees
            $employees = User::activeEmployees()->get();
            foreach ($employees as $employee) {
                SalaryReport::generateForEmployee($employee, $year, $month);
            }
        }

        return redirect()->back()->with('success', 'تم إنشاء تقارير المرتبات بنجاح');
    }

    /**
     * Export salary reports as PDF
     */
    public function exportSalaryReportsPDF(Request $request)
    {

        $selectedMonth = $request->get('month', Carbon::now()->month);
        $selectedYear = $request->get('year', Carbon::now()->year);
        $selectedEmployee = $request->get('employee_id');

        $query = SalaryReport::with('employee')
            ->where('year', $selectedYear)
            ->where('month', $selectedMonth);

        if ($selectedEmployee) {
            $query->where('employee_id', $selectedEmployee);
        }

        $salaryReports = $query->get();

        $months = [
            1 => 'يناير', 2 => 'فبراير', 3 => 'مارس', 4 => 'أبريل',
            5 => 'مايو', 6 => 'يونيو', 7 => 'يوليو', 8 => 'أغسطس',
            9 => 'سبتمبر', 10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر'
        ];

        $data = [
            'salaryReports' => $salaryReports,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'monthName' => $months[$selectedMonth] ?? '',
            'totalSalary' => $salaryReports->sum('final_salary'),
            'totalHours' => $salaryReports->sum('actual_hours'),
            'totalEmployees' => $salaryReports->count(),
            'generatedAt' => Carbon::now()->format('Y-m-d H:i:s'),
        ];

        // For now, return a simple view that can be printed
        // In a real application, you would use a PDF library like DomPDF or wkhtmltopdf
        return view('hr.salary-reports-pdf', $data);
    }
}
