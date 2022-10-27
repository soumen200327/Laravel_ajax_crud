<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
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

Route::get('/',[EmployeeController::class,'index']);
Route::post('/store',[EmployeeController::class,'store'])->name('store');
Route::get('/fetchall',[EmployeeController::class,'fetchall']);
Route::get('/edit',[EmployeeController::class,'edit']);
Route::post('/Update',[EmployeeController::class,'Update'])->name('Update');
Route::delete('/delete', [EmployeeController::class, 'delete'])->name('delete');