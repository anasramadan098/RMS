<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\SalaryReport;
use App\Services\SalaryCalculationService;
use Carbon\Carbon;
use App\Enums\UserRole;

class GenerateMonthlySalaryReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hr:generate-salary-reports 
                            {--month= : The month to generate reports for (1-12)}
                            {--year= : The year to generate reports for}
                            {--employee= : Generate report for specific employee ID}
                            {--force : Force regenerate existing reports}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate monthly salary reports for employees';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $month = $this->option('month') ?? Carbon::now()->subMonth()->month;
        $year = $this->option('year') ?? Carbon::now()->subMonth()->year;
        $employeeId = $this->option('employee');
        $force = $this->option('force');

        $this->info("Generating salary reports for {$month}/{$year}...");

        $salaryService = app(SalaryCalculationService::class);

        if ($employeeId) {
            // Generate for specific employee
            $employee = User::find($employeeId);
            if (!$employee) {
                $this->error("Employee with ID {$employeeId} not found.");
                return 1;
            }

            if (!$employee->is_active) {
                $this->warn("Employee {$employee->name} is not active.");
                if (!$this->confirm('Do you want to continue?')) {
                    return 0;
                }
            }

            $this->generateForEmployee($employee, $year, $month, $force, $salaryService);
        } else {
            // Generate for all active employees
            $employees = User::activeEmployees()->get();
            
            if ($employees->isEmpty()) {
                $this->warn('No active employees found.');
                return 0;
            }

            $this->info("Found {$employees->count()} active employees.");

            $progressBar = $this->output->createProgressBar($employees->count());
            $progressBar->start();

            $generated = 0;
            $skipped = 0;

            foreach ($employees as $employee) {
                $result = $this->generateForEmployee($employee, $year, $month, $force, $salaryService);
                if ($result) {
                    $generated++;
                } else {
                    $skipped++;
                }
                $progressBar->advance();
            }

            $progressBar->finish();
            $this->newLine();

            $this->info("Reports generated: {$generated}");
            if ($skipped > 0) {
                $this->warn("Reports skipped: {$skipped}");
            }
        }

        $this->info('Salary report generation completed!');
        return 0;
    }

    /**
     * Generate salary report for a specific employee
     */
    private function generateForEmployee(User $employee, int $year, int $month, bool $force, SalaryCalculationService $salaryService): bool
    {
        // Check if report already exists
        $existingReport = SalaryReport::where('employee_id', $employee->id)
            ->where('year', $year)
            ->where('month', $month)
            ->first();

        if ($existingReport && !$force) {
            $this->warn("Report for {$employee->name} already exists. Use --force to regenerate.");
            return false;
        }

        try {
            $report = $salaryService->generateSalaryReport($employee, $year, $month);
            
            $action = $existingReport ? 'Updated' : 'Generated';
            $this->line("{$action} report for {$employee->name}: {$report->final_salary} EGP");
            
            return true;
        } catch (\Exception $e) {
            $this->error("Failed to generate report for {$employee->name}: {$e->getMessage()}");
            return false;
        }
    }
}
