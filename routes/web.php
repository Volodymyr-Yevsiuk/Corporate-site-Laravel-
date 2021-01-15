<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PortfoliosController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhotosController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('/', IndexController::class)->only(['index'])->names(['index' => 'home']);

Route::resource('portfolios', PortfoliosController::class)->parameters(['portfolios' => 'alias']);

Route::resource('articles', ArticlesController::class)->parameters(['articles' => 'alias']);

Route::get('articles/cat/{cat_alias?}', [ArticlesController::class, 'index'])->name('articlesCat')->where('cat_alias', '[\w-]+');

Route::resource('comment', CommentController::class)->only(['store']);

Route::match(['get', 'post'], '/contacts', [ContactsController::class, 'index'])->name('contacts');

Route::get('logout', [AuthController::class, 'logout']);

//admin
Route::group(['prefix' => 'admin', 'middleware'=>'auth'], function() {

    //admin
    Route::get('/', [\App\Http\Controllers\Admin\IndexController::class, 'index'])->name('adminIndex');

    // admin/articles
    Route::resource('adminArticles', \App\Http\Controllers\Admin\ArticlesController::class);

    // admin/permissions
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionsController::class);

    // admin/menus
    Route::resource('menus', \App\Http\Controllers\Admin\MenusController::class);

     // admin/users
    Route::resource('users', \App\Http\Controllers\Admin\UsersController::class);

});

Route::group(['prefix' => 'admin'], function () {
    Route::get('photos', [PhotosController::class, 'create']);
});