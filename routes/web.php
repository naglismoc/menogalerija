<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'categories'], function(){
        Route::get('/index', [App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');
        Route::get('/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('category.create');
        Route::get('/edit/{category}', [App\Http\Controllers\CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/update/{category}', [App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');
        Route::post('/store/', [App\Http\Controllers\CategoryController::class, 'store'])->name('category.store');
        Route::post('/destroy/{category}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('category.destroy');
      });
  
    });

    Route::group(['prefix' => 'art'], function(){
      Route::get('/public', [App\Http\Controllers\ArtController::class, 'public'])->name('art.public');
      Route::get('/index', [App\Http\Controllers\ArtController::class, 'index'])->name('art.index');
      Route::get('/singleUser', [App\Http\Controllers\ArtController::class, 'singleUser'])->name('art.singleUser');
        Route::group(['middleware' => ['auth']], function () {
            Route::get('/create', [App\Http\Controllers\ArtController::class, 'create'])->name('art.create');
            Route::get('/edit/{art}', [App\Http\Controllers\ArtController::class, 'edit'])->name('art.edit');
            Route::post('/update/{art}', [App\Http\Controllers\ArtController::class, 'update'])->name('art.update');
            Route::post('/store/', [App\Http\Controllers\ArtController::class, 'store'])->name('art.store');
            Route::post('/destroy/{art}', [App\Http\Controllers\ArtController::class, 'destroy'])->name('art.destroy');
            Route::post('/disable/{art}', [App\Http\Controllers\ArtController::class, 'disable'])->name('art.disable');
            Route::post('/enable/{art}', [App\Http\Controllers\ArtController::class, 'enable'])->name('art.enable');
          });
      
        });

  
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
