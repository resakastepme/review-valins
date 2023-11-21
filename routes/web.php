<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\PenggunaController;
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
        } elseif(Session('role') == 0) {
            return redirect()->to('/user/dashboard');
        }else{
            return redirect()->to('/aso/dashboard');
        }

    } else {
        return redirect()->route('login');
    }
});

Route::get('/getRole', [AuthController::class,'getRole']);
Route::get('/download/{parameter}', [DownloadController::class,'download']);
Route::post('/excelhandle', [ExcelController::class, 'process']);

Route::get('/auth', [AuthController::class, 'index'])->name('login');
Route::get('/auth/check', [AuthController::class, 'credCheck']);


Route::prefix('/admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard.index');
    });
    Route::get('/pengguna', [PenggunaController::class, 'index']);
    Route::get('/pengguna/getUser', [PenggunaController::class,'getUser']);
    Route::get('/pengguna/create', [PenggunaController::class,'create']);
    Route::get('/pengguna/editIndex', [PenggunaController::class,'getUserEdit']);
    Route::post('/pengguna/update', [PenggunaController::class,'update']);
    Route::post('/pengguna/destroy', [PenggunaController::class,'destroy']);

    Route::get('/data', [DataController::class, 'index']);
    Route::post('/data/create', [DataController::class,'create']);
    Route::get('/data/getData', [DataController::class,'getData']);
    Route::get('/data/editIndex', [DataController::class,'getDataEdit']);
    Route::post('/data/update', [DataController::class,'update']);
    Route::post('/data/destroy', [DataController::class,'destroy']);
    Route::get('/data/preview', [DataController::class,'preview']);
    Route::get('/data/preview/batal', [DataController::class,'previewBatal']);
    Route::get('/data/preview/submit', [DataController::class, 'previewSubmit']);

});

// ROUTE FOR CHECK, DELETE LATER
Route::get('/check', function () {
    if(Session::has('preview_access')){
        return Session::get('preview_access');
    }else{
        return 'no';
    }
});
