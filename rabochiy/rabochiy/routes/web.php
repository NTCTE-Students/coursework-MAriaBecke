<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Middleware\CheckPostAuthor;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('posts', PostController::class);

Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::resource('posts', PostController::class);


Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit')->middleware('auth', 'check.post.author');
Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update')->middleware('auth', 'check.post.author');



Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/drafts', [PostController::class, 'drafts'])->name('posts.drafts');






Route::put('posts/{post}', [PostController::class, 'update'])
    ->name('posts.update')
    ->middleware(['auth', CheckPostAuthor::class]);

require __DIR__.'/auth.php';
