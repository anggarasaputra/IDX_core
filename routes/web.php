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
    Route::get('order-gallery/', 'Backend\OrderGalleryController@index')->name('admin.order-gallery.index');
    Route::put('order-gallery/approve/{id}', 'Backend\OrderGalleryController@approve')->name('admin.order-gallery.approve');
    Route::put('order-gallery/reject/{id}', 'Backend\OrderGalleryController@reject')->name('admin.order-gallery.reject');
});

/**
 * User routes
 */
Route::group(['prefix' => 'user'], function () {
    Route::get('/', 'User\DashboardController@index')->name('user.dashboard');

    /**
     * Route Rooms User
     */
    Route::get('/rooms', 'User\OrderRoomsController@index')->name('user.rooms');

    /**
     * Route Gallery User
     */
    Route::get('/gallery', 'User\OrderGalleryController@index')->name('user.gallery');
    Route::get('/gallery/order', 'User\OrderGalleryController@orderIndex')->name('user.gallery.order-index');
    Route::get('/gallery/{gallery}', 'User\OrderGalleryController@detail')->name('user.gallery.detail');
    Route::post('/gallery', 'User\OrderGalleryController@order')->name('user.gallery.order');
    Route::get('/gallery/qr-code/{gallery}', 'User\OrderGalleryController@qrCode')->name('user.gallery.qr-code');
    Route::post('/gallery/qr-code-ajax', 'User\OrderGalleryController@qrCodeAjax')->name('user.gallery.qr-code-ajax');
    Route::get('/gallery/calendar/{gallery}', 'User\OrderGalleryController@calendar')->name('user.gallery.calendar');
    Route::post('/gallery/calendar-ajax', 'User\OrderGalleryController@calendarAjax')->name('user.gallery.calendar-ajax');
});
