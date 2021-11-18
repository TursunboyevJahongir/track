<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/**
 * Login / Register
 */
Route::prefix('auth')->group(static function () {
    Route::post('register', [AuthController::class, 'registration']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::get('category', [CategoryController::class, 'index']);
Route::get('category/{id}/products', [CategoryController::class, 'products']);
Route::get('product/{id}', [ProductController::class, 'show']);
Route::get('product/{id}/similar', [ProductController::class, 'similar']);
Route::get('search/{string}', [ProductController::class, 'search']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::get('me', [UserController::class, 'me']);
    Route::put('me', [UserController::class, 'updateProfile']);
    Route::prefix('admin')->group(function () {

        Route::get('user', [UserController::class, 'index'])->middleware('can:read user');
        Route::get('user/{id}', [UserController::class, 'show'])->middleware('can:read user');
        Route::post('user', [UserController::class, 'create'])->middleware('can:create user');
        Route::put('user', [UserController::class, 'update'])->middleware('can:update user');
        Route::delete('user/{id}', [UserController::class, 'delete'])->middleware('can:delete user');

        Route::get('roles', [RoleController::class, 'index'])->middleware('can:read role');
        Route::get('permissions', [RoleController::class, 'permissions'])->middleware('can:read role');
        Route::get('role/{name}', [RoleController::class, 'show'])->middleware('can:read role');
        Route::post('role', [RoleController::class, 'create'])->middleware('can:create role');
        Route::put('role/{name}', [RoleController::class, 'update'])->middleware('can:update role');
        Route::delete('role/{name}', [RoleController::class, 'delete'])->middleware('can:delete role');

        Route::get('categories', [CategoryController::class, 'categories'])->middleware('can:read category');
        Route::post('category', [CategoryController::class, 'create'])->middleware('can:create category');
        Route::put('category/update', [CategoryController::class, 'update'])->middleware('can:update category');
        Route::delete('category/{id}', [CategoryController::class, 'delete'])->middleware('can:delete category');

        Route::get('products', [ProductController::class, 'products'])->middleware('can:read product');
        Route::get('category/{id}/products', [CategoryController::class, 'AdminCategoryProducts'])->middleware('can:read product');
        Route::get('product/{id}', [ProductController::class, 'AdminShow'])->middleware('can:read product');
        Route::post('product', [ProductController::class, 'create'])->middleware('can:create product');
        Route::put('product/{id}', [ProductController::class, 'update'])->middleware('can:update product');
        Route::delete('product/{id}', [ProductController::class, 'delete'])->middleware('can:delete product');

    });
});
