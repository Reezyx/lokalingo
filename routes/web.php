<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;

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

Auth::routes();

Route::get('/', [HomeController::class, 'index']);
Route::get('/download-apps', [HomeController::class, 'downloadApps'])->name('download.apps');

Route::get('/admin/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/admin/login-store', [AuthController::class, 'adminLogin'])->name('login.store');

Route::group(['middleware' => 'auth'], function () {

  Route::group(["prefix" => "admin", "middleware" => "web.admin"], function () {
    Route::post('logout', [AuthController::class, 'adminLogout'])->name('logout');
    Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard.index');
    Route::get('profile', [HomeController::class, 'profile']);
    Route::get('language', [AdminController::class, 'getLanguage'])->name('dashboard.language');
    Route::get('user', [AdminController::class, 'getUser'])->name('user.all');
    Route::get('user-datatable', [AdminController::class, 'getDatatableUser'])->name('user.datatable');
  });
});

Route::group(['middleware' => 'auth'], function () {
  Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
  Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
  Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
  Route::get('upgrade', function () {
    return view('pages.upgrade');
  })->name('upgrade');
  Route::get('map', function () {
    return view('pages.maps');
  })->name('map');
  Route::get('icons', function () {
    return view('pages.icons');
  })->name('icons');
  Route::get('table-list', function () {
    return view('pages.tables');
  })->name('table');
  Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});
