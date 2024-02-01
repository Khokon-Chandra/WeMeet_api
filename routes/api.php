<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;
use App\Models\Chat;
use Illuminate\Http\Request;
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

Route::get('/user', [UserController::class, 'AuthUser'])->name('user.AuthUser');

// Chat Page
Route::get('/contacts',[ChatController::class,'contacts'])->name('chat.contacts');
Route::get('/messages/{user}',[ChatController::class,'index'])->name('chat.index');
Route::post('send_message/{user}',[ChatController::class,'store'])->name('chat.store');