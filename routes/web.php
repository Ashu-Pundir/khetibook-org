<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CropController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PriceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Public Routes
Route::get('/', function () {
    return view('auth.register');
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/register', [UserController::class, 'create'])->name('register.submit');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// Protected Routes (Require Login)
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [CropController::class, 'index'])->name('crop.dashboard');
    Route::post('/dashboard', [CropController::class, 'index'])->name('crop.submit');

    Route::get('/addcrop', [CropController::class, 'create'])->name('crop.addcrop');
    Route::post('/addcrop', [CropController::class, 'store'])->name('crop.store');

    // Add other crop-related routes here if needed
    Route::put('/crop/update/{id}', [CropController::class, 'update'])->name('crop.update');
    Route::get('/crop/edit/{id}', [CropController::class, 'edit'])->name('crop.edit');
    
    Route::delete('/crop/delete/{id}', [CropController::class, 'destroy'])->name('crop.delete');

    Route::get('/generate-pdf', [PDFController::class, 'createPDF'])->name('crops.pdf');
    Route::get('/admin/dashboard', [AdminController::class, 'show'])->name('admin.dashboard');
    

    Route::get('/admin/check-price', [PriceController::class, 'adminIndex'])->name('admincheck.price'); 
    Route::post('/admin/get-price', [PriceController::class, 'checkPriceForm'])->name('submit.admincheckprice');
});

// Admin Routes
Route::get('/admin', [AdminController::class, 'index'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin-login.submit');
Route::get('/admin/user-edit/{id}', [AdminController::class, 'viewUser'])->name('admin.users.show');
Route::get('/admin/user-delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.destroy');
Route::get('/admin/usersPdf',[PDFController::class , 'alluserPDF'])->name('admin.users.downloadPdf');
Route::get('/admin/allcrops',[PDFController::class , 'allcrops'])->name('admin.allcrops');
Route::put('/admin/users/{id}', [AdminController::class, 'userUpdate'])->name('admin.user.update');

// Update crop
Route::put('/admin/crops/{id}', [AdminController::class, 'userCropUpdate'])->name('admin.crop.update');

// Delete crop
Route::delete('/admin/crops/{id}', [AdminController::class, 'userCropDestroy'])->name('admin.crop.destroy');

// all users Summary
Route::get('/admin/user-crop-summary', [AdminController::class, 'userSummary'])->name('admin.userCropSummary');

Route::get('/admin/allUserSummaryPdf', [PDFController::class, 'userCropSummaryPdf'])->name('admin.allUserSummaryPdf');

Route::post('/admin/crops/createcrop', [AdminController::class, 'createCrop'])->name('admin.crop.store');


Route::get('/check-price', [PriceController::class, 'index'])->name('check.price'); 
Route::post('/get-price', [PriceController::class, 'checkPriceForm'])->name('submit.checkprice');

Route::get('/user/update', [UserController::class, 'UpdateUser'])->name('user.update');


Route::get('/admin/check-price', [PriceController::class, 'index'])->name('admincheck.price'); // For the dropdown 

