<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\FarmerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register.perform');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function (): void {
    Route::get('/farmer/issues/create', [FarmerController::class, 'createIssue'])->name('farmer.issue.create');
    Route::post('/farmer/issues', [FarmerController::class, 'storeIssue'])->name('farmer.issue.store');
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');

    Route::middleware(['role:expert'])->group(function (): void {
        Route::get('/expert/dashboard', [ExpertController::class, 'dashboard'])->name('expert.dashboard');
        Route::post('/expert/issues/{issue}/answer', [ExpertController::class, 'answerIssue'])->name('expert.issue.answer');
        Route::post('/expert/guides', [ExpertController::class, 'storeGuide'])->name('expert.guide.store');
        Route::post('/expert/articles', [ExpertController::class, 'storeArticle'])->name('expert.article.store');
    });

    Route::middleware(['role:admin'])->group(function (): void {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/admin/experts/{user}/approve', [AdminController::class, 'approveExpert'])->name('admin.expert.approve');
        Route::post('/admin/ads', [AdminController::class, 'storeAd'])->name('admin.ad.store');
    });
});
