<?php

use Illuminate\Support\Facades\Route;


Route::get(config('count.route.route'), 'CountController@index')->name('count');
