<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'PostsCsvController@index');

Route::post('/top_posts', 'PostsCsvController@topPostsDownload')->name('topPosts');

Route::post('/not_top_posts', 'PostsCsvController@notTopPostsDownload')->name('NotTopPosts');

Route::post('/daily_top_posts', 'PostsCsvController@dailyTopPostsDownload')->name('dailyTopPosts');

Route::post('/csv_upload', 'UploadCsvController@upload')->name('uploadCsv');