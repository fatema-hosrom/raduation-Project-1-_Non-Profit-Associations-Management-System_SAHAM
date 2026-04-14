<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VolunteerAuth
{
    /**
     * معالج للتحقق من تسجيل دخول المتطوع
     */
    public function handle(Request $request, Closure $next)
    {
        

        if (!$request->session()->has('volunteer_id')) {
            return redirect()->route('public.home')
                ->with('error', 'يجب تسجيل الدخول أولاً');
        }

        return $next($request);
    }
}
