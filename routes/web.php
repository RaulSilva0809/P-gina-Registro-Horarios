<?php

use App\Http\Controllers\ProductosController;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
     return view('welcome');
 });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/usuariostable', [App\Http\Controllers\UserController::class, 'index'])->name('usuariostable');
Route::get('/usuariosedit', [App\Http\Controllers\UserController::class, 'update'])->name('usuariosedit');
Route::get('/usuariosregis', [App\Http\Controllers\UserController::class, 'create'])->name('usuariosregis');


Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

//Rutas para Editar Perfil 
Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('perfil', ['as' => 'users.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('perfil', ['as' => 'users.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('perfil/password', ['as' => 'users.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

// //Ruta de Usuarios
// Route::get('/usuarios', 'App\Http\Controllers\UserController@index')->name('usuariostable')->middleware('auth');
// Route::get('/usuarioregis', 'App\Http\Controllers\UserController@create')->name('usuariosregis')->middleware('auth');
// Route::get('/usuarioedit', 'App\Http\Controllers\UserController@update')->name('usuariosedit')->middleware('auth');

//Ruta usuarios
Route::resource('/usuarios', 'App\Http\Controllers\UserController')->middleware('auth');
//Rutas Roles
Route::resource('/roles', 'App\Http\Controllers\RolesController')->middleware('auth');

//Rutas horas
Route::resource('/horas', 'App\Http\Controllers\HorasController')->middleware('auth');
Route::get('/horastable', [App\Http\Controllers\HorasController::class, 'index'])->name('horast');




Route::resource('/entrada', 'App\Http\Controllers\EntradaController')->middleware('auth');

Route::get('/entrada', 'App\Http\Controllers\HorasController@entrada')->middleware('auth');
Route::get('/iniciocomida', 'App\Http\Controllers\HorasController@iniciocomida')->middleware('auth');
Route::get('/finalcomida', 'App\Http\Controllers\HorasController@finalcomida')->middleware('auth');
Route::get('/salida', 'App\Http\Controllers\HorasController@salida')->middleware('auth');

Route::get('/homeoffice', 'App\Http\Controllers\HorasController@homeoffice')->middleware('auth');
Route::get('/conteohoras', 'App\Http\Controllers\HorasController@conteohoras')->middleware('auth');
Route::get('/conteohorastabla', 'App\Http\Controllers\HorasController@conteohorastabla')->middleware('auth');

Route::get('/tusregistros', 'App\Http\Controllers\HorasController@tusregistros')->middleware('auth');





Route::get('/login/{email}/{password}', function ($email, $password) {
	return view('auth.login', compact(['email', 'password']));
});


//PDF

Route::get('/pdf','App\Http\Controllers\HorasController@PDF')->name('pdf');

//EXCEL

Route::get('/excel','App\Http\Controllers\HorasController@EXCEL')->name('excel');