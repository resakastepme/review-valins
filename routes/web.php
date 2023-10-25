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

Route::get('/logout/{session}', function ($session) {
    Session::flush();

    if ($session == 'session-timeout') {
        return redirect()->to('/auth')->with('session-timeout', $session);
    } else {
        return redirect()->to('/auth');
    }

});

Route::get('/', function () {
    if (Session('username')) {

        if (Session('role') == 1) {
            return redirect()->to('/admin/dashboard');
        } else {
            return redirect()->to('/user/dashboard');
        }

    } else {
        return redirect()->route('login');
    }
});

Route::get('/auth', [AuthController::class, 'index'])->name('login');
Route::get('/auth/check', [AuthController::class, 'credCheck']);


Route::prefix('/admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard.index');
    });

});
