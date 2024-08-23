<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrinterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', [PrinterController::class, 'index']);
Route::post('/send-to-printer', [PrinterController::class, 'sendToPrinter'])->name('send.to.printer');
