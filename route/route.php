<?php

Route::get('/','index/login/index');
Route::post('login','index/login/login');
Route::get('out','index/login/out');

Route::group('api',function (){
    Route::controller('user','api/user');
});

Route::group('admin',function (){
    Route::controller('main','index/main');
    Route::controller('team','index/team');
    Route::controller('sys','index/sys');
    Route::controller('user','index/user');
})->middleware('AdminAuth');

