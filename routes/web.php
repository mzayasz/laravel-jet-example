<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ShowPosts;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', ShowPosts::class)->name('dashboard');


Route::get('prueba', function () {
    return 'accediste correctamente!';
})->middleware(['auth:sanctum','age']);

Route::get('no-autorizado', function () {
    return 'usted no es mayor de edad';
})->name('no-autorizado');