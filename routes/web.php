<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\BuyerController;

// Guest Routes
Route::get('/', [GuestController::class, 'home'])->name('home');
Route::get('/পণ্য', [GuestController::class, 'browseProducts'])->name('guest.products');
Route::get('/পণ্য/{id}', [GuestController::class, 'viewProduct'])->name('guest.product');

// Auth Routes
Route::get('/লগইন', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/লগইন', [LoginController::class, 'login'])->name('login.submit');
Route::post('/লগআউট', [LoginController::class, 'logout'])->name('logout');

Route::get('/নিবন্ধন', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/নিবন্ধন', [RegisterController::class, 'register'])->name('register.submit');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('প্রশাসক')->group(function () {
    Route::get('/ড্যাশবোর্ড', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // User Management
    Route::get('/ব্যবহারকারী', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/ব্যবহারকারী/{id}', [AdminController::class, 'viewUser'])->name('admin.user.view');
    Route::get('/ব্যবহারকারী-যোগ', [AdminController::class, 'addUserForm'])->name('admin.user.add.form');
    Route::post('/ব্যবহারকারী-যোগ', [AdminController::class, 'addUser'])->name('admin.user.add');
    Route::post('/ব্যবহারকারী/{id}/অনুমোদন', [AdminController::class, 'approveUser'])->name('admin.user.approve');
    Route::post('/ব্যবহারকারী/{id}/প্রত্যাখ্যান', [AdminController::class, 'rejectUser'])->name('admin.user.reject');
    
    // Product Approval
    Route::post('/পণ্য/{id}/অনুমোদন', [AdminController::class, 'approveProduct'])->name('admin.product.approve');
    Route::post('/পণ্য/{id}/প্রত্যাখ্যান', [AdminController::class, 'rejectProduct'])->name('admin.product.reject');
    
    // Sales Report
    Route::get('/বিক্রয়-প্রতিবেদন', [AdminController::class, 'salesReport'])->name('admin.sales.report');
});

// Farmer Routes
Route::middleware(['auth', 'farmer'])->prefix('কৃষক')->group(function () {
    Route::get('/ড্যাশবোর্ড', [FarmerController::class, 'dashboard'])->name('farmer.dashboard');
    Route::get('/আমার-পণ্য', [FarmerController::class, 'myProducts'])->name('farmer.products');
    Route::get('/পণ্য-যোগ', [FarmerController::class, 'addProductForm'])->name('farmer.product.add.form');
    Route::post('/পণ্য-যোগ', [FarmerController::class, 'addProduct'])->name('farmer.product.add');
    Route::get('/পণ্য/{id}/সম্পাদনা', [FarmerController::class, 'editProductForm'])->name('farmer.product.edit.form');
    Route::post('/পণ্য/{id}/সম্পাদনা', [FarmerController::class, 'editProduct'])->name('farmer.product.edit');
    Route::post('/পণ্য/{id}/মুছে-ফেলা', [FarmerController::class, 'deleteProduct'])->name('farmer.product.delete');
});

// Buyer Routes
Route::middleware(['auth', 'buyer'])->prefix('ক্রেতা')->group(function () {
    Route::get('/ড্যাশবোর্ড', [BuyerController::class, 'dashboard'])->name('buyer.dashboard');
    Route::get('/পণ্য-ব্রাউজ', [BuyerController::class, 'browseProducts'])->name('buyer.browse');
    Route::get('/পণ্য/{id}', [BuyerController::class, 'viewProduct'])->name('buyer.product');
    Route::post('/পণ্য/{id}/কেনা', [BuyerController::class, 'buyProduct'])->name('buyer.buy');
    Route::get('/আমার-অর্ডার', [BuyerController::class, 'myOrders'])->name('buyer.orders');
    Route::post('/অর্ডার/{id}/বাতিল', [BuyerController::class, 'cancelOrder'])->name('buyer.order.cancel');
});
