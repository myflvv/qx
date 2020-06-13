<?php

Route::get('/','index/login/index');
Route::post('login','index/login/login');
Route::group('admin',function (){
    Route::controller('main','index/main');
    Route::controller('team','index/team');
});

