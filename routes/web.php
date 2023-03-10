<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Rotta per l'autenticazione gestita automaticamente da Laravel
Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')
    //se si va a qualunque indirizzo .admin torna alla pagina di login
    ->namespace('Admin')
    ->name('admin.')
    ->prefix('admin')
    //se si è autenticato va alla home di admin
    ->group(function() {
        //home
        Route::get('/', 'HomeController@index')->name('index');
        //rotta per la gestione dei POSTS
        Route::resource('/posts', 'PostController');
    });



// route di FALLBACK se non ci sono altre rotte allora va in guest.home
Route::get('{any?}', function(){
    return view('guest.home');

})->where('any', '.*');
