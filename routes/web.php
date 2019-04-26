<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

/*
|--------------------------------------------------------------------------
| Category
|--------------------------------------------------------------------------*/

	Route::resource('category','cPanel\CategoryController');

/*
|--------------------------------------------------------------------------
| Pic
|--------------------------------------------------------------------------*/

	Route::resource('/pic','cPanel\PicController');
	route::get('/getJson','cPanel\PicController@getJson');
/*
|--------------------------------------------------------------------------
| Category
|--------------------------------------------------------------------------*/

    Route::resource('/post','cPanel\PostController');
});

/*
|--------------------------------------------------------------------------
| FRONT END
|--------------------------------------------------------------------------*/
Route::get('front',function ()
{
    return view('front.index');
});

/*
|--------------------------------------------------------------------------
| POSTS OF FRONT END
|--------------------------------------------------------------------------*/
Route::get('/posts','front\PostController@index');
/*
|--------------------------------------------------------------------------
| Categories
|--------------------------------------------------------------------------*/
Route::resource('/front/category','front\CategoryController');
/*
|--------------------------------------------------------------------------
| Comments
|--------------------------------------------------------------------------*/
Route::resource('front/comment','front\CommentController');