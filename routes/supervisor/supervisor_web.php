<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Supervisor\ManagerController;
use App\Http\Middleware\CheckSupervisorAuth;
use App\Http\Controllers\Auth\UnifiedAuthController;
use App\Http\Controllers\Supervisor\SupervisorProfileController;
use App\Http\Controllers\Supervisor\OrganizationActivityController;
use App\Http\Controllers\Supervisor\SupervisorVolunteerController;

// Auth routes - توجيه إلى النظام الموحد
Route::get('/supervisor/login', function () {
    return redirect()->route('auth.login');
});
Route::post('/supervisor/login', function () {
    return redirect()->route('auth.login');
});
Route::get('/supervisor/logout', function () {
    return redirect()->route('auth.logout');
});

Route::middleware([CheckSupervisorAuth::class])->prefix('supervisor')->name('supervisor.')->group(function () {
    // لوحة تحكم المشرف
    Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('dashboard');

    // الملف الشخصي للمشرف
    Route::get('/profile', [SupervisorProfileController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [SupervisorProfileController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/edit', [SupervisorProfileController::class, 'updateProfile'])->name('profile.update');


    // إدارة المديرين
    Route::get('/managers', [ManagerController::class, 'viewManager'])->name('managers.index');
    Route::get('/managers/show/{id}', [ManagerController::class, 'showManager'])->name('managers.show');
    Route::match(['get', 'post'], '/managers/add', [ManagerController::class, 'addManager'])->name('managers.add');
    Route::match(['get', 'post'], '/managers/edit/{id}', [ManagerController::class, 'editManager'])->name('managers.edit');
    Route::delete('/managers/delete/{id}', [ManagerController::class, 'deleteManager'])->name('managers.destroy');
    // تعيين الأدوار للمديرين
    Route::match(['get', 'post'], '/manager/assign-role', [ManagerController::class, 'assignRole'])->name('assignRole');

    // إدارة الأنشطة والمنظمات

    // إدارة الأنشطة لساهم
    route::get('/activities', [OrganizationActivityController::class, 'getActivities'])->name('activities.index');
    route::get('/activities/view/{id}', [OrganizationActivityController::class, 'ShowActivity'])->name('activities.show');

    // إدارة الجمعيات
    route::get('/organizations', [OrganizationActivityController::class, 'getOrganizations'])->name('organizations.index');
    route::get('/organizations/view/{id}', [OrganizationActivityController::class, 'showOrganization'])->name('organizations.show');
    // إدارة فعاليات الجمعيات
    route::get('/organizations/{orgId}/events', [OrganizationActivityController::class, 'getEvents'])->name('organizations.events.index');
    route::get('/organizations/events/view/{id}', [OrganizationActivityController::class, 'viewEvent'])->name('organizations.events.show');

    //تسجيل المتطوعين
    route::get('/volunteers', [SupervisorVolunteerController::class, 'index'])->name('volunteers.index');
    route::get('/volunteers/{id}', [SupervisorVolunteerController::class, 'show'])->name('volunteers.show');
    route::patch('/volunteers/{id}/status', [SupervisorVolunteerController::class, 'updateStatus'])->name('volunteers.updateStatus');
});
