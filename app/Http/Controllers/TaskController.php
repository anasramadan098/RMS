<?php

namespace App\Http\Controllers;

use App\Mail\TaskEmail;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role' , '!=' , 'owner')->get();
        return view('tasks.create' , compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:255',
            'ended_at' => 'required|date',
            'status' => 'nullable|string|max:50',
        ]);
        
        $validated['user_id'] = request('user_id');
        // tenant_id will be automatically set by BelongsToTenant trait

        // Send Mail For Employee
        $task = Task::create($validated);

        Mail::to($task->user->email)->send(new TaskEmail($task));

        return redirect()->route('tasks.index')->with('success', __('Task created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:255',
            'ended_at' => 'required|date',
            'status' => 'nullable|string|max:50',
        ]);
        $task->update($validated);
        return redirect()->route('tasks.index')->with('success', __('Task updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', __('Task deleted successfully.'));
    }

    public function toogle() {
        $task = Task::find(request('id'));
        $task->status = 'completed';
        $task->save();
        return response()->json(["success" => 'sucesss']);
    }   
}
