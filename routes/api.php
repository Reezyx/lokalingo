<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::group(['middleware' => 'check.admin', 'prefix' => 'admin'], function () {
        Route::get('profile', [AdminController::class, 'profile']);
        Route::group(['prefix' => 'lang'], function () {
            Route::post('create', [AdminController::class, 'createLanguage']);
            Route::post('question/{level_id}', [AdminController::class, 'createQuestion']);
            Route::get('question/{level_id}', [AdminController::class, 'getQuestion']);
            Route::delete('question/{level_id}', [AdminController::class, 'deleteLevel']);
            Route::delete('question/item/{question_id}', [AdminController::class, 'deleteQuestionItem']);
        });
    });
});
