<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckFinancialManagerAuth
{
    // تأكد من تسجيل دخول مدير مالي
    public function handle(Request $request, Closure $next)
    {
        // يجب أن يكون هناك مصادقة بالحارس financial_manager
        if (!Auth::guard('financial_manager')->check()) {
            if ($request->session()->has('financial_manager_id')) {
                return $next($request);
            }
            return redirect()->route('auth.login');
        }

        // تحقق من نوع المدير
        $manager = Auth::guard('financial_manager')->user();
        if ($manager && $manager->manager_type === 'financial') {
            return $next($request);
        }

        return redirect()->route('auth.login');
    }
}
