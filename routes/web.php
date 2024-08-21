<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Panel\ManageUserController;

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

Route::get('/', function () {
    return redirect()->route('auth.login');
});

Route::group([
    'prefix' => 'auth',
    'as' => 'auth.'
], function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('store-login');
    Route::get('/logout', [LogoutController::class, 'destroySession'])->name('logout');
});

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth']
], function () {
    Route::get('/dashboard', fn () => view('admin.pages.dashboard'))->name('dashboard');
    Route::get('/profile', fn () => view('admin.pages.profile'))->name('profile');

    // Manage Users
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/', [ManageUserController::class, 'index'])
            ->name('index');
        Route::get('/create', [ManageUserController::class, 'create'])
            ->name('create');
        Route::post('/store', [ManageUserController::class, 'store'])
            ->name('store');
        Route::get('/{id}/edit', [ManageUserController::class, 'edit'])
            ->name('edit');
        Route::put('/{id}/update', [ManageUserController::class, 'update'])
            ->name('update');
        Route::delete('/{id}/delete', [ManageUserController::class, 'delete'])
            ->name('delete');
    });

});
