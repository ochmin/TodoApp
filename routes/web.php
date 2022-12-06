<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

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

Route::middleware('isGuest')->group(function () {
    Route::get('/', [TodoController::class, 'login'])->name('login.index');
    Route::post('/login', [TodoController::class, 'auth'])->name('login.auth');
    Route::get('/register', [TodoController::class, 'register'])->name('register');
    Route::post('/register', [TodoController::class, 'registerAccount'])->name('register.createAccount');
});

Route::get('/logout', [TodoController::class, 'logout'])->name('logout');

Route::middleware('isLogin')->group(function () {
    Route::get('/dashboard', [TodoController::class, 'index'])->name('dashboard');
    Route::get('/create', [TodoController::class, 'create'])->name('create');
    Route::post('/store', [TodoController::class, 'store'])->name('store');
    Route::get('/data', [TodoController::class, 'data'])->name('data');
    Route::get('/edit/{id}', [TodoController::class, 'edit'])->name('edit');
    Route::patch('/update/{id}', [TodoController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [TodoController::class, 'destroy'])->name('destroy');
    Route::patch('/complated/{id}', [TodoController::class, 'UpdateToComplated'])->name('update-complated');
});
