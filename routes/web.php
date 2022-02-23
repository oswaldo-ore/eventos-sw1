<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\Fotografo\EventoController as FotografoEventoController;
use App\Http\Controllers\Fotografo\FotografoHome;
use App\Http\Controllers\Fotografo\SubscriptionController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('fotografo')->group(function () {
});


Route::get('/login/fotografo', [LoginController::class, 'showFotografoLoginForm']);
Route::get('/register/fotografo', [RegisterController::class, 'showFotografoRegisterForm']);
Route::post('/login/fotografo', [LoginController::class, 'fotografoLogin']);
Route::post('/register/fotografo', [RegisterController::class, 'createFotografo']);


Route::group(['middleware' => 'auth:fotografo', "prefix" => 'fotografo'], function () {
    Route::get('/', [FotografoHome::class, 'index']);
    Route::get('/eventos', [FotografoEventoController::class, 'index'])->name('fotografo.evento.index');
    Route::get('/eventos/{evento}/detalles', [FotografoEventoController::class, 'verDetalles'])->name('fotografo.evento.details');
    Route::get('/eventos/{evento}/subscribe', [FotografoEventoController::class, 'subscribe'])->name('fotografo.evento.subscribe');
    //Route::get('/', [FotografoHome::class, 'index']);


    Route::get('/subscription', [SubscriptionController::class, 'index'])->name('fotografo.subscription');

    Route::get('/subscription/{evento}/uploadPhotoPage', [SubscriptionController::class, 'uploadPhotoPage'])->name('fotografo.subscription.upload-photo');
    Route::post('/subscription/{evento}/savePhotos', [SubscriptionController::class, 'savePhotos'])->name('fotografo.subscription.save-photos');
});


Route::resource('evento', EventoController::class);
