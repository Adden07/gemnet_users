<?php

//auth routes for normal user

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes(['verify' => false, 'register' => false, 'reset' => false]);

//admin auth routes
Route::prefix('/')->namespace('Auth')->group(function () {
    Route::get('/login', 'AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/logout', 'AdminLoginController@logout')->name('admin.logout');
    Route::post('/login', 'AdminLoginController@login')->name('admin.login.submit');
});

//pages route
Route::namespace('Administrator')->middleware('auth:web')->name('admin.')->group(function () {
    
    Route::get('/', 'HomeController@index')->name('home');
    
    //activity log routes
    Route::get('/activity-logs','ActivityLogController@index')->name('activity_logs.index');
    
    //profile routes
    Route::prefix('profile')->name('profiles.')->group(function(){
        Route::get('/','ProfileController@index')->name('index');
        Route::post('/update-password','ProfileController@updatePassword')->name('update_password');
        Route::get('/disable-user/{id}','ProfileController@disableUser')->name('disable_user');
        Route::get('/enable-user/{id}','ProfileController@EnableUser')->name('enable_user');
    }); 
    
     //notifications
    Route::get('/notifications', 'NotificationsController@index')->name('notifications');
    Route::post('/notifications/clear/all', 'NotificationsController@clear')->name('notifications.clear_all');
    Route::get('/notifications/clear/{id}', 'NotificationsController@clear')->name('notifications.clear');
    Route::get('/notifications/delete/{id}', 'NotificationsController@delete')->name('notifications.delete');

});

Route::get('/errors/{method}', 'ErrorController@index');
