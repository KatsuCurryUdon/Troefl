<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use GuzzleHttp\Middleware;

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
    return view('home', [
        'title' => 'Home'
    ]);
});

Route::get('/material', function () {
    return view('material', [
        'title' => 'Material'
    ]);
});

Route::get('/quiz', function () {
    return view('quiz', [
        'title' => 'Quiz'
    ]);
});

Route::get('/quiz', [QuizController::class, 'index'])->middleware('auth');
Route::post('/quiz', [QuizController::class, 'submit'])->middleware('auth');
Route::get('/quiz/result', [QuizController::class, 'result'])->middleware('auth');

Route::get('/discussions', [DiscussionController::class, 'index']);
Route::get('discussions/show/{discussion:slug}', [DiscussionController::class, 'show']);
Route::delete('/discussions/show/{discussion:slug}', [DiscussionController::class, 'destroy'])->middleware('auth');

Route::get('/discussions/start-discussion', [DiscussionController::class, 'showCreatePage'])->middleware('auth');
Route::post('/discussions/start-discussion', [DiscussionController::class, 'store']);
Route::get('/generate-slug', [DiscussionController::class, 'generateSlug']);
Route::post('coments', [DiscussionController::class, 'storeComment'])->name('comments.storeComment');
Route::post('replies', [DiscussionController::class, 'storeReply'])->name('replies.storeReply');

Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');

Route::get('/profile/edit', [ProfileController::class, 'showUpdatePage'])->middleware('auth');
Route::post('/profile/update', [ProfileController::class, 'update'])->middleware('auth');

Route::get('/profile/scores', [ProfileController::class, 'showScore'])->middleware('auth');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);
