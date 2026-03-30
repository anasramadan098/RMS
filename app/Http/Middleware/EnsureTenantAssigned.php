<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantAssigned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Check if user has a tenant assigned
        if (empty($user->tenant_id)) {
            return redirect()->route('tenant.select')
                ->with('error', 'Please select a tenant to continue.');
        }

        // Get tenant and check subscription status
        $tenant = $user->tenant;
        
        if (!$tenant) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Tenant not found.');
        }

        // Check if subscription is expired
        if (!$tenant->hasActiveSubscription()) {
            // Logout user and redirect with message
            auth()->logout();
            
            return redirect()->route('login')
                ->with('error', 'Your subscription has expired. Please contact the administrator to renew your subscription.');
        }

        // Set tenant session
        session(['tenant_id' => $user->tenant_id]);

        return $next($request);
    }
}
