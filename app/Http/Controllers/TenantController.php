<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::latest()->paginate(10);
        return view('tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tenants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tenants,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'subscribtion_type' => 'required|in:basic,premium,enterprise',
            'subscribtion_amount' => 'nullable|numeric|min:0',
            'is_subscribe' => 'boolean',
        ]);

        Tenant::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'subscribtion_type' => $request->subscribtion_type,
            'subscribtion_created' => now(),
            'subscribtion_amount' => $request->subscribtion_amount ?? 0,
            'is_subscribe' => $request->has('is_subscribe'),
        ]);

        return redirect()->route('tenants.index')
            ->with('success', 'Tenant created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        return view('tenants.show', compact('tenant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        return view('tenants.edit', compact('tenant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tenants,email,' . $tenant->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'subscribtion_type' => 'required|in:basic,premium,enterprise',
            'subscribtion_amount' => 'nullable|numeric|min:0',
            'is_subscribe' => 'boolean',
        ]);

        $tenant->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'subscribtion_type' => $request->subscribtion_type,
            'subscribtion_amount' => $request->subscribtion_amount ?? 0,
            'is_subscribe' => $request->has('is_subscribe'),
        ]);

        return redirect()->route('tenants.index')
            ->with('success', 'Tenant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return redirect()->route('tenants.index')
            ->with('success', 'Tenant deleted successfully.');
    }

    /**
     * Renew tenant subscription
     */
    public function renewSubscription(Tenant $tenant)
    {
        $tenant->update([
            'subscribtion_created' => now(),
            'is_subscribe' => true,
        ]);

        return back()->with('success', 'Subscription renewed successfully.');
    }

    /**
     * Change tenant plan
     */
    public function changePlan(Request $request, Tenant $tenant)
    {
        $request->validate([
            'subscribtion_type' => 'required|in:basic,premium,enterprise',
            'subscribtion_amount' => 'required|numeric|min:0',
        ]);

        $tenant->update([
            'subscribtion_type' => $request->subscribtion_type,
            'subscribtion_amount' => $request->subscribtion_amount,
            'subscribtion_created' => now(),
        ]);

        return back()->with('success', 'Plan changed successfully.');
    }

    /**
     * Show expired subscription page
     */
    public function showExpired()
    {
        $tenant = auth()->user()->tenant;
        
        if (!$tenant) {
            return redirect()->route('login')
                ->with('error', 'No tenant found for your account.');
        }

        return view('tenant.expired', compact('tenant'));
    }
}
