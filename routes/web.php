<?php

use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// for admin

Route::prefix('/admin')->group(function() {

    // Admin Dashboard
    Route::view('/dashboard','admin.adminDashboard')->name('admin.dashboard');

    // User management
    Route::resource('/users', UserManagementController::class);
    Route::post('/users/change-status/{id}',[UserManagementController::class,'statusChange'])->name('users.change-status');
    Route::post('/users/bulk-delete',[UserManagementController::class,'bulkDelete'])->name('users.bulk-delete');
    Route::post('/users/bulk-active',[UserManagementController::class,'bulkActive'])->name('users.bulk-active');
    Route::post('/users/bulk-inactive',[UserManagementController::class,'bulkInactive'])->name('users.bulk-inactive');

    // Area Management
    Route::resource('/areas', AreaController::class);

});

// Route::resource('user', TestController::class);

require __DIR__.'/auth.php';
