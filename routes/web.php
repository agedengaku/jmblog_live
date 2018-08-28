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
//Home page
Route::get('/', 'PostsController@index');
//Categories
Route::get('/categories', 'CategoriesController@index');
Route::get('/category/{id}', 'CategoriesController@categoryIndex');
//Tags
Route::get('tag/{id}', 'TagsController@tagIndex');
// Search
Route::get('search/{s?}', 'SearchesController@getIndex')->where('s', '[\w\d]+');
//Admin post routes
Route::get('admin/posts/create', 'AdminPostsController@create');
Route::get('admin/posts/edit/{post}', 'AdminPostsController@edit');
Route::patch('admin/posts/edit/{post}', 'AdminPostsController@update')->name('update');
Route::delete('admin/posts/edit/{post}', 'AdminPostsController@destroy');
Route::post('admin/posts/create', 'AdminPostsController@store');
Route::get('admin/posts', 'AdminPostsController@index');
//Show post
Route::get('/post/{post}', 'PostsController@show');
Route::get('/getcomments', 'PostsController@getcomments');
//Admin comments routes
Route::get('admin/comments/', 'AdminCommentsController@index');
Route::get('admin/post/comments/{id}', 'AdminCommentsController@showPostComments');
Route::get('admin/comments/edit/{comment}', 'AdminCommentsController@edit');
Route::patch('admin/comments/edit/{comment}', 'AdminCommentsController@update')->name('comment-update');
Route::delete('admin/comments/edit/{comment}', 'AdminCommentsController@destroy');
//Comment store
// Route::post('comments/create', 'AdminCommentsController@store');
Route::post('comments/create', 'PostsController@storeComment');
//Delete comments from post
Route::delete('post-comment/delete', 'PostsController@destroyComment');
//Admin comment replies
Route::get('admin/replies', 'AdminRepliesController@index');
Route::get('admin/comment/replies/{id}', 'AdminRepliesController@showCommentReplies');
Route::get('admin/replies/edit/{reply}', 'AdminRepliesController@edit');
Route::patch('admin/replies/edit/{reply}', 'AdminRepliesController@update')->name('reply-update');
Route::delete('admin/replies/edit/{reply}', 'AdminRepliesController@destroy');
//Reply store
// Route::post('replies/create', 'AdminRepliesController@store');
Route::post('replies/create', 'PostsController@storeReply');
//Delete replies from post
Route::delete('post-reply/delete', 'PostsController@destroyReply');
//User routes
Route::get('admin/users', 'AdminUsersController@index');
Route::get('admin/users/create', 'AdminUsersController@create');
Route::post('admin/users/create', 'AdminUsersController@store');
Route::get('admin/users/edit/{user}', 'AdminUsersController@edit');
Route::patch('admin/users/edit/{user}', 'AdminUsersController@update')->name('update_user');
Route::delete('admin/users/edit/{user}', 'AdminUsersController@destroy');
//User settings
Route::get('admin/user-settings/{user}', 'AdminReadersController@user_settings');
Route::delete('admin/user-settings/{user}', 'AdminReadersController@destroy');
Route::patch('admin/user-settings/{user}', 'AdminReadersController@update')->name('update_from_settings');

//Show posts by category
// Route::get('/posts/category/{category}', 'PostsController@category');

Auth::routes();

Route::get('/admin', 'AdminController@index')->name('admin');

// Route::get('admin/categories/edit/{id}', 'AdminCategoriesController@edit');

Route::resource('admin/categories', 'AdminCategoriesController'
// , ['names' => [
// 	'index' => 'admin.categories.index',
// 	'show' => 'admin.categories.show',
// 	'edit' => 'admin.categories.edit',
// 	'update' => 'admin.categories.update',
// 	'store' => 'admin.categories.store',
// 	'destroy' => 'admin.categories.destroy'
// ]]
);

Route::get('admin/tags', 'AdminTagsController@index');
Route::get('admin/tags/{id}', 'AdminTagsController@show');
Route::post('admin/tags', 'AdminTagsController@store');
Route::get('admin/tags/{tag}/edit', 'AdminTagsController@edit');
Route::patch('admin/tags/{tag}/edit', 'AdminTagsController@update');
Route::delete('admin/tags', 'AdminTagsController@destroy');

Route::get('admin/media/error-redirect', 'AdminMediasController@errorRedirect');
Route::resource('admin/media', 'AdminMediasController');


Route::get('/verify/token/{token}', 'Auth\VerificationController@verify')->name('auth.verify'); 
Route::get('/verify/resend', 'Auth\VerificationController@resend')->name('auth.verify.resend');

Route::get('about', function() {
	return view('about');
});

Route::get('/logout', 'AdminController@destroy');
