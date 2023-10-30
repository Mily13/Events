<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\JoiningController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [EventController::class, 'getEvents'])->name('dashboard');
Route::get('/login', [UserController::class, 'loginPage'])->name('login');
Route::get('/signup', [UserController::class, 'signupPage'])->name('signup');
Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::get('/add-event', [EventController::class, 'eventForm'])->name('add-event');
Route::get('/modify-event-form', [EventController::class, 'modifyForm'])->name('modify-event-form');
Route::get('/filter', [EventController::class, 'getEventsFiltered'])->name('filter');
Route::post('/insert-event', [EventController::class, 'insert'])->name('insert-event');
Route::post('/process-login', [UserController::class, 'login'])->name('process-login');
Route::post('/process-signup', [UserController::class, 'signup'])->name('process-signup');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::post('/delete-join', [JoiningController::class, 'delete'])->name('delete-join');
Route::post('/delete-event', [EventController::class, 'delete'])->name('delete-event');
Route::post('/update-event', [EventController::class, 'update'])->name('update-event');


