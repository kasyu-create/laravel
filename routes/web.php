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

// Route::get('/', function () {
//     return view('welcome');
// });
Auth::routes(); 
//vendor/laravel/framework/src/Illuminate/Routing/Router.phpに記述されているauthメソッドを呼び出してる
Route::get('/', 'ArticleController@index')->name('articles.index');
Route::resource('/articles','ArticleController')->except(['index','show'])->middleware('auth');
//Laravelにはミドルウェアという仕組みがあり、クライアントからのリクエストに対して、リクエストをコントローラーで処理する前あるいは後のタイミングで何らかの処理を行うことができます。
//authミドルウェアは、リクエストをコントローラーで処理する前にユーザーがログイン済みであるかどうかをチェックし、ログインしていなければユーザーをログイン画面へリダイレクトします。既にログイン済みであれば、コントローラーでの処理が行われます。
//各ルーティングでどのようなミドルウェアが使われているかは、php artisan route:listで確認することもできます。
//authミドルウェアの設定は、app/Http/Middlewareディレクトリの、Authenticate.php
Route::resource('/articles', 'ArticleController')->only(['show']);
Route::prefix('articles')->name('articles.')->group(function () {
  Route::put('/{article}/like', 'ArticleController@like')->name('like')->middleware('auth');
  Route::delete('/{article}/like', 'ArticleController@unlike')->name('unlike')->middleware('auth');
});
Route::get('/tags/{name}', 'TagController@show')->name('tags.show');
Route::prefix('users')->name('users.')->group(function () {
  Route::get('/{name}', 'UserController@show')->name('show');
  Route::get('/{name}/likes', 'UserController@likes')->name('likes');
  Route::get('/{name}/followings', 'UserController@followings')->name('followings');
    Route::get('/{name}/followers', 'UserController@followers')->name('followers');
Route::middleware('auth')->group(function () {
  Route::put('/{name}/follow', 'UserController@follow')->name('follow');
  Route::delete('/{name}/follow', 'UserController@unfollow')->name('unfollow');
});
});