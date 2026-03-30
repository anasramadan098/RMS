<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Attendance;
use App\Models\SalaryReport;
use App\Enums\UserRole;
use Carbon\Carbon;

class EmployeeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample employee users
        $employees = [
            [
                'name' => 'أحمد محمد علي',
                'email' => 'ahmed@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'role' => UserRole::EMPLOYEE,
                'phone' => '01234567890',
                'default_salary' => 5000.00,
                'hourly_rate' => 25.00,
                'working_hours_per_day' => 8,
                'is_active' => true,
                'notes' => 'موظف متميز في خدمة العملاء'
            ],
            [
                'name' => 'فاطمة أحمد حسن',
                'email' => 'fatma@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'role' => UserRole::EMPLOYEE,
                'phone' => '01234567891',
                'default_salary' => 4500.00,
                'hourly_rate' => 22.50,
                'working_hours_per_day' => 8,
                'is_active' => true,
                'notes' => 'مسؤولة الكاشير الرئيسية'
            ],
            [
                'name' => 'محمد عبد الله',
                'email' => 'mohamed@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'role' => UserRole::EMPLOYEE,
                'phone' => '01234567892',
                'default_salary' => 4000.00,
                'hourly_rate' => 20.00,
                'working_hours_per_day' => 8,
                'is_active' => true,
                'notes' => 'طباخ مساعد'
            ],
            [
                'name' => 'سارة محمود',
                'email' => 'sara@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'role' => UserRole::EMPLOYEE,
                'phone' => '01234567893',
                'default_salary' => 3500.00,
                'hourly_rate' => 17.50,
                'working_hours_per_day' => 6,
                'is_active' => true,
                'notes' => 'موظفة تنظيف وترتيب'
            ],
            [
                'name' => 'خالد أحمد',
                'email' => 'khaled@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'role' => UserRole::EMPLOYEE,
                'phone' => '01234567894',
                'default_salary' => 3000.00,
                'hourly_rate' => 15.00,
                'working_hours_per_day' => 8,
                'is_active' => false,
                'notes' => 'موظف سابق - تم إنهاء الخدمة'
            ]
        ];

        foreach ($employees as $employeeData) {
            $employee = User::create($employeeData);

            // Create sample attendance records for the last 30 days
            if ($employee->is_active) {
                $this->createSampleAttendance($employee);
            }
        }

        // Generate salary reports for current month
        $activeEmployees = User::activeEmployees()->get();
        foreach ($activeEmployees as $employee) {
            SalaryReport::generateForEmployee($employee, Carbon::now()->year, Carbon::now()->month);
        }
    }

    /**
     * Create sample attendance records for an employee
     */
    private function createSampleAttendance(User $employee)
    {
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        while ($startDate->lte($endDate)) {
            // Skip Fridays (weekend)
            if ($startDate->dayOfWeek !== Carbon::FRIDAY) {
                // 90% chance of attendance
                if (rand(1, 100) <= 90) {
                    $checkIn = $startDate->copy()->setTime(8, rand(0, 30), 0); // 8:00-8:30 AM
                    $checkOut = $startDate->copy()->setTime(16 + rand(0, 2), rand(0, 59), 0); // 4:00-6:59 PM
                    
                    $attendance = Attendance::create([
                        'employee_id' => $employee->id,
                        'date' => $startDate->toDateString(),
                        'check_in' => $checkIn->format('H:i:s'),
                        'check_out' => $checkOut->format('H:i:s'),
                    ]);
                    
                    $attendance->calculateTotalHours();
                }
            }
            
            $startDate->addDay();
        }
    }
}
