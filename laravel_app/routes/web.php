<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\AdminController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::post('/admin/product/{id}/approve', [AdminController::class, 'approveProduct'])->name('admin.product.approve');
    Route::post('/admin/product/{id}/reject', [AdminController::class, 'rejectProduct'])->name('admin.product.reject');
});

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::middleware(['auth', 'role:buyer'])->group(function () {
    Route::get('/buyer/dashboard', [DashboardController::class, 'buyer'])->name('buyer.dashboard');
    Route::get('/buyer/cart', [CartController::class, 'index'])->name('buyer.cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('buyer.checkout');
    Route::get('/buyer/order/success', [OrderController::class, 'success'])->name('buyer.order.success');
});

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdviceController;

Route::middleware(['auth', 'role:farmer'])->group(function () {
    Route::get('/farmer/dashboard', [DashboardController::class, 'farmer'])->name('farmer.dashboard');
    Route::post('/farmer/product/store', [ProductController::class, 'store'])->name('farmer.product.store');
    Route::delete('/farmer/product/{id}', [ProductController::class, 'destroy'])->name('farmer.product.destroy');
    Route::post('/farmer/advice/ask', [AdviceController::class, 'ask'])->name('farmer.advice.ask');
});

Route::middleware(['auth', 'role:expert'])->group(function () {
    Route::get('/expert/dashboard', [DashboardController::class, 'expert'])->name('expert.dashboard');
    Route::post('/expert/advice/{id}/answer', [AdviceController::class, 'answer'])->name('expert.advice.answer');
});

use App\Http\Controllers\ChatController;

use App\Http\Controllers\ProfileController;

Route::middleware(['auth'])->group(function () {
    Route::get('/chat/{user_id?}', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
