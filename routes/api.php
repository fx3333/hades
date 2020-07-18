<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')
    ->namespace('Api')
    ->name('api.v1.')
    ->group(function() {

        //测试用
        Route::get('version', function() {
            return 'this is version v1';
        })->name('version');

        Route::post('media/imgStore', 'MediaController@imgStore')->name('media.imgStore');
        Route::get('media/calc', 'MediaController@calc')->name('media.calc');

        Route::prefix('user/')->group(function() {
            //用户注册
            Route::post('register', 'UserController@register')->name('user.register');
            //用户登录
            Route::post('login', 'UserController@login')->name('user.login');
            Route::post('authorizations/current', 'UserController@updateToken')->name('user.login');
            
        
            Route::middleware('api.refresh')->group(function() {
                //当前用户信息
                Route::get('info', 'UserController@info')->name('user.info');
                Route::post('changepw', 'UserController@changePw')->name('user.changepw');
                Route::post('update/{user}', 'UserController@update')->name('user.update');
                //用户退出
                Route::delete('authorizations/current', 'UserController@loginOut')->name('users.logout');
            });
        });
		
	});




