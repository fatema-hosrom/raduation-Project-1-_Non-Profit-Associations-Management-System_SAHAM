<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Manager\ActivityController;
use App\Http\Controllers\Manager\OrganizationController;
use App\Http\Middleware\CheckManagerAuth;
use App\Http\Controllers\Manager\ManagerProfileController;

// Auth routes - توجيه إلى النظام الموحد
Route::get('/manager/login', function () {
    return redirect()->route('auth.login');
});
Route::post('/manager/login', function () {
    return redirect()->route('auth.login');
});
Route::get('/manager/logout', function () {
    return redirect()->route('auth.logout');
});

Route::middleware([CheckManagerAuth::class])->prefix('manager')->name('manager.')->group(function () {
    // لوحة تحكم المدير
    Route::get('/dashboard', [ActivityController::class, 'dashboard'])->name('dashboard');



    // الملف الشخصي للمدير
    Route::get('/profile', [ManagerProfileController::class, 'profile'])->name('profile');
    // تعديل الملف الشخصي للمدير
    Route::get('/profile/edit', [ManagerProfileController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/edit', [ManagerProfileController::class, 'updateProfile'])->name('profile.update');



    // الفعاليات ادارة
    Route::get('/activities', [ActivityController::class, 'getActivities'])->name('activities.index');
    // عرض تفاصيل الفعالية
    Route::get('/activities/view/{id}', [ActivityController::class, 'viewActivity'])->name('activities.view');
    // إضافة فعاليات جديدة
    Route::get('/activities/add', [ActivityController::class, 'addActivity'])->name('activities.add');
    Route::post('/activities/add', [ActivityController::class, 'storeActivity'])->name('activities.store');
    // تعديل الفعاليات
    Route::get('/activities/edit/{id}', [ActivityController::class, 'editActivity'])->name('activities.edit');
    Route::put('/activities/edit/{id}', [ActivityController::class, 'updateActivity'])->name('activities.update');
    // حذف الفعاليات
    Route::delete('/activities/{id}', [ActivityController::class, 'destroyActivity'])->name('activities.destroy');
    // عملية النشر والإلغاء
    Route::post('/activities/toggle-publish/{id}', [ActivityController::class, 'togglePublish'])->name('activities.togglePublish');

    // تغيير حالة الفعالية
    Route::post('/activities/toggle-status/{id}', [ActivityController::class, 'toggleStatus'])->name('activities.toggleStatus');
    Route::post('/activities/change-status/{id}', [ActivityController::class, 'changeStatus'])->name('activities.changeStatus');

    // نتائج الفعاليات - صفحة موحدة
    //  عرض البيانات أو نموذج الإضافة أو نموذج التعديل بناءً على وجود النتائج وحالة الفعالية
    Route::get('/activities/{id}/results', [ActivityController::class, 'manageActivityResults'])->name('activities.results.view');
    // حفظ النتائج الجديدة أو تحديث النتائج الحالية بناءً على وجودها
    Route::post('/activities/{id}/results', [ActivityController::class, 'storeActivityResults'])->name('activities.results.store');
    Route::put('/activities/{id}/results', [ActivityController::class, 'updateActivityResults'])->name('activities.results.update');
    // حذف نتائج الفعالية بالكامل
    Route::delete('/activities/{id}/results', [ActivityController::class, 'destroyActivityResults'])->name('activities.results.destroy');

    // إدارة المتطوعين في الفعاليات
    // عرض قائمة الفعاليات التي تحتاج متطوعين
    Route::get('/activity-volunteers', [App\Http\Controllers\Manager\ActivityVolunteersController::class, 'index'])->name('activity_volunteers.index');
    // عرض وإدارة المتطوعين في فعالية معينة
    Route::get('/activity-volunteers/{activityId}', [App\Http\Controllers\Manager\ActivityVolunteersController::class, 'show'])->name('activity_volunteers.manage');
    // إضافة متطوع للفعالية
    Route::post('/activity-volunteers/{activityId}/assign', [App\Http\Controllers\Manager\ActivityVolunteersController::class, 'assignVolunteer'])->name('activity_volunteers.assign');
    // الموافقة على طلب تطوع
    Route::post('/activity-volunteers/{activityId}/{assignmentId}/approve', [App\Http\Controllers\Manager\ActivityVolunteersController::class, 'approveVolunteer'])->name('activity_volunteers.approve');
    // رفض طلب تطوع
    Route::post('/activity-volunteers/{activityId}/{assignmentId}/reject', [App\Http\Controllers\Manager\ActivityVolunteersController::class, 'rejectVolunteer'])->name('activity_volunteers.reject');
    // إز                                                             الة متطوع من الفعالية
    Route::post('/activity-volunteers/{activityId}/{assignmentId}/remove', [App\Http\Controllers\Manager\ActivityVolunteersController::class, 'removeVolunteer'])->name('activity_volunteers.remove');
    // عرض تفاصيل المتطوع
    Route::get('/activity-volunteers/{activityId}/{assignmentId}/details', [App\Http\Controllers\Manager\ActivityVolunteersController::class, 'viewVolunteer'])->name('activity_volunteers.details');
    // الحصول على قائمة المتطوعين المتاحين للإضافة
    Route::get('/activity-volunteers/{activityId}/available-volunteers', [App\Http\Controllers\Manager\ActivityVolunteersController::class, 'getAvailableVolunteers'])->name('activity_volunteers.available');

    // الجمعيات
    Route::get('/organizations', [OrganizationController::class, 'getOrganizations'])->name('organizations.index');
    //عرض تفاصيل الجمعية
    Route::get('/organizations/view/{id}', [OrganizationController::class, 'viewOrganization'])->name('organizations.show');
    // إضافة جمعيات جديدة
    Route::get('/organizations/create', [OrganizationController::class, 'addOrganization'])->name('organizations.add');
    Route::post('/organizations/create', [OrganizationController::class, 'storeOrganization'])->name('organizations.store');
    // تعديل بيانات الجمعية
    Route::get('/organizations/{id}/edit', [OrganizationController::class, 'editOrganization'])->name('organizations.edit');
    Route::put('/organizations/{id}', [OrganizationController::class, 'updateOrganization'])->name('organizations.update');
    // حذف الجمعية
    Route::delete('/organizations/{id}', [OrganizationController::class, 'destroyOrganization'])->name('organizations.destroy');


    // الفعاليات الخاصة بالجمعيات
    Route::get('/organizations/{orgId}/events', [OrganizationController::class, 'getEvents'])->name('organizations.events.index');
    // اضافة فعالية جديدة للجمعية
    Route::get('/organizations/{orgId}/events/create', [OrganizationController::class, 'createEvent'])->name('organizations.events.create');
    Route::post('/organizations/{orgId}/events', [OrganizationController::class, 'storeEvent'])->name('organizations.events.store');
    // عرض تفاصيل الفعالية للجمعية
    Route::get('/events/{id}', [OrganizationController::class, 'viewEvent'])->name('organizations.events.show');
    // تعديل فعالية الجمعية للجمعية
    Route::get('/events/{id}/edit', [OrganizationController::class, 'editEvent'])->name('organizations.events.edit');
    Route::put('/events/{id}', [OrganizationController::class, 'updateEvent'])->name('organizations.events.update');
    // حذف فعالية الجمعية للجمعية
    Route::delete('/events/{id}', [OrganizationController::class, 'destroyEvent'])->name('organizations.events.destroy');

    // إدارة المتطوعين
    Route::get('/volunteers', [App\Http\Controllers\Manager\VolunteerController::class, 'getVolunteers'])->name('volunteers.index');
    Route::get('/volunteers/add', [App\Http\Controllers\Manager\VolunteerController::class, 'addVolunteer'])->name('volunteers.add');
    Route::post('/volunteers/add', [App\Http\Controllers\Manager\VolunteerController::class, 'storeVolunteer'])->name('volunteers.store');
    Route::get('/volunteers/{id}', [App\Http\Controllers\Manager\VolunteerController::class, 'viewVolunteer'])->name('volunteers.show');
    Route::get('/volunteers/{id}/edit', [App\Http\Controllers\Manager\VolunteerController::class, 'editVolunteer'])->name('volunteers.edit');
    Route::put('/volunteers/{id}', [App\Http\Controllers\Manager\VolunteerController::class, 'updateVolunteer'])->name('volunteers.update');
    Route::delete('/volunteers/{id}', [App\Http\Controllers\Manager\VolunteerController::class, 'destroyVolunteer'])->name('volunteers.destroy');
});
