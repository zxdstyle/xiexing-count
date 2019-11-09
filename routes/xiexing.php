<?php

use Illuminate\Support\Facades\Route;


Route::get(config('xiexing.count.route'), 'CountController@index')->name('count');
