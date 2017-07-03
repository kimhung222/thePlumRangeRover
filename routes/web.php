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



Route::get('/login','LoginController@login');

/* Posts */
Route::get('/listgames',[
	'uses' => 'PagesController@listall'
	]);

Route::get('/new_post',[
	'uses' => 'PostsController@manual',
	'middleware' => 'auth'
	]);
Route::post('/new',[
	'uses' => 'PostsController@manual_create',
	'middleware' => 'auth'
	]);

Route::get('/posts',[
	'middleware' => 'auth',
	'uses' => 'PostsController@index'
	])->name('posts');
Route::get('/posts/new',[
	'uses' => 'PostsController@new',
	'middleware' => 'auth'
	]);
Route::post('/posts/create',[
	'uses' => 'PostsController@create',
	'middleware' => 'auth'
	]);
Route::get('/posts/make',[
	'uses' => 'PostsController@create_by_steam',
	'middleware' => 'auth'
	]);
Route::get('/posts/{post_id}/edit',[
	'uses' => 'PostsController@edit',
	'middleware' => 'auth'
	]);
Route::patch('/posts/{post_id}',[
	'uses' => 'PostsController@update',
	'middleware' => 'auth'
	]);
//* Retrieve
Route::post('/index_management/retrieve/{post_id}',[
	'uses' => 'PostsController@retrieve',
	'middleware' => 'auth'
	]);
// Route::get('/index_management',[
// 	'uses' => 'PostsController@indexmanagement',
// 	'middleware' => 'auth'
// 	]);
// Kien 2
Route::group(['prefix' => 'index_management', 'middleware' => 'auth'], function() {
    Route::get('/',[
        'uses' => 'PostsController@indexmanagement'
    ]);
    Route::post('/update', [
        'uses' => 'PostsController@updatePostStatus'
    ]);
    Route::post('/updateNeu', [
        'uses' => 'PostsController@updateNeu'
    ]);
 
    Route::get('/{status}', [
        'uses' => 'PostsController@getListGameByStatus'
    ]);
});
	// Kien
Route::group(['prefix' => '/listgames'], function() {
	Route::get('/',[
		'uses' => 'PagesController@listall'
	]);
	Route::get('/{genre}', [
		'uses' => 'PagesController@getListGameByGenre'
	]);
	Route::get('/filter/{value}',[
		'uses' => 'PagesController@filterListGame'
	]);
});
Route::get('/posts/{post_id}','PagesController@detail')->name('post_detail');

Route::get('/','PagesController@index');

Route::post('/crawl',[
	'uses' => 'PostsController@crawl',
	'middleware' => 'auth'
	]);

Route::post('post_name_search','PagesController@post_search');

Route::resource('posts','PostsController');

Route::get('/livesearch','PagesController@livesearch');
Route::get('/livesearch_index','PagesController@livesearch_index');
Route::get('/liveimg','PagesController@livesearch_image');
/* Gernes */

// Route::get('/gernes','GernesController@all');

/*Categories */

/* Other */

Route::get('/estimate','PagesController@estimate');
Route::post('/calculate','PagesController@calculate');
Route::get('/calculate','PagesController@calculate');
Route::get('/checkout','PagesController@checkout');
Route::get('/guide','PagesController@guide');

Auth::routes();




/* Test */

Route::get('/join','PagesController@join');
Route::get('/suggest','PagesController@suggest');
Route::get('/local','PagesController@test');

Route::post('/orders_search','OrdersController@order_search');
Route::resource('orders','OrdersController');
Route::post('/orders/create','PagesController@store');
