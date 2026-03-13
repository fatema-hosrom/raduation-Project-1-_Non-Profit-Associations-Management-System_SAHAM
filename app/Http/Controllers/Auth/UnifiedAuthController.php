<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnifiedAuthController extends Controller
{
    public function showLogin()
    {
        return view('html.login.unified_login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // محاولة تسجيل الدخول كمدير
        if (Auth::guard('manager')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            $manager = Auth::guard('manager')->user();
            // تخزين المعرف بناءً على النوع
            if ($manager->manager_type === 'activities') {
                $request->session()->put('manager_id', $manager->id);
                return redirect()->intended(route('manager.dashboard'));
            } elseif ($manager->manager_type === 'financial') {
                // تسجيل الخروج من guard manager وتسجيل الدخول في guard financial_manager
                Auth::guard('manager')->logout();
                Auth::guard('financial_manager')->login($manager, $request->filled('remember'));
                $request->session()->put('financial_manager_id', $manager->id);
                return redirect()->intended(route('financial.dashboard'));
            }
        }

        // إذا لم ينجح كمدير، جرب كمشرف
        if (Auth::guard('supervisor')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            $request->session()->put('supervisor_id', Auth::guard('supervisor')->id());
            return redirect()->intended(route('supervisor.dashboard'));
        }

        // إذا لم ينجح في أي منهما
        return back()->withErrors(['email' => 'بيانات الدخول غير صحيحة أو الحساب غير موجود'])->withInput();
    }

    public function logout(Request $request)
    {
        // تسجيل الخروج من جميع الحراس
        Auth::guard('manager')->logout();
        Auth::guard('financial_manager')->logout();
        Auth::guard('supervisor')->logout();

        // مسح أي مفاتيح خاصة بالجلسة
        $request->session()->forget('manager_id');
        $request->session()->forget('financial_manager_id');
        $request->session()->forget('supervisor_id');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }
}
