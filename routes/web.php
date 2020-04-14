<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'CheckInnController@index')->name('main-page');
Route::post('/check', 'CheckInnController@check')->name('check-inn');
