<?php

use Illuminate\Support\Facades\Route;




Route::get(config('xiexing.count.route'), 'CountController@index')->name('count');

Route::get(config('xiexing.evaluate.route'), 'EvaluateController@index')->name('evaluate');

# 落户自测数据转发
Route::post('score/store', 'EvaluateController@store');

# 积分计算器数据转发
Route::post('counter', 'CountController@store');
