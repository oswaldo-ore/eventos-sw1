<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\Fotografo\EventoController as FotografoEventoController;
use App\Http\Controllers\Fotografo\FotografoHome;
use App\Http\Controllers\Fotografo\SubscriptionController;
use App\Http\Controllers\Fotografo\UploadPhotos;
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


Route::get('/login/fotografo', [LoginController::class, 'showFotografoLoginForm'])->name('login.fotografo');
Route::get('/register/fotografo', [RegisterController::class, 'showFotografoRegisterForm'])->name('register.fotografo');
Route::post('/login/fotografo', [LoginController::class, 'fotografoLogin'])->name('login.fotografo');
Route::post('/register/fotografo', [RegisterController::class, 'createFotografo'])->name('register.fotografo');


Route::group(['middleware' => 'auth:fotografo', "prefix" => 'fotografo'], function () {
    Route::get('/', [FotografoHome::class, 'index']);
    Route::get('/eventos', [FotografoEventoController::class, 'index'])->name('fotografo.evento.index');
    Route::get('/eventos/{evento}/detalles', [FotografoEventoController::class, 'verDetalles'])->name('fotografo.evento.details');
    Route::get('/eventos/{evento}/subscribe', [FotografoEventoController::class, 'subscribe'])->name('fotografo.evento.subscribe');
    //Route::get('/', [FotografoHome::class, 'index']);


    Route::get('/subscription', [SubscriptionController::class, 'index'])->name('fotografo.subscription');

    Route::get('/subscription/{evento}/uploadPhotoPage', [SubscriptionController::class, 'uploadPhotoPage'])->name('fotografo.subscription.upload-photo');
    Route::post('/upload-photos/{evento}/savePhotos', [UploadPhotos::class, 'savePhotos'])->name('fotografo.subscription.save-photos');
});


Route::resource('evento', EventoController::class);
Route::get('/evento/{evento}/postulantes', [EventoController::class, 'show'])->name('evento.postulantes');
Route::get('/evento/{evento}/postulantes/{fotografo}', [EventoController::class, 'aceptarFotografo'])->name('evento.postulantes.aceptar');
Route::get('/album', [AlbumController::class, "index"])->name("album.index");
Route::get('/album/{evento}', [AlbumController::class, "photoEvento"])->name("album.photos");

Route::get('/mark-notification/{evento}/notification/{id}', [AlbumController::class, "markAsNotification"])->name("mark.notification");
