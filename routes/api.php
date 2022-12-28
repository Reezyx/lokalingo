<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;
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
Route::post('/google/login', [AuthController::class, 'googleLogin']);

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::group(['middleware' => 'check.admin', 'prefix' => 'admin'], function () {
        Route::get('profile', [AdminController::class, 'profile']);
        Route::group(['prefix' => 'lang'], function () {
            Route::post('create', [AdminController::class, 'createLanguage']);
            Route::get('all', [AdminController::class, 'getLanguage']);
            Route::get('level/{language_id}', [AdminController::class, 'getLevel']);
            Route::post('question/{level_id}', [AdminController::class, 'createQuestion']);
            Route::get('question/{level_id}', [AdminController::class, 'getQuestion']);
            Route::get('question/item/{question_id}', [AdminController::class, 'getQuestionItem']);
            Route::put('question/item/{question_id}', [AdminController::class, 'updateQuestionItem']);
            Route::delete('question/item/{question_id}', [AdminController::class, 'deleteQuestionItem']);
            Route::group(['prefix' => 'question/example'], function () {
                Route::post('/{level_id}', [AdminController::class, 'createQuestionExample']);
                Route::get('/{level_id}', [AdminController::class, 'getQuestionExample']);
            });
        });
    });

    Route::get('lang', [LanguageController::class, 'index']);
    Route::get('lang/question/{level_id}', [LanguageController::class, 'getQuestion']);
    Route::get('lang/question/example/{level_id}', [LanguageController::class, 'exampleQuestion']);
    Route::post('lang/answer/{level_id}', [LanguageController::class, 'answerQuestion']);
    Route::get('leaderboard', [LanguageController::class, 'leaderboard']);
});
