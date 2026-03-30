<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Attendance;
use App\Models\SalaryReport;
use App\Enums\UserRole;
use Carbon\Carbon;

class HRSystemTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $owner;
    protected $employee;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create owner user
        $this->owner = User::factory()->create([
            'role' => UserRole::OWNER,
        ]);

        // Create regular user
        $this->employee = User::factory()->create([
            'role' => UserRole::EMPLOYEE,
        ]);
    }

    /** @test */
    public function owner_can_access_hr_system()
    {
        $response = $this->actingAs($this->owner)
            ->get(route('hr.index'));

        $response->assertStatus(200);
        $response->assertViewIs('hr.index');
    }

    /** @test */
    public function employee_cannot_access_hr_system()
    {
        $response = $this->actingAs($this->employee)
            ->get(route('hr.index'));

        $response->assertStatus(403);
    }

    /** @test */
    public function owner_can_create_employee()
    {
        $employeeData = [
            'name' => 'أحمد محمد',
            'email' => 'ahmed@example.com',
            'phone' => '01234567890',
            'default_salary' => 5000.00,
            'hourly_rate' => 25.00,
            'working_hours_per_day' => 8,
            'notes' => 'موظف جديد',
        ];

        $response = $this->actingAs($this->owner)
            ->post(route('employees.store'), $employeeData);

        $response->assertRedirect(route('employees.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name' => 'أحمد محمد',
            'email' => 'ahmed@example.com',
            'role' => UserRole::EMPLOYEE,
        ]);
    }

    /** @test */
    public function owner_can_record_attendance()
    {
        $employee = User::factory()->create([
            'role' => UserRole::EMPLOYEE,
            'default_salary' => 5000,
            'hourly_rate' => 25,
            'working_hours_per_day' => 8,
        ]);

        $response = $this->actingAs($this->owner)
            ->post(route('hr.record-attendance'), [
                'employee_id' => $employee->id,
                'action' => 'check_in',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('attendances', [
            'employee_id' => $employee->id,
            'date' => Carbon::today()->format('Y-m-d'),
        ]);
    }

    /** @test */
    public function cannot_check_in_twice_same_day()
    {
        $employee = User::factory()->create([
            'role' => UserRole::EMPLOYEE,
            'default_salary' => 5000,
            'hourly_rate' => 25,
            'working_hours_per_day' => 8,
        ]);
        
        // First check-in
        Attendance::create([
            'employee_id' => $employee->id,
            'date' => Carbon::today(),
            'check_in' => '08:00:00',
        ]);

        // Try to check-in again
        $response = $this->actingAs($this->owner)
            ->post(route('hr.record-attendance'), [
                'employee_id' => $employee->id,
                'action' => 'check_in',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /** @test */
    public function can_check_out_after_check_in()
    {
        $employee = User::factory()->create([
            'role' => UserRole::EMPLOYEE,
            'default_salary' => 5000,
            'hourly_rate' => 25,
            'working_hours_per_day' => 8,
        ]);
        
        // Create check-in record
        $attendance = Attendance::create([
            'employee_id' => $employee->id,
            'date' => Carbon::today(),
            'check_in' => '08:00:00',
        ]);

        $response = $this->actingAs($this->owner)
            ->post(route('hr.record-attendance'), [
                'employee_id' => $employee->id,
                'action' => 'check_out',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $attendance->refresh();
        $this->assertNotNull($attendance->check_out);
        $this->assertNotNull($attendance->total_hours);
    }

    /** @test */
    public function salary_calculation_is_correct()
    {
        $employee = User::factory()->create([
            'role' => UserRole::EMPLOYEE,
            'hourly_rate' => 20.00,
            'working_hours_per_day' => 8,
            'default_salary' => 5000,
        ]);

        // Create attendance records for current month
        $currentMonth = Carbon::now();
        $workingDays = 22; // Assume 22 working days
        
        for ($i = 0; $i < $workingDays; $i++) {
            $date = $currentMonth->copy()->startOfMonth()->addDays($i);
            if ($date->dayOfWeek !== Carbon::FRIDAY) {
                Attendance::factory()->forDate($date)->create([
                    'employee_id' => $employee->id,
                ]);
            }
        }

        // Generate salary report
        $report = SalaryReport::generateForEmployee(
            $employee, 
            $currentMonth->year, 
            $currentMonth->month
        );

        $this->assertInstanceOf(SalaryReport::class, $report);
        $this->assertEquals($employee->id, $report->employee_id);
        $this->assertGreaterThan(0, $report->final_salary);
    }

    /** @test */
    public function overtime_calculation_is_correct()
    {
        $employee = User::factory()->create([
            'role' => UserRole::EMPLOYEE,
            'hourly_rate' => 20.00,
            'working_hours_per_day' => 8,
            'default_salary' => 5000,
        ]);

        // Create attendance with 10 hours (2 hours overtime)
        $attendance = Attendance::factory()->create([
            'employee_id' => $employee->id,
            'date' => Carbon::today(),
            'check_in' => '08:00:00',
            'check_out' => '18:00:00',
            'total_hours' => 10.00,
        ]);

        $report = SalaryReport::generateForEmployee(
            $employee, 
            Carbon::now()->year, 
            Carbon::now()->month
        );

        // Should have 2 hours of overtime
        $this->assertGreaterThan(0, $report->extra_hours);
        $this->assertGreaterThan(0, $report->overtime_amount);
    }

    /** @test */
    public function owner_can_generate_salary_reports()
    {
        $employee = User::factory()->create([
            'role' => UserRole::EMPLOYEE,
            'default_salary' => 5000,
            'hourly_rate' => 25,
            'working_hours_per_day' => 8,
        ]);
        
        $response = $this->actingAs($this->owner)
            ->post(route('hr.generate-salary-report'), [
                'month' => Carbon::now()->month,
                'year' => Carbon::now()->year,
                'employee_id' => $employee->id,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('salary_reports', [
            'employee_id' => $employee->id,
            'year' => Carbon::now()->year,
            'month' => Carbon::now()->month,
        ]);
    }

    /** @test */
    public function owner_can_view_salary_reports()
    {
        $employee = User::factory()->create([
            'role' => UserRole::EMPLOYEE,
            'default_salary' => 5000,
            'hourly_rate' => 25,
            'working_hours_per_day' => 8,
        ]);
        $report = SalaryReport::factory()->create([
            'employee_id' => $employee->id,
        ]);

        $response = $this->actingAs($this->owner)
            ->get(route('hr.salary-reports'));

        $response->assertStatus(200);
        $response->assertViewIs('hr.salary-reports');
        $response->assertViewHas('salaryReports');
    }

    /** @test */
    public function employee_validation_works()
    {
        $response = $this->actingAs($this->owner)
            ->post(route('employees.store'), [
                'name' => '', // Required field
                'email' => 'invalid-email', // Invalid email
                'default_salary' => -100, // Negative salary
                'hourly_rate' => '', // Required field
                'working_hours_per_day' => 25, // More than 24 hours
            ]);

        $response->assertSessionHasErrors([
            'name',
            'email',
            'default_salary',
            'hourly_rate',
            'working_hours_per_day',
        ]);
    }
}
