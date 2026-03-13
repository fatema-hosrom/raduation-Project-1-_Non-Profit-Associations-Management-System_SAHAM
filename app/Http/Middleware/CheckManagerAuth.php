<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckManagerAuth
{
    // عمل Middleware للتحقق من مصادقة المدير
    public function handle(Request $request, Closure $next)
    {
        // التحقق من مصادقة المدير
        if (!Auth::guard('manager')->check()) {
            // التحقق من وجود معرف المدير في الجلسة
            if ($request->session()->has('manager_id')) {
                return $next($request);
            }
            return redirect()->route('auth.login');
        }
        // إضافة تحقق من نوع المدير - يجب أن يكون مدير فعاليات
        $manager = Auth::guard('manager')->user();
        if ($manager && $manager->manager_type !== 'activities') {
            // رفض الوصول إذا كان المالي يحاول الدخول إلى قسم الفعاليات
            return redirect()->route('auth.login');
        }
        return $next($request);
    }
}
