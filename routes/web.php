<?php

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
Route::get('/', 'HomeController@index')->name('home');







/*
* setting router for Admin 
* 
*  
*/

Route::prefix('admin')->group(function () {
    
    Route::post('login', ['as' => 'admin.login', 'uses' => 'Auth\AdminLoginController@login']);

    Route::get('login', function (){
        if(Auth::guard('admin')->check()){
            return redirect()->route('admin.index');
        }
        $controller = \App()->make('\App\Http\Controllers\Auth\AdminLoginController');
        return $controller->callAction('showLoginForm', $parameters = array());
    })->name('admin.login');
    Route::get('password/request', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
});


Route::group(['middleware' => ['is_admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    
    Route::get('/', 'Admin\AdminController@index')->name('index');

    Route::get('register','Auth\AdminLoginController@showRegisterPage');
    
});

