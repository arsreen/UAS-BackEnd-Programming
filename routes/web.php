<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LaundryCategoryController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaundryController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/home', [AuthController::class, 'home'])->middleware('auth');
Route::get('/laundry-category', [LaundryCategoryController::class, 'index'])->name('laundry.category');
Route::post('/laundry-category', [LaundryCategoryController::class, 'store']);
Route::post('/laundry-category/delete', [LaundryCategoryController::class, 'destroy']);
Route::get('/supplies', [SupplyController::class, 'index']);
Route::post('/supplies', [SupplyController::class, 'store']);
Route::delete('/supplies/{id}', [SupplyController::class, 'destroy']);
// Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
// Route::delete('/inventory/{id}', [InventoryController::class, 'destroy']);
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// Route::get('/users', [UserController::class, 'index'])->name('users.index');
// Route::delete('/users/{id}', [UserController::class, 'destroy']);

Route::get('/laundry', [LaundryController::class, 'index'])->name('laundry.index');
Route::delete('/laundry/{id}', [LaundryController::class, 'destroy']);
Route::get('/laundry', [LaundryController::class, 'index'])->name('laundry.index');
Route::get('/laundry/create', [LaundryController::class, 'create'])->name('laundry.create');
Route::get('/laundry/{id}/edit', [LaundryController::class, 'edit'])->name('laundry.edit');
Route::post('/laundry', [LaundryController::class, 'store'])->name('laundry.store');
Route::delete('/laundry/{id}', [LaundryController::class, 'destroy']);

Route::resource('inventory', InventoryController::class);
Route::resource('users', UserController::class);

// Route::resource('laundry', LaundryController::class);
