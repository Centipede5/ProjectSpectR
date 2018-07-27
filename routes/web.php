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

// Access Denied is for whenever a logged in user tries to access something they shouldn't
Route::get('/access-denied', function () {
    return view('errors.access-denied');
});

Route::get('/registration/{email}/{uniqid}', 'HomeController@validateEmail');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/demo', 'PostController@index');
Route::get('/demo/posts', 'PostController@index')->name('list_posts');

//prefix($x) adds $x to every route in the group
// name($x) assigns a "slug" shortlink
// ->middleware('can:create-post');
Route::prefix('demo/posts')->group(
    function () {
        Route::get('/drafts', 'PostController@drafts')
            ->name('list_drafts')
            ->middleware('auth');
        Route::get('/show/{id}', 'PostController@show')
            ->name('show_post');
        Route::get('/create', 'PostController@create')
            ->name('create_post')
            ->middleware('can:create-post');
        Route::post('/create', 'PostController@store')
            ->name('store_post')
            ->middleware('can:create-post');
        Route::get('/edit/{post}', 'PostController@edit')
            ->name('edit_post')
            ->middleware('can:update-post,post');
        Route::post('/edit/{post}', 'PostController@update')
            ->name('update_post')
            ->middleware('can:update-post,post');
        Route::get('/publish/{post}', 'PostController@publish')
            ->name('publish_post')
            ->middleware('can:publish-post');
        }
);

/* SUPER ADMIN */
Route::get('/super-admin', 'SuperAdminController@index')
    ->name('super_admin')
    ->middleware('auth');
