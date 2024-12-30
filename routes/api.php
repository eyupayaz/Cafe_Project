<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Models\Category;
use App\Models\Product;
use App\Models\Panel;
use App\Models\User;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\PanelController;
use App\Http\Controllers\Api\SearchController;


Route::resource('products', ProductController::class);

//login
Route::post('/admin/kayitol', [AuthController::class, 'register']);
Route::post('/admin/giris', [AuthController::class, 'login']);
Route::post('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/user', [UserController::class,'store']);


Route::middleware('auth:sanctum')->group(function () {
    // Kullanıcının panel bilgilerini döndür
    Route::get('/user/panel/{id}', [PanelController::class, 'getPanel']);
    Route::get('/categories/{id}', [PanelController::class, 'getCategories']);
    Route::get('/products/{id}', [PanelController::class, 'getProducts']);
    Route::resource('categories', CategoryController::class)->except(['index']); 
}); 

Route::get('/categories', [CategoryController::class, 'index']); //geçiçi çözüm olarak bu şekilde dışarı alındı 

Route::get('/search', [SearchController::class, 'search']);
