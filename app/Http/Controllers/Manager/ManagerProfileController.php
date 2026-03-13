<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Manager;
use Illuminate\Validation\Rule;

class ManagerProfileController extends Controller
{

    // عرض الملف الشخصي للمدير
    public function profile(Request $request)

    {
        $managerId = $request->session()->get('manager_id');
        $manager = Manager::findOrFail($managerId);
        return view('html.manager.profile.profile', compact('manager'));
    }

    // تعديل الملف الشخصي للمدير

    // عرض نموذج التعديل)(GET)
    public function editProfile(Request $request)
    {
        $managerId = $request->session()->get('manager_id');
        $manager = Manager::findOrFail($managerId);
        return view('html.manager.profile.edit_profile', compact('manager'));
    }

    public function updateProfile(Request $request)
    {
        $managerId = $request->session()->get('manager_id');
        $manager = Manager::findOrFail($managerId);
        try {
            $data = $request->validate([
                'full_name' => 'required|string|max:255',

                'username'  => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('manager', 'username')->ignore($manager->id),
                ],

                'email'     => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('manager', 'email')->ignore($manager->id),
                ],

                'phone'     => 'nullable|string|max:20',

                // كلمة المرور اختيارية
                'password'  => 'nullable|string|min:8|confirmed',

                [
                    'username.unique' => 'اسم المستخدم مستخدم بالفعل.',
                    'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',
                    'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.'
                ],
            ]);

            // تحديث كلمة المرور فقط إذا تم إدخالها
            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            } else {
                unset($data['password']); // لا نرسلها للتحديث
            }

            // تحديث البيانات
            $manager->update($data);

            return redirect()->route('manager.profile')
                ->with('success', 'تم تحديث الملف الشخصي بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('manager.profile.edit')
                ->with('error', 'حدث خطأ أثناء تحديث الملف الشخصي: ' . $e->getMessage());
        }
    }
}
