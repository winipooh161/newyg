<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VideoReelController;
use App\Http\Controllers\Admin\VideoReelController as AdminVideoReelController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('welcome');
});

Route::get('/gallery', [App\Http\Controllers\GalleryController::class, 'index'])->name('gallery');

// Маршруты для проектов
Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{id}', [App\Http\Controllers\ProjectController::class, 'show'])->name('projects.show');

// Отзыв пользователей
Route::post('/feedback', [App\Http\Controllers\FeedbackController::class, 'store'])->name('feedback.store');

// Маршруты модерации отзывов (доступ только для admin, например через middleware 'admin')
Route::middleware('admin')->group(function () {
    Route::get('/admin/feedback', [App\Http\Controllers\FeedbackController::class, 'index'])->name('feedback.index');
    Route::post('/admin/feedback/{id}/approve', [App\Http\Controllers\FeedbackController::class, 'approve'])->name('feedback.approve');
    Route::post('/admin/feedback/{id}/disapprove', [App\Http\Controllers\FeedbackController::class, 'disapprove'])->name('feedback.disapprove');
    Route::delete('/admin/feedback/{id}', [App\Http\Controllers\FeedbackController::class, 'destroy'])->name('feedback.destroy');
});

// Маршруты для админки, защищенные middleware admin
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/users', function () {
        return view('admin.users');
    })->name('admin.users');

    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');

    Route::get('/projects', [AdminController::class, 'projects'])->name('admin.projects');

    Route::get('/projects/create', [AdminController::class, 'createProject'])->name('admin.projects.create');
    Route::post('/projects', [AdminController::class, 'storeProject'])->name('admin.projects.store');
    Route::put('/projects/{id}', [AdminController::class, 'updateProject'])->name('admin.projects.update');
    Route::delete('/projects/{id}', [AdminController::class, 'destroyProject'])->name('admin.projects.destroy');

    // Добавляем определение маршрута для галереи проекта
    Route::get('/projects/gallery/{id}', [App\Http\Controllers\ProjectController::class, 'gallery'])->name('admin.projects.gallery');

    Route::delete('/users/{user}', [App\Http\Controllers\AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    // Маршруты для управления ссылками сайта
    Route::get('/site-links', [App\Http\Controllers\SiteLinkController::class, 'index'])->name('admin.site-links');
    Route::put('/site-links', [App\Http\Controllers\SiteLinkController::class, 'update'])->name('admin.site-links.update');

    // Video reels management
    Route::get('/video-reels', [AdminVideoReelController::class, 'index'])->name('admin.video-reels.index');
    Route::get('/video-reels/create', [AdminVideoReelController::class, 'create'])->name('admin.video-reels.create');
    Route::post('/video-reels', [AdminVideoReelController::class, 'store'])->name('admin.video-reels.store');
    Route::get('/video-reels/{id}/edit', [AdminVideoReelController::class, 'edit'])->name('admin.video-reels.edit');
    Route::put('/video-reels/{id}', [AdminVideoReelController::class, 'update'])->name('admin.video-reels.update');
    Route::delete('/video-reels/{id}', [AdminVideoReelController::class, 'destroy'])->name('admin.video-reels.destroy');
    
    // Project video routes
    Route::post('/projects/{id}/upload-video', [App\Http\Controllers\AdminController::class, 'uploadProjectVideo'])->name('admin.projects.upload-video');
    Route::delete('/projects/{id}/delete-video', [App\Http\Controllers\AdminController::class, 'deleteProjectVideo'])->name('admin.projects.delete-video');
});

// Video reels route
Route::get('/video-reels', [VideoReelController::class, 'index'])->name('video-reels');

// Project video display route
Route::get('/projects/{id}/video', [App\Http\Controllers\ProjectController::class, 'video'])->name('projects.video');

Route::post('/submitTelegram', [TelegramController::class, 'store'])->name('telegram.store');

Route::get('/thanks', [TelegramController::class, 'thanks'])->name('thanks');

Auth::routes();

Route::get('/welcome', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');
