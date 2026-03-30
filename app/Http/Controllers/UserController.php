<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Enums\UserRole;
use App\Models\Meal;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index()
    {
        // Global scope from BelongsToTenant will automatically filter by tenant
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        $roles = UserRole::cases();
        $meals = Meal::all();
        return view('users.create', compact('roles' , 'meals'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:' . implode(',', UserRole::values()),
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        // tenant_id will be automatically set by BelongsToTenant trait

        User::create($data);

        return redirect()->route('users.index')->with('msg', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        $roles = UserRole::cases();
        $meals = Meal::all();
        return view('users.edit', compact('user', 'roles' , 'meals'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:' . implode(',', UserRole::values()),
            'password' =>'nullable|min:8',
        ]);


        ;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);


        $user->meals = json_decode($request->user_meals);


        $user->save();


        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }


        return redirect()->route('users.index')->with('msg', 'User updated successfully.');
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('msg', 'User deleted successfully.');
    }
}
