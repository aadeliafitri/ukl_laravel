<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('petugas', 'UserController@register');
Route::post('login', 'UserController@login');

Route::middleware(['jwt.verify'])->group(function(){
//check login
Route::get('login/check' , "UserController@getAuthenticatedUser");

//petugas
Route::get('petugas', 'UserController@index');
Route::put('petugas/{id}', 'UserController@update');
Route::delete('petugas/{id}', 'UserController@delete');

//siswa
Route::get('siswa', 'SiswaController@index');
Route::post('siswa', 'SiswaController@store');
Route::put('siswa/{id}', 'SiswaController@update');
Route::delete('siswa/{id}', 'SiswaController@destroy');

//pelanggaran
Route::get('pelanggaran', 'PelanggaranController@index');
Route::post('pelanggaran', 'PelanggaranController@store');
Route::put('pelanggaran/{id}', 'PelanggaranController@update');
Route::delete('pelanggaran/{id}', 'PelanggaranController@destroy');

//poinsiswa
Route::get('poin', 'PoinController@index');
Route::post('poin', 'PoinController@store');
// Route::get('poin_siswa', 'PoinController@detail');
Route::post('poin_siswa', 'PoinController@find');
Route::put('poin/{id}', 'PoinController@update');
Route::delete('poin/{id}', 'PoinController@destroy');

//dashboard
Route::get('beranda/statistik', 'DashboardController@dashboard');
});