<?php

use App\Http\Controllers\ManageFilesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FileViewController;
use Illuminate\Support\Facades\Route;
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

// FILES
Route::post('/file',[FileController::class, 'getFiles'])->middleware(['auth','verified'])->name('files.create');

// VIEWS OF FILES
Route::get("/file",[FileViewController::class,'uploadFile'])->middleware(['auth','verified'])->name('filesViews.uploadFile');

// folders
Route::get("/folders",[ManageFilesController::class,'getUserFolders'])->middleware(['auth','verified'])->name('folders.getFolders');
Route::get('/folders/{id}',[ManageFilesController::class,'getUserFolder'])->middleware(['auth','verified'])->name('folders.getFolderById');


require __DIR__.'/auth.php';
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});