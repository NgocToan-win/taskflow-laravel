<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'redirect.admin'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route download file - cho phép cả Admin và User thường
    Route::get('/tasks/{task}/download', [TaskController::class, 'download'])->name('tasks.download');
// Route thêm bình luận - cho phép cả Admin và User thường
    Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])
    ->name('comments.store');
    // Nhóm các routes của User thường cần kiểm tra và chuyển hướng Admin
    Route::middleware('redirect.admin')->group(function () {
        Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
        Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/tasks/clear-status', [TaskController::class, 'clearStatus'])->name('tasks.clearStatus');
        Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
        Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
        Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
        Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
        Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
        Route::post('/teams/join', [TeamController::class, 'requestToJoin'])->name('teams.join');
        Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
        Route::post('/teams/{team}/invite', [TeamController::class, 'inviteMember'])->name('teams.invite');
        Route::post('/teams/{team}/accept', [TeamController::class, 'acceptInvite'])->name('teams.accept');
        Route::delete('/teams/{team}/remove/{user}', [TeamController::class, 'removeMember'])->name('teams.remove');
        Route::post('/teams/{team}/approve/{user}', [TeamController::class, 'approveRequest'])->name('teams.approve');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export', [ReportController::class, 'exportCsv'])->name('reports.export');
    });

    // Các routes dành riêng cho Quản trị viên (Admin)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [\App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('users.index');
        Route::post('/users', [\App\Http\Controllers\Admin\AdminUserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [\App\Http\Controllers\Admin\AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [\App\Http\Controllers\Admin\AdminUserController::class, 'destroy'])->name('users.destroy');
        
        // Quản lý công việc cho Admin
        Route::get('/tasks', [\App\Http\Controllers\Admin\AdminTaskController::class, 'index'])->name('tasks.index');
        Route::post('/tasks', [\App\Http\Controllers\Admin\AdminTaskController::class, 'store'])->name('tasks.store');
        Route::put('/tasks/{task}', [\App\Http\Controllers\Admin\AdminTaskController::class, 'update'])->name('tasks.update');
        Route::delete('/tasks/{task}', [\App\Http\Controllers\Admin\AdminTaskController::class, 'destroy'])->name('tasks.destroy');
    });
});
    
require __DIR__.'/auth.php';
