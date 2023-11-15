<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;

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
    return redirect("/posts");
});

Route::resource('posts', PostController::class);

Route::resource('categories', CategoryController::class);

Auth::routes();



// Route::get('/posts', function () {
//     return view('posts.index', [
//         "users" => User::all(),
//         "posts" => Post::all(),
//         "categories" => Category::all(),
//     ]);
// });

// Route::get('/posts/create', function () {
//     return view('posts.create');
// });

// Route::get('/posts/x', function () {
//     return view('posts.show');
// });

// Route::get('/posts/x/edit', function () {
//     return view('posts.edit');
// });

// // -----------------------------------------

// Route::get('/categories/create', function () {
//     return view('categories.create');
// });

// Route::get('/categories/x', function () {
//     return view('categories.show');
// });

// // -----------------------------------------

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
