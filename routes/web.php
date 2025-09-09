<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskListController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/share/{uuid}', [App\Http\Controllers\TaskListController::class, 'showPublic'])
    ->name('tasklists.public');

    Route::middleware('auth')->group(function () {
    Route::get('/shift-log', [App\Http\Controllers\TaskListController::class, 'showPublished'])
    ->name('tasklists.published');
    Route::patch('/tasklists/{tasklist}/publish', [App\Http\Controllers\TaskListController::class, 'publishForShift'])
    ->name('tasklists.publish');
    Route::get('/share-management', [App\Http\Controllers\TaskListController::class, 'shareManagement'])
    ->name('tasklists.shareManagement')
    ->middleware('admin');
    Route::patch('/tasklists/{tasklist}/toggle-sharing', [App\Http\Controllers\TaskListController::class, 'toggleSharing'])
    ->name('tasklists.toggleSharing')
    ->middleware('admin');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');
    
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('tasklists', TaskListController::class);
    Route::resource('tasklists.tasks', TaskController::class)->scoped()->shallow();
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
      Route::delete('/users/{user}', [App\Http\Controllers\Admin\DashboardController::class, 'destroy'])->name('users.destroy');
});



require __DIR__.'/auth.php';
