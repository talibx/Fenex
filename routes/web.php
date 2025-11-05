<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\TransactionController;
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

Route::resource('products', ProductController::class)->middleware(['auth', 'verified']);
Route::resource('inventories', InventoryController::class)->middleware(['auth', 'verified']);
Route::resource('sales', SaleController::class)->middleware(['auth', 'verified']);
Route::resource('deductions', DeductionController::class)->middleware(['auth', 'verified']);
Route::resource('notes', NoteController::class)->middleware(['auth', 'verified']);
Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics')->middleware(['auth', 'verified']);
Route::resource('transactions', TransactionController::class)->middleware(['auth', 'verified']);



//  Route::get('/', function () {
//      return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
