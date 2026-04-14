<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VolunteerAuthController extends Controller
{
    /**
     * عرض صفحة تسجيل الدخول
     */
    public function showLogin()
    {
        return view('public.volunteer.login');
    }

    /**
     * معالجة تسجيل الدخول
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $volunteer = Volunteer::where('email', $request->email)->first();

        if (!$volunteer || !Hash::check($request->password, $volunteer->password)) {
            return back()->withErrors(['error' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة']);
        }

        if ($volunteer->status !== 'active') {
            return back()->with('error', 'الحساب غير مفعل');
        }

        // 🔥 مهم جدًا
        $request->session()->regenerate();

        // تخزين السيشن
        $request->session()->put([
            'volunteer_id' => $volunteer->id,
            'volunteer_name' => $volunteer->name,
            'volunteer_email' => $volunteer->email,
        ]);

        return redirect()->route('volunteer.dashboard')
            ->with('success', 'تم تسجيل الدخول بنجاح');
    }
    /**
     * تسجيل الخروج
     */
    public function logout(Request $request)
    {
        $request->session()->forget(['volunteer_id', 'volunteer_name', 'volunteer_email']);
        $request->session()->flush();

        return redirect()->route('public.home')
            ->with('success', 'تم تسجيل الخروج بنجاح');
    }
}
