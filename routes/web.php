<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController; 
use App\Http\Controllers\OtotubusController; 
use App\Http\Controllers\UserFollowController; 
use App\Http\Controllers\FavoritesController;  // 追記


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

Route::get('/', [OtotubusController::class, 'index']);

Route::get('/dashboard', [OtotubusController::class, 'index'])->middleware(['auth'])->name('dashboard');

//投稿フォームへのルーティング
Route::get('/form', [OtotubusController::class, 'form'])->name('form');

Route::get('/ototubus',[UsersController::class,'all_show'])->name('users.all_show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'users/{id}'], function () {                                          // 追記
        Route::post('follow', [UserFollowController::class, 'store'])->name('user.follow');         // 追記
        Route::delete('unfollow', [UserFollowController::class, 'destroy'])->name('user.unfollow'); // 追記
        Route::get('followings', [UsersController::class, 'followings'])->name('users.followings'); // 追記
        Route::get('followers', [UsersController::class, 'followers'])->name('users.followers');    // 追記
        Route::get('favorites', [UsersController::class, 'favorites'])->name('users.favorites');
        Route::get('favorites2', [UsersController::class, 'favorites2'])->name('users.favorites2');
        Route::get('follow_ototubus',[OtotubusController::class,'follow_ototubus'])->name('follow_ototubus');
    });  
    Route::resource('users', UsersController::class, ['only' => ['index', 'show']]);
    Route::resource('ototubus', OtotubusController::class, ['only' => ['store', 'destroy']]);
    
    Route::group(['prefix' => 'ototubus/{id}'], function () {                                             // 追加
        Route::post('favorites', [FavoritesController::class, 'store'])->name('favorites.favorite');        // 追加
        Route::delete('unfavorite', [FavoritesController::class, 'destroy'])->name('favorites.unfavorite'); // 追加
    });      
});