<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

Route::prefix('users')->name('users.')->group(function(){
    Route::get('/', [UserController::class, 'index'])->name('index');

    Route::get('add', [UserController::class, 'add'])->name('add');

    Route::post('add', [UserController::class, 'postAdd']);

    Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');

    Route::post('edit/{id}', [UserController::class, 'postEdit']);

    Route::post('delete/{id}', [UserController::class, 'delete'])->name('delete');

    Route::post('delete-selection', [UserController::class, 'deletes'])->name('deletes');
});
