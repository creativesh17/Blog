<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
| php artisan make:migration create_post_category_table
| php artisan make:migration create_post_tag_table
*/

Route::group(['middleware' => 'preventBackHistory'],function(){
    Auth::routes();
});

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// website
// Route::get('/', function () { return view('website.home'); })->name('web.home');
Route::get('/', 'HomeController@index')->name('web.home');
// Route::get('/website', 'WebsiteController@index')->name('web.index');

// Access Denied
Route::get('/access', 'Admin\DashboardController@access')->name('dashboard.access');


// Authenticated
Route::group(['middleware' => ['auth']], function() {
    Route::post('favorite/{post}/post', 'FavoriteController@add')->name('post.favorite');
    Route::post('comment/{post}', 'CommentsController@insert')->name('comment.submit');
});

// Admin 
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function() {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    
    Route::get('settings', 'SettingsController@index')->name('settings');
    Route::put('profile/update', 'SettingsController@updateProfile')->name('profile.update');
    Route::put('password/update', 'SettingsController@updatePassword')->name('password.update')->middleware('preventBackHistory');


    Route::resource('tag', 'TagController');
    Route::resource('category', 'CategoryController');
    Route::resource('post', 'PostController');

    Route::get('pending/post', 'PostController@pending')->name('post.pending');
    Route::put('post/{id}/approve', 'PostController@approval')->name('post.approve');

    Route::get('/subscriber', 'SubscriberController@index')->name('subscriber.all');
    Route::post('/subscriber/unpublish/{id}', 'SubscriberController@unpublish')->name('subscriber.unpublish');

    Route::get('authors', 'AuthorController@index')->name('author.all');
    Route::delete('authors/{id}', 'AuthorController@destroy')->name('author.destroy');

    Route::get('/favorite', 'FavoriteController@index')->name('favorite.all');

    Route::get('/comments', 'CommentsController@index')->name('comment.all');
    Route::delete('/comments/{id}', 'CommentsController@delete')->name('comment.delete');
});

// Author
Route::group(['as' => 'author.', 'prefix' => 'author', 'namespace' => 'Author', 'middleware' => ['auth', 'author']], function() {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('post', 'PostController');
    Route::get('settings', 'SettingsController@index')->name('settings');
    Route::put('profile/update', 'SettingsController@updateProfile')->name('profile.update');
    Route::put('password/update', 'SettingsController@updatePassword')->name('password.update')->middleware('preventBackHistory');

    Route::get('/favorite', 'FavoriteController@index')->name('favorite.all');

    Route::get('/comments', 'CommentsController@index')->name('comment.all');
    Route::delete('/comments/{id}', 'CommentsController@delete')->name('comment.delete');
});

Route::post('/subscriber', 'SubscriberController@insert')->name('subscriber.submit');
Route::get('/posts', 'PostController@index')->name('post.index');
Route::get('/post/{slug}', 'PostController@details')->name('post.details');
Route::get('/category/{slug}', 'PostController@postByCategory')->name('category.posts');
Route::get('/tag/{slug}', 'PostController@postByTag')->name('tag.posts');
Route::get('/search', 'SearchController@search')->name('search');
Route::get('profile/{username}', 'AuthorController@profile')->name('author.profile');
