
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\DoctorScheduleController;
use App\Http\Controllers\Admin\HeroCarouselController;
use App\Http\Controllers\Admin\NewsController;

Route::get('/ping', function () {
    return response()->json(['message' => 'API OK']);
});

Route::prefix('admin')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
    });
        Route::middleware(['auth:api', 'permission:view-dashboard'])->get('/dashboard', [DashboardController::class, 'index']);
        //end-point-admin-doctor
        Route::get('/doctors', [DoctorController::class, 'index'])->middleware('permission:view-doctor');
        Route::post('/doctors', [DoctorController::class, 'store'])->middleware('permission:create-doctor');
        Route::get('/doctors/{id}', [DoctorController::class, 'show'])->middleware('permission:view-doctor');
        Route::put('/doctors/{id}', [DoctorController::class, 'update'])->middleware('permission:update-doctor');
        Route::delete('/doctors/{id}', [DoctorController::class, 'destroy'])->middleware('permission:delete-doctor');
        //end-point-admin-schedule-doctors
        Route::get('/doctors/{id}/schedules', [DoctorScheduleController::class, 'index'])->middleware('permission:view-schedule');
        Route::post('/schedules', [DoctorScheduleController::class, 'store'])->middleware('permission:create-schedule');
        Route::put('/schedules/{id}', [DoctorScheduleController::class, 'update'])->middleware('permission:update-schedule');
        Route::delete('/schedules/{id}', [DoctorScheduleController::class, 'destroy'])->middleware('permission:delete-schedule');
        //end-point-admin-Hero
        Route::get('/heroes', [HeroCarouselController::class, 'index'])->middleware('permission:view-hero');
        Route::post('/heroes', [HeroCarouselController::class, 'store'])->middleware('permission:create-hero');
        Route::get('/heroes/{id}', [HeroCarouselController::class, 'show'])->middleware('permission:view-hero');
        Route::put('/heroes/{id}', [HeroCarouselController::class, 'update'])->middleware('permission:update-hero');
        Route::delete('/heroes/{id}', [HeroCarouselController::class, 'destroy'])->middleware('permission:delete-hero');
        //News
        Route::get('/news', [NewsController::class, 'index'])->middleware('permission:view-news');
        Route::post('/news', [NewsController::class, 'store'])->middleware('permission:create-news');
        Route::get('/news/{id}', [NewsController::class, 'show'])->middleware('permission:view-news');
        Route::put('/news/{id}', [NewsController::class, 'update'])->middleware('permission:update-news');
        Route::delete('/news/{id}', [NewsController::class, 'destroy'])->middleware('permission:delete-news');

});