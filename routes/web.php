<?php

use App\Http\Controllers\CustomLoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ######################################################################################################

Route::get('/login', [CustomLoginController::class, 'Login'])->name('login');

Route::post('/custom-logout', [CustomLoginController::class, 'logout']);

Route::post('/login/verify-user', [CustomLoginController::class, 'checkUser']);

Route::post('/rate-post', [PostController::class, 'ratingPost']);

Route::get('/search', [PostController::class, 'search'])->name('search');

Route::get('/', [PostController::class, 'home'])->name('home');

Route::feeds();

Route::get('/latest-posts', [PostController::class, 'latestPosts']);

Route::get('/{category_slug}', [PostController::class, 'getCategory']);

Route::get('/{category_slug}/{post_slug}', [PostController::class, 'getPostByCategory'])
    ->middleware('trackview')
    ->name('post.show');
