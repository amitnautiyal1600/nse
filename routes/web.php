<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController; 
use App\Http\Controllers\NiftyController; 
use App\Http\Controllers\BankNiftyController; 
use App\Http\Controllers\ChartController; 

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


Route::get('/', [NiftyController::class, 'niftyHome'])->name('niftyHome');

Route::get('/nifty', [NiftyController::class, 'niftyHome'])->name('niftyHome');
Route::get('/get-nifty-nse-data', [NiftyController::class, 'getNiftyNseData'])->name('getNiftyNseData'); //ajax
Route::get('/save-nifty-nse-data', [NiftyController::class, 'saveNiftyNseData'])->name('saveNiftyNseData'); //ajax

Route::get('/bank-nifty', [BankNiftyController::class, 'bankNiftyHome'])->name('bankNiftyHome'); 
Route::get('/get-bank-nifty-nse-data', [BankNiftyController::class, 'getBankNiftyNseData'])->name('getBankNiftyNseData'); //ajax
Route::get('/save-bank-nifty-nse-data', [BankNiftyController::class, 'saveBankNiftyNseData'])->name('saveBankNiftyNseData'); //ajax


Route::get('/charts', [ChartController::class, 'chartHome'])->name('chartHome');
Route::get('/chart-data', [ChartController::class, 'getChartData'])->name('getChartData');

 
