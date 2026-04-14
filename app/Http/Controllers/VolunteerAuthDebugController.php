<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class VolunteerAuthDebugController extends Controller
{
    /**
     * تسجيل الدخول مع طباعة معلومات تفصيلية للتشخيص
     */
    public function loginDebug(Request $request)
    {
        // طباعة البيانات المدخلة
        Log::info('=== LOGIN DEBUG START ===');
        Log::info('Email entered: ' . $request->email);
        Log::info('Password entered: ' . $request->password);

        // التحقق من المدخلات
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // البحث عن المتطوع
        Log::info('Searching for volunteer with email: ' . $request->email);
        $volunteer = Volunteer::where('email', $request->email)->first();

        if (!$volunteer) {
            Log::warning('Volunteer NOT FOUND with email: ' . $request->email);

            // عرض جميع البيانات للمقارنة
            $all_volunteers = Volunteer::select('id', 'email', 'status')->get();
            Log::info('All volunteers in database:');
            foreach ($all_volunteers as $v) {
                Log::info("  - ID: {$v->id}, Email: {$v->email}, Status: {$v->status}");
            }

            return back()->withErrors(['error' => '❌ البريد غير موجود في قاعدة البيانات']);
        }

        Log::info('✅ Volunteer FOUND: ' . $volunteer->name);
        Log::info('Volunteer ID: ' . $volunteer->id);
        Log::info('Volunteer Status: ' . $volunteer->status);
        Log::info('Password stored (first 20 chars): ' . substr($volunteer->password, 0, 20) . '...');

        // التحقق من كلمة المرور
        Log::info('Checking password...');
        $password_match = Hash::check($request->password, $volunteer->password);
        Log::info('Password match result: ' . ($password_match ? 'TRUE ✅' : 'FALSE ❌'));

        if (!$password_match) {
            Log::warning('Password mismatch for email: ' . $request->email);
            return back()->withErrors(['error' => '❌ كلمة المرور غير صحيحة']);
        }

        Log::info('✅ Password is correct');

        // التحقق من حالة المتطوع
        Log::info('Checking volunteer status: ' . $volunteer->status);

        if ($volunteer->status === 'pending') {
            Log::info('Status is pending - User will be rejected');
            return back()->with('warning', '⏳ حسابك قيد المراجعة حالياً');
        }

        if ($volunteer->status === 'inactive') {
            Log::info('Status is inactive - User will be rejected');
            return back()->with('error', '❌ حسابك معطل');
        }

        if ($volunteer->status !== 'active') {
            Log::warning('Unknown status: ' . $volunteer->status);
            return back()->with('error', '❌ حالة حسابك غير صحيحة');
        }

        Log::info('✅ Status is active - User approved to login');

        // تسجيل الدخول
        $request->session()->put([
            'volunteer_id' => $volunteer->id,
            'volunteer_name' => $volunteer->name,
            'volunteer_email' => $volunteer->email,
        ]);

        Log::info('✅ Session stored successfully');
        Log::info('=== LOGIN DEBUG END - SUCCESS ===');

        return redirect()->route('volunteer.dashboard')
            ->with('success', '✅ تم تسجيل الدخول بنجاح');
    }
}
