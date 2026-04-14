<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrganizationActivity;
use App\Models\Volunteer;
use App\Models\ActivityVolunteerAssignment;


class ActivityVolunteersController extends Controller
{
    // عرض قائمة الفعاليات التي تحتاج متطوعين
    public function index(Request $request)
    {
        $managerId = session('manager_id');

        $query = OrganizationActivity::with(['volunteerRequirements', 'assignments' => function ($q) {
            $q->where('is_deleted', false);
        }])
            ->withCount(['assignments' => function ($q) {
                $q->where('is_deleted', false);
            }])
            ->where('manager_id', $managerId)
            ->where('is_published', true)
            ->whereHas('volunteerRequirements', function ($q) {
                $q->where('required_volunteers', '>', 0);
            });

        // البحث
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $activities = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('html.manager.activity_volunteers.activity_volunteers', compact('activities'));
    }

    // عرض المتطوعين في فعالية معينة
    public function show($activityId)
    {
        $managerId = session('manager_id');

        $activity = OrganizationActivity::with(['volunteerRequirements', 'assignments'])
            ->where('id', $activityId)
            ->where('manager_id', $managerId)
            ->firstOrFail();

        $assignments = ActivityVolunteerAssignment::with(['volunteer'])
            ->where('activity_id', $activityId)
            ->where('is_deleted', false)
            ->orderBy('request_date', 'desc')
            ->get();

        // إحصائيات سريعة
        $stats = [
            'total' => $assignments->count(),
            'pending' => $assignments->where('status', 'pending')->count(),
            'approved' => $assignments->where('status', 'approved')->count(),
            'rejected' => $assignments->where('status', 'rejected')->count(),
        ];

        return view('html.manager.activity_volunteers.manage_activity_volunteers', compact('activity', 'assignments', 'stats'));
    }

    // إضافة متطوع للفعالية
    public function assignVolunteer(Request $request, $activityId)
    {
        $managerId = session('manager_id');

        $activity = OrganizationActivity::where('id', $activityId)
            ->where('manager_id', $managerId)
            ->firstOrFail();

        $request->validate([
            'volunteer_id' => 'required|exists:volunteers,id',
        ]);

        $volunteerId = $request->volunteer_id;

        // التحقق من عدم وجود طلب سابق نشط
        $existingAssignment = ActivityVolunteerAssignment::where('activity_id', $activityId)
            ->where('volunteer_id', $volunteerId)
            ->where('is_deleted', false)
            ->first();

        if ($existingAssignment) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'هذا المتطوع لديه طلب سابق لهذه الفعالية'], 400);
            }
            return back()->with('error', 'هذا المتطوع لديه طلب سابق لهذه الفعالية');
        }

        ActivityVolunteerAssignment::create([
            'activity_id' => $activityId,
            'volunteer_id' => $volunteerId,
            'status' => 'approved',
            'decision_date' => now(),
            'joined_at' => now(),
            'request_date' => now(),
            'is_deleted' => false,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'تم إضافة المتطوع للفعالية بنجاح']);
        }
        return back()->with('success', 'تم إضافة المتطوع للفعالية بنجاح');
    }

    // قبول طلب متطوع
    public function approveVolunteer($activityId, $assignmentId)
    {
        $managerId = session('manager_id');

        $activity = OrganizationActivity::where('id', $activityId)
            ->where('manager_id', $managerId)
            ->firstOrFail();

        $assignment = ActivityVolunteerAssignment::where('id', $assignmentId)
            ->where('activity_id', $activityId)
            ->where('status', 'pending')
            ->firstOrFail();

        $assignment->update([
            'status' => 'approved',
            'decision_date' => now(),
            'joined_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'تم قبول طلب المتطوع بنجاح']);
    }

    // رفض طلب متطوع
    public function rejectVolunteer(Request $request, $activityId, $assignmentId)
    {
        $managerId = session('manager_id');

        $activity = OrganizationActivity::where('id', $activityId)
            ->where('manager_id', $managerId)
            ->firstOrFail();

        $assignment = ActivityVolunteerAssignment::where('id', $assignmentId)
            ->where('activity_id', $activityId)
            ->whereIn('status', ['pending', 'approved'])
            ->firstOrFail();

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $assignment->update([
            'status' => 'rejected',
            'decision_date' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return response()->json(['success' => true, 'message' => 'تم رفض طلب المتطوع']);
    }

    // حذف متطوع من الفعالية
    public function removeVolunteer(Request $request, $activityId, $assignmentId)
    {
        $managerId = session('manager_id');

        $activity = OrganizationActivity::where('id', $activityId)
            ->where('manager_id', $managerId)
            ->firstOrFail();

        $assignment = ActivityVolunteerAssignment::where('id', $assignmentId)
            ->where('activity_id', $activityId)
            ->where('is_deleted', false)
            ->firstOrFail();

        $request->validate([
            'removal_reason' => 'required|string|max:500',
        ]);

        $assignment->update([
            'is_deleted' => true,
            'removed_at' => now(),
            'removed_by' => $managerId,
            'removal_reason' => $request->removal_reason,
        ]);

        // تقليل عدد المتطوعين للفعالية إذا كان مقبول
        if ($assignment->status === 'approved') {
            $requirements = $activity->volunteerRequirements()->first();
            if ($requirements && $requirements->volunteers_count > 0) {
                $requirements->decrement('volunteers_count');
            }
        }

        return response()->json(['success' => true, 'message' => 'تم حذف المتطوع من الفعالية']);
    }

    // عرض معلومات المتطوع
    public function viewVolunteer($activityId, $assignmentId)
    {
        $managerId = session('manager_id');

        $activity = OrganizationActivity::where('id', $activityId)
            ->where('manager_id', $managerId)
            ->firstOrFail();

        $assignment = ActivityVolunteerAssignment::with(['volunteer'])
            ->where('id', $assignmentId)
            ->where('activity_id', $activityId)
            ->firstOrFail();

        return view('html.manager.activity_volunteers.view_volunteer_details', compact('activity', 'assignment'));
    }

    // الحصول على قائمة المتطوعين المتاحين للإضافة
    public function getAvailableVolunteers($activityId)
    {
        $managerId = session('manager_id');

        $activity = OrganizationActivity::where('id', $activityId)
            ->where('manager_id', $managerId)
            ->firstOrFail();

        // المتطوعين الذين لم يتقدموا لهذه الفعالية أو تم رفض طلبهم سابقاً
        $assignedVolunteerIds = ActivityVolunteerAssignment::where('activity_id', $activityId)
            ->where('is_deleted', false)
            ->whereIn('status', ['pending', 'approved'])
            ->pluck('volunteer_id')
            ->toArray();

        $volunteers = Volunteer::whereNotIn('id', $assignedVolunteerIds)
            ->select('id', 'name', 'email', 'phone')
            ->orderBy('name')
            ->get();

        return response()->json($volunteers);
    }
}
