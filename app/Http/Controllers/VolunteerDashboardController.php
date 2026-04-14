<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use App\Models\OrganizationActivity;
use App\Models\ActivityVolunteerAssignment;
use Illuminate\Http\Request;

class VolunteerDashboardController extends Controller
{
    /**
     * الحصول على المتطوع المسجل الدخول
     */
    protected function getAuthVolunteer(Request $request)
    {
        if (!$request->session()->has('volunteer_id')) {
            return null;
        }
        return Volunteer::find($request->session()->get('volunteer_id'));
    }

    /**
     * عرض dashboard المتطوع
     */
    public function index(Request $request)
    {
        $volunteer = $this->getAuthVolunteer($request);

        if (!$volunteer) {
            return redirect()->route('public.home');
        }

        // إحصائيات المتطوع
        $stats = [
            'pending_requests' => $volunteer->assignments()->where('status', 'pending')->count(),
            'approved_activities' => $volunteer->assignments()->where('status', 'approved')->count(),
            'completed_activities' => $volunteer->assignments()
                ->where('status', 'approved')
                ->whereHas('activity', function ($q) {
                    $q->where('end_date', '<', now());
                })->count(),
        ];

        return view('public.volunteer.dashboard', compact('volunteer', 'stats'));
    }

    /**
     * عرض الملف الشخصي للمتطوع
     */
    public function profile(Request $request)
    {
        $volunteer = $this->getAuthVolunteer($request);

        if (!$volunteer) {
            return redirect()->route('public.home');
        }

        return view('public.volunteer.profile', compact('volunteer'));
    }

    /**
     * تعديل الملف الشخصي
     */
    public function updateProfile(Request $request)
    {
        $volunteer = $this->getAuthVolunteer($request);

        if (!$volunteer) {
            return redirect()->route('public.home');
        }

        // التحقق من المدخلات
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'age' => 'required|integer|min:16',
            'nationality' => 'required|string',
            'address' => 'required|string',
            'skills' => 'nullable|string',
            'experience' => 'nullable|string',
            'education_level' => 'nullable|string',
            'availability' => 'nullable|string',
            'preferred_roles' => 'nullable|string',
            'languages' => 'nullable|array',
            'emergency_contact' => 'nullable|string',
        ]);

        // تحويل اللغات إلى نص
        if (isset($data['languages'])) {
            $data['languages'] = implode(',', $data['languages']);
        }

        // تحديث البيانات
        $volunteer->update($data);

        return redirect()->route('volunteer.profile')
            ->with('success', 'تم تحديث ملفك الشخصي بنجاح');
    }

    /**
     * عرض الفعاليات المتاحة
     */
    public function availableActivities(Request $request)
    {
        $volunteer = $this->getAuthVolunteer($request);

        if (!$volunteer) {
            return redirect()->route('public.home');
        }

        // جلب الفعاليات المتاحة (المنشورة والتي تقبل متطوعين)
        $activities = OrganizationActivity::where('is_published', true)
            ->where('start_date', '>', now())
            ->whereHas('volunteerRequirements', function ($q) {
                $q->where('required_volunteers', '>', 0);
            })
            ->with(['volunteerRequirements', 'assignments'])
            ->get();

        // تصفية الفعاليات التي لم يطلب المتطوع التطوع فيها بعد
        $activities = $activities->filter(function ($activity) use ($volunteer) {
            return !$volunteer->assignments()
                ->where('activity_id', $activity->id)
                ->exists();
        });

        return view('public.volunteer.available-activities', compact('volunteer', 'activities'));
    }

    /**
     * طلب التطوع في فعالية
     */
    public function requestVolunteer(Request $request, $activityId)
    {
        $volunteer = $this->getAuthVolunteer($request);

        if (!$volunteer) {
            return redirect()->route('public.home');
        }

        // التحقق من وجود الفعالية
        $activity = OrganizationActivity::find($activityId);

        if (!$activity) {
            return back()->with('error', 'الفعالية غير موجودة');
        }

        // التحقق من عدم وجود طلب سابق
        if ($volunteer->assignments()->where('activity_id', $activityId)->exists()) {
            return back()->with('error', 'لقد قدمت طلب تطوع في هذه الفعالية من قبل');
        }

        // الحصول على متطلبات الفعالية
        $requirements = $activity->volunteerRequirements()->first();

        // إذا كان volunteer_mode = 'auto' → قبول فوري
        // إذا كان 'manual' → انتظار قبول يدوي
        if ($requirements && $requirements->volunteer_mode === 'auto') {
            $status = 'approved';
            $message = '✅ تم قبول طلبك في الفعالية مباشرة!';
            $decision_date = now();
            $joined_at = now();
        } else {
            $status = 'pending';
            $message = '⏳ تم إرسال طلب التطوع بنجاح - في انتظار قبول المنظم';
            $decision_date = null;
            $joined_at = null;
        }

        // إنشاء طلب التطوع
        ActivityVolunteerAssignment::create([
            'activity_id' => $activityId,
            'volunteer_id' => $volunteer->id,
            'status' => $status,
            'request_date' => now(),
            'decision_date' => $decision_date,
            'joined_at' => $joined_at,
        ]);

        return back()->with('success', $message);
    }

    /**
     * عرض طلبات التطوع
     */
    public function myRequests(Request $request)
    {
        $volunteer = $this->getAuthVolunteer($request);

        if (!$volunteer) {
            return redirect()->route('public.home');
        }

        // جلب جميع طلبات المتطوع (ما عدا المحذوفة)
        $requests = $volunteer->assignments()
            ->where('is_deleted', false)
            ->with('activity')
            ->orderBy('request_date', 'desc')
            ->get();

        return view('public.volunteer.my-requests', compact('volunteer', 'requests'));
    }

    /**
     * عرض المشاركات السابقة
     */
    public function pastActivities(Request $request)
    {
        $volunteer = $this->getAuthVolunteer($request);

        if (!$volunteer) {
            return redirect()->route('public.home');
        }

        // جلب الفعاليات المنتهية التي وافق على طلب المتطوع فيها
        $activities = $volunteer->assignments()
            ->where('status', 'approved')
            ->whereHas('activity', function ($q) {
                $q->where('end_date', '<', now());
            })
            ->with('activity')
            ->orderBy('joined_at', 'desc')
            ->get();

        return view('public.volunteer.past-activities', compact('volunteer', 'activities'));
    }
}
