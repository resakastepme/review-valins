<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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

//NEXT BIKIN SESSION ATTEMPT

Route::get('/logout', function () {
    Session::flush();
    return redirect()->to('/auth');
});

Route::get('/', function () {
    return view('index');
});

Route::get('/auth', [AuthController::class, 'index'])->middleware('guest');
Route::get('/auth/check', [AuthController::class, 'credCheck'])->middleware('guest');

Route::get('/dashboard', function () {
    return view('dashboard.index');
});
