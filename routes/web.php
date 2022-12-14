<?php

use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@redirectAdmin')->name('index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/cheked/qrcode', 'CheckedController@index')->name('cheked.qrcode');

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
    Route::post('/qrcode', 'Backend\DashboardController@qrcode')->name('admin.dashboard.qrcode');
    Route::post('/event', 'Backend\DashboardController@event')->name('admin.dashboard.event');
    Route::resource('roles', 'Backend\RolesController', ['names' => 'admin.roles']);
    Route::resource('users', 'Backend\UsersController', ['names' => 'admin.users']);
    Route::resource('admins', 'Backend\AdminsController', ['names' => 'admin.admins']);
    Route::resource('hakakses', 'Backend\HakaksionsController', ['names' => 'admin.hakaksions']);
    Route::resource('gallery', 'Backend\GalleryController', ['names' => 'admin.gallery']);
    Route::resource('activitylog', 'Backend\ActivitylogController', ['names' => 'admin.activitys']);
    //Route::get('/activitylog', [App\Http\Controllers\Backend\SettingController::class, 'index']);

    /**
     * Routes Floor (lantai)
     */
    Route::resource('floor', 'Backend\FloorController', ['names' => 'admin.floor']);

    // Login Routes
    Route::get('/login', 'Backend\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login/submit', 'Backend\Auth\LoginController@login')->name('admin.login.submit');

    // Logout Routes
    Route::post('/logout/submit', 'Backend\Auth\LoginController@logout')->name('admin.logout.submit');

    // Forget Password Routes
    Route::get('/password/reset', 'Backend\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset/submit', 'Backend\Auth\ForgotPasswordController@reset')->name('admin.password.update');
});
