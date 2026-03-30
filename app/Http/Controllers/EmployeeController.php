<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Enums\UserRole;

use function PHPUnit\Framework\isArray;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the employees.
     */
    public function index()
    {
        // Global scope from BelongsToTenant will automatically filter by tenant
        $employees = User::employees()->orderBy('name')->paginate(15);
        return view('hr.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        return view('hr.employees.create');
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->validated();
        $data['role'] = UserRole::EMPLOYEE;
        $data['password'] = bcrypt('password'); // Default password
        $data['email_verified_at'] = now();
        // tenant_id will be automatically set by BelongsToTenant trait
        
        $employee = User::create($data);
        
        
        
        $files = $request->file('attachments');
        if ($files && count($files) > 0) {
            $paths = [];
            foreach ($files as $file) {
                $dir = public_path("uploads/employees/$employee->id _ $employee->name");
                // Check Of The Dir
                if (!file_exists($dir)) {
                    mkdir($dir, 0755, true);
                }

                // Handle image files
                if (in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'webp'])) {
                    $image = imagecreatefromstring($file->get());
                    $uniqeId = uniqid();
                    $filename = "$employee->name _ $uniqeId.webp";
                    $path = $dir . '/' . $filename;
                    imagewebp($image, $path, 85);
                    imagedestroy($image);
                } else {
                    // Handle other file types (PDF, etc.)
                    $uniqeId = uniqid();
                    $extension = $file->getClientOriginalExtension();
                    $filename = "$employee->name _ $uniqeId.$extension";
                    $path = $dir . '/' . $filename;
                    $file->move($dir, $filename);
                }
                
                // Store the complete path to the file, not just the directory
                $paths[] = "uploads/employees/$employee->id _ $employee->name/$filename";
            }
            
            // Save all paths at once after processing all files
            $employee->attachments = json_encode($paths);
            $employee->save();
        }



        return redirect()->route('employees.index')
            ->with('success', 'تم إضافة الموظف بنجاح');
    }

    /**
     * Display the specified employee.
     */
    public function show(User $employee)
    {
        // Ensure the user is an employee
        if (!$employee->isEmployee()) {
            abort(404);
        }

        $employee->load(['attendances' => function($query) {
            $query->orderBy('date', 'desc')->limit(30);
        }, 'salaryReports' => function($query) {
            $query->orderBy('year', 'desc')->orderBy('month', 'desc');
        }]);

        return view('hr.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(User $employee)
    {
        // Ensure the user is an employee
        if (!$employee->isEmployee()) {
            abort(404);
        }

        return view('hr.employees.edit', compact('employee'));
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(UpdateEmployeeRequest $request, User $employee)
    {
        // Ensure the user is an employee
        if (!$employee->isEmployee()) {
            abort(404);
        }

        $attachments =  json_decode( $employee->attachments  , true);

        $employee->update($request->validated());
          

        if ($request->hasFile('attachments')) {
            // Get existing attachments if any
            
            foreach ($request->file('attachments') as $file) {
                $dir = public_path("uploads/employees/$employee->id _ $employee->name");
                // Check Of The Dir
                if (!file_exists($dir)) {
                    mkdir($dir, 0755, true);
                }

                // Handle image files
                if (in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'webp'])) {
                    $image = imagecreatefromstring($file->get());
                    $uniqeId = uniqid();
                    $filename = "$employee->name _ $uniqeId.webp";
                    $path = $dir . '/' . $filename;
                    imagewebp($image, $path, 85);
                    imagedestroy($image);
                } else {
                    // Handle other file types (PDF, etc.)
                    $uniqeId = uniqid();
                    $extension = $file->getClientOriginalExtension();
                    $filename = "$employee->name _ $uniqeId.$extension";
                    $path = $dir . '/' . $filename;
                    $file->move($dir, $filename);
                }
                
                // Store the complete path to the file, not just the directory
                $attachments[] = "uploads/employees/$employee->id _ $employee->name/$filename";
            }
            
            // Merge existing and new paths, then save all at once
            $attachments = array_filter($attachments , function($path) {
                return is_string($path);
            });
            $employee->attachments = json_encode($attachments);
            $employee->save();
        }


        return redirect()->route('employees.index')
            ->with('success', 'تم تحديث بيانات الموظف بنجاح');
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroy(User $employee)
    {
        // Ensure the user is an employee
        if (!$employee->isEmployee()) {
            abort(404);
        }

        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'تم حذف الموظف بنجاح');
    }

    /**
     * Toggle employee active status
     */
    public function toggleStatus(User $employee)
    {
        // Ensure the user is an employee
        if (!$employee->isEmployee()) {
            abort(404);
        }

        $employee->update(['is_active' => !$employee->is_active]);

        $status = $employee->is_active ? 'تم تفعيل' : 'تم إلغاء تفعيل';

        return redirect()->back()
            ->with('success', $status . ' الموظف بنجاح');
    }
}
