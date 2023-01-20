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

Route::get('/deputados', 'App\Http\Controllers\ValorController@salvarValor', function () {
    return view('deputados');
});

Route::get('/', 'App\Http\Controllers\RedeSociaisController@index', function () {
    return view('redeSociais');
});


