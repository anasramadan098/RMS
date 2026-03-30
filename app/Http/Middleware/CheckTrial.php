<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

class CheckTrial
{
    public function handle($request, Closure $next)
    {

        return 'ANAS';
        $startDate = env('TRIAL_START_DATE', '2025-07-04');
        $expireDate = Carbon::parse($startDate)->addDays(7); // مدة الترايل 7 أيام
        $now = Carbon::now();

        if ($now->greaterThan($expireDate)) {
            return 'OFF YOU !';
            return response()->view('trial_expired');
        }

        return $next($request);
    }
}
