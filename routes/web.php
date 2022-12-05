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
Route::post('/cheked/validate', 'CheckedController@validateBooking')->name('cheked.validate');
Route::get('/cheked/success/{kode_booking}', 'CheckedController@successValidate')->name('cheked.success');

/**
 * Auth routes
 */
Route::group(['prefix' => 'auth'], function () {
    // Login Routes
    Route::get('/login', 'Backend\Auth\LoginController@showLoginForm')->name('auth.login');
    Route::post('/login/submit', 'Backend\Auth\LoginController@login')->name('auth.login.submit');

    // Logout Routes
    Route::post('/logout/submit', 'Backend\Auth\LoginController@logout')->name('auth.logout.submit');

    // Forget Password Routes
    Route::get('/password/reset', 'Backend\Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.request');
    Route::post('/password/reset/submit', 'Backend\Auth\ForgotPasswordController@reset')->name('auth.password.update');
});

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
    Route::resource('activitylog', 'Backend\ActivitylogController', ['names' => 'admin.activitys']);
    //Route::get('/activitylog', [App\Http\Controllers\Backend\SettingController::class, 'index']);

    /**
     * Routes Floor (lantai)
     */
    Route::resource('floor', 'Backend\FloorController', ['names' => 'admin.floor']);

    /**
     * Routes Rooms (ruangan)
     */
    Route::resource('rooms', 'Backend\RoomsController', ['names' => 'admin.rooms']);

    /**
     * Routes Gallery
     */
    Route::resource('gallery', 'Backend\GalleryController', ['names' => 'admin.gallery']);
});

/**
 * User routes
 */
Route::group(['prefix' => 'user'], function () {
    Route::get('/', 'User\DashboardController@index')->name('user.dashboard');
    Route::get('/rooms', 'User\OrderRoomsController@index')->name('user.rooms');
    Route::get('/gallery', 'User\OrderGalleryController@index')->name('user.gallery');
});
