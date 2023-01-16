<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ColorController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum', 'isAPIAdmin'])->group(function () {
    Route::get('/checkingAuthenticated', function () {
        return response()->json(['message' => 'You are in', 'status' => 200], 200);
    });

    Route::controller(CategoryController::class)->group(function(){
        Route::get('view-category', 'allCategories');
        Route::post('store-category', 'store');
        Route::get('edit-category/{category_name}', 'edit');
        Route::post('update-category/{category_name}', 'update');
        Route::delete('delete-category/{category_name}', 'destroy');
        Route::get('all-category', 'allCategories');
    });
    
    Route::controller(BrandController::class)->group(function(){
        Route::get('view-brand', 'allBrands');
        Route::post('store-brand', 'store');
        Route::get('edit-brand/{brand_name}', 'edit');
        Route::post('update-brand/{brand_name}', 'update');
        Route::delete('delete-brand/{brand_name}', 'destroy');
        Route::get('all-brand', 'allBrands');
    });
    
    Route::controller(ColorController::class)->group(function(){
        Route::get('view-color', 'allColors');
        Route::post('store-color', 'store');
        Route::delete('delete-color/{color_name}', 'destroy');
        Route::get('all-color', 'allColors');
    });
    
    // Route::controller(MaterialController::class)->group(function(){
    //     Route::get('view-material', 'allMaterials');
    //     Route::post('store-material', 'store');
    //     Route::delete('delete-material/{material_name}', 'destroy');
    //     Route::get('all-material', 'allMaterials');
    // });
    
    Route::controller(ProductController::class)->group(function(){
        Route::get('view-product', 'index');
        Route::get('create-product', 'create');
        Route::post('store-product', 'store');
        Route::get('edit-product/{id}', 'edit');
        Route::post('update-product/{id}', 'update');
        Route::delete('delete-product/{id}', 'destroy');
        Route::post('/product-color/{color_name}','updateProdColorQty');
        Route::delete('/product-color/{color_name}/delete','deleteProdColor');
    });
    
    Route::controller(BannerController::class)->group(function(){
        Route::post('store-banner', 'store');
        Route::get('view-banner', 'allBanner');
        Route::get('edit-banner/{id}', 'edit');
        Route::post('update-banner/{id}', 'update');
        Route::delete('delete-banner/{id}', 'destroy');
        Route::get('all-banner', 'allBanner');
    
    });
    // Route::controller(FrontendController::class)->group(function(){
    //     Route::get('get-allProduct', 'getProduct');
    //     Route::get('search/{product_name}', 'searchProducts');
    // });
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
