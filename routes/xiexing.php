<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Zxdstyle\Count\Http\Controllers',
    'prefix'     => config('xiexing.count.route.prefix'),
    'middleware' => 'web',
], function () {
    Route::get(config('xiexing.count.route'), 'CountController@index')->name('evaluate');
});

