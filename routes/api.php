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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['jwt.auth'], 'prefix' => 'v1'], function () {

    Route::post('/course', 'CourseController@store');
    Route::get('/course', 'CourseController@index');
    Route::post('/unit', 'UnitController@store');
    Route::get('/unit/{unit}', 'UnitController@show');
    Route::post('/unit/reorder-units', 'UnitController@reorderUnits');
    Route::get('/units/{id}', 'UnitController@getUnitsByCourse');
    Route::get('/users/{type}', 'UserController@index');
    Route::get('/user/{user}', 'UserController@show');
    Route::post('/user', 'UserController@store');
    Route::post('/user/edit/{user}', 'UserController@update');
    Route::post('/user/delete/{user}', 'UserController@destroy');
    Route::post('/user/addCourse/{user}', 'UserController@addCourse');
    Route::post('/slide', 'SlideController@store');
    Route::get('/slide/{slide}', 'SlideController@show');
    Route::post('/slide/edit/{id}', 'SlideController@edit');
    Route::post('/slide/delete/{id}', 'SlideController@delete');
    Route::post('/slide/reorder-slides', 'SlideController@reorderSlides');
    Route::post('/slide/user', 'SlideUserController@store');
    Route::post('/upload', 'UploadAttachmentController@upload');
});

Route::group(['middleware' => [], 'prefix' => 'auth'], function () {

    // Auth
    Route::post('/login', 'TokensController@login');
    Route::post('/refresh', 'TokensController@refreshToken');
    Route::get('/logout', 'TokensController@expireToken');
});



