<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', 'Auth\UserController@current');

    Route::post('settings/profile', 'Settings\ProfileController@update');
    Route::post('settings/profile/avatar/update', 'Settings\ProfileController@avatarUpdate');
    Route::post('settings/password', 'Settings\PasswordController@update');

    Route::post('oauth/{driver}/attach', 'Auth\OAuthController@redirectToProvider')->name('oauth.attach');
    Route::post('oauth/{driver}/detach', 'Auth\OAuthController@detach')->name('oauth.detach');

    Route::post('/{id}/{type}/subscribe', 'SubscriptionController@store')->name('sub.store');
    Route::post('/{id}/{type}/unsubscribe', 'SubscriptionController@destroy')->name('sub.destroy');

    Route::post('/notifications/subscribe/{type}/{id}', 'SubsNotifyController@store')->name('subsNotify.store');
    Route::post('/notifications/unsubscribe/{type}/{id}', 'SubsNotifyController@destroy')->name('subsNotify.destroy');

    Route::post('/ignore/store/{type}/{id}', 'IgnoreController@store')->name('ignore.store');
    Route::post('/ignore/destroy/{type}/{id}', 'IgnoreController@destroy')->name('ignore.destroy');

    Route::post('/{slug}/{type}/favorite/store', 'FavoriteController@store')->name('favorite.store');
    Route::post('/{slug}/{type}/favorite/destroy', 'FavoriteController@destroy')->name('favorite.destroy');

    Route::post('file/upload', 'CloudderController@upload');
    Route::post('file/destroy', 'CloudderController@destroy');

    Route::post('like', 'LikeController@like');
    Route::delete('like', 'LikeController@dislike');

    Route::post('bookmark', 'BookmarkController@create');
    Route::delete('bookmark', 'BookmarkController@destroy');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');
});

Route::get('posts', 'PostController@index')->name('posts.index');
Route::get('/post/{slug}', 'PostController@show')->name('post.show')->middleware(['visitor']);

Route::get('u/{slug}', 'Auth\UserController@show')->name('user.show');

Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');

Route::get('/subs', 'CategoryController@index')->name('subs.index');

Route::get('/{slug}/posts', 'CategoryController@posts')->name('category.posts');
Route::post('/{slug}/posts/store', 'PostController@store')->name('post.store');
Route::get('/post/{slug}/comments', 'PostController@comments')->name('comment.index');
Route::post('/comment/store', 'CommentController@store')->name('comment.add');
Route::post('/reply/store', 'CommentController@replyStore')->name('reply.add');

Route::get('/{slug}/details', 'CategoryController@details')->name('category.details');
Route::get('/{slug}/details/subscribers', 'CategoryController@subscribers')->name('category.subscribers');

Route::get('u/{slug}/details', 'Auth\UserController@details')->name('user.details');
Route::get('u/{slug}/details/subscribers', 'Auth\UserController@subscribers')->name('user.subscribers');
Route::get('u/{slug}/details/subscriptions', 'Auth\UserController@subscriptions')->name('user.subscriptions');
Route::get('u/{slug}/posts', 'Auth\UserController@posts')->name('user.posts');
