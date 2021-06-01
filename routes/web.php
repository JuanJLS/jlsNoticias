<?php

//use App\Http\Middleware\FilterMiddleware;
use App\Http\Controllers\BackendComentarioController;
use App\Http\Controllers\BackendNoticiaController;
use App\Http\Controllers\FrontendComentarioController;
use App\Http\Controllers\FrontendNoticiaController;
use App\Http\Controllers\HomeController;
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

Auth::routes(['verify' => true]);

Route::get('/',[FrontendNoticiaController::class, 'index'])->name('main');
Route::get('backend/comentario/{idnoticia}/comentarios', [BackendComentarioController::class, 'showComentarios'])->name('backend.comentario.showcomentarios');
Route::get('email/restore/{id}/{email}', [BackendNoticiaController::class, 'restoreEmail'])->name('email.restore')->middleware('signed');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('password/change', [BackendNoticiaController::class, 'changePassword'])->name('password.change')->middleware('verified');
Route::post('user/change', [BackendNoticiaController::class, 'changeUser'])->name('user.change')->middleware('verified');
Route::put('email/restore/{id}/{email}', [BackendNoticiaController::class, 'restorePreviousEmail'])->name('email.restore')->middleware('signed');

Route::resource('/backend/comentario', BackendComentarioController::class, ['names'=>'backend.comentario']);
Route::resource('backend/noticia', BackendNoticiaController::class, ['names' =>'backend.noticia'])->parameters(['noticia' => 'noticia']);
Route::resource('frontend/comentario', FrontendComentarioController::class, ['names' => 'frontend.comentario'])->only(['store', 'destroy']);
Route::resource('frontend/noticia', FrontendNoticiaController::class, ['names' => 'frontend.noticia'])->parameters(['noticia' => 'noticia'])->only(['index', 'show'])->middleware('filter');
Route::resource('backend/usuario', UserController::class, ['names' => 'backend.user'])->parameters(['usuario' =>'user']);

