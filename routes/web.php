<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\Auth\UnifiedAuthController;

require __DIR__ . '/manager/manager_web.php';
require __DIR__ . '/supervisor/supervisor_web.php';
require __DIR__ . '/financial/financial_web.php';
require __DIR__ . '/volunteer/volunteer_web.php';

/*|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------*/
route::prefix('/sahem')->name('public.')->group(function () {
    // الصفحة الرئيسية
    Route::get('/home', [PublicController::class, 'home'])->name('home');
    // الجمعيات
    Route::get('/organizations', [PublicController::class, 'organizations'])->name('organizations.index');

    // صفحة جمعية معينة
    Route::get('/organizations/{id}', [PublicController::class, 'showOrganization'])->name('organizations.show');

    /*
|--------------------------------------------------------------------------
| Activities
|--------------------------------------------------------------------------
*/

    // فعاليات ساهم
    Route::get('/activities', [PublicController::class, 'sahemActivities'])
        ->name('activities.index');
    // عرض تفاصيل فعالية ساهم معينة
    Route::get('/activities/sahem/{id}', [PublicController::class, 'showSahemActivity'])
        ->name('activities.sahem.show');

    // فعاليات الجمعيات
    Route::get('/organization', [PublicController::class, 'organizationEvents'])
        ->name('organization.events_index');
    // عرض تفاصيل فعالية جمعية معينة
    Route::get('/organization/{id}', [PublicController::class, 'showOrganizationEvent'])
        ->name('organization.event_show');


    // تسجيل متطوع جديد
    Route::get('/volunteer/register', [VolunteerController::class, 'volunteerRegister'])->name('volunteer.register');
    Route::post('/volunteer/register', [VolunteerController::class, 'volunteerStore'])->name('volunteer.store');
});

/*|--------------------------------------------------------------------------
| Unified Authentication Routes
|--------------------------------------------------------------------------*/
Route::get('/login', [UnifiedAuthController::class, 'showLogin'])->name('auth.login');
Route::post('/login', [UnifiedAuthController::class, 'login'])->name('auth.login.post');
Route::get('/logout', [UnifiedAuthController::class, 'logout'])->name('auth.logout');
