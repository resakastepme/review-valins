<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\BeriTugasController;
use App\Http\Controllers\TugasController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

//STORAGE:LINK ROUTE
// Route::get('/generate', function(){
//     \Illuminate\Support\Facades\Artisan::call('storage:link');
//     echo 'ok';
//  });

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
        }else{
            return redirect()->to('/user/dashboard');
        }
    } else {
        return redirect()->route('login');
    }
});

Route::get('/getRole', [AuthController::class, 'getRole']);
Route::get('/getUsername', [AuthController::class, 'getUsername']);
Route::get('/getId', [AuthController::class, 'getId']);
Route::get('/download/{parameter}', [DownloadController::class, 'download']);
Route::post('/excelhandle', [ExcelController::class, 'process']);

Route::get('/auth', [AuthController::class, 'index'])->name('login');
Route::get('/auth/check', [AuthController::class, 'credCheck']);


Route::prefix('/admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard.index');
    });
    Route::get('/pengguna', [PenggunaController::class, 'index']);
    Route::get('/pengguna/getUser', [PenggunaController::class, 'getUser']);
    Route::get('/pengguna/create', [PenggunaController::class, 'create']);
    Route::get('/pengguna/editIndex', [PenggunaController::class, 'getUserEdit']);
    Route::post('/pengguna/update', [PenggunaController::class, 'update']);
    Route::post('/pengguna/destroy', [PenggunaController::class, 'destroy']);

    Route::get('/data', [DataController::class, 'index']);
    Route::post('/data/create', [DataController::class, 'create']);
    Route::get('/data/getData', [DataController::class, 'getData']);
    Route::get('/data/editIndex', [DataController::class, 'getDataEdit']);
    Route::post('/data/update', [DataController::class, 'update']);
    Route::post('/data/destroy', [DataController::class, 'destroy']);
    Route::get('/data/preview', [DataController::class, 'preview']);
    Route::get('/data/preview/batal', [DataController::class, 'previewBatal']);
    Route::get('/data/preview/submit', [DataController::class, 'previewSubmit']);
    Route::get('/data/refresh', [DataController::class, 'refreshTable']);

    Route::get('/beriTugas', [BeriTugasController::class, 'index']);
    Route::get('/beriTugas/quick', [BeriTugasController::class, 'quick']);
    Route::get('/beriTugas/quickAssign', [BeriTugasController::class, 'quickAssign']);
    Route::get('/beriTugas/loadLists', function () {
        return response()->json(['view' => view('admin.beriTugas.lists')->render()]);
    });
    Route::get('/beriTugas/yeet', [BeriTugasController::class, 'yeet']);
    Route::get('/beriTugas/selectiveGet', [BeriTugasController::class, 'selectiveGet']);
    Route::post('/beriTugas/selectiveAssign', [BeriTugasController::class, 'selectiveAssign']);
    Route::get('/beriTugas/lihat', [BeriTugasController::class, 'lihat']);
    Route::get('/beriTugas/edit', [BeriTugasController::class, 'edit']);
    Route::get('/beriTugas/editValidation', [BeriTugasController::class, 'editValidation']);
    Route::post('/beriTugas/updateList', [BeriTugasController::class, 'updateList']);
    Route::get('/beriTugas/hapusList', [BeriTugasController::class, 'hapusList']);

    Route::get('/tugas', [TugasController::class, 'index']);
    Route::get('/tugas/data', [TugasController::class, 'data']);
    Route::get('/tugas/dataFinish', [TugasController::class, 'finish']);
    Route::get('/tugas/loadCard', [TugasController::class, 'loadCard']);
    Route::get('/tugas/dataChoosed', [TugasController::class, 'dataChoosed']);
    Route::post('/tugas/submitReview', [TugasController::class, 'submit']);
});

Route::prefix('/user')->group(function () {

    Route::get('/dashboard', function () {
        return view('user.dashboard.index');
    });

    Route::get('/data', [DataController::class, 'index_user']);
    Route::post('/data/create', [DataController::class, 'create']);
    Route::get('/data/getData', [DataController::class, 'getData']);
    Route::get('/data/refresh', [DataController::class, 'refreshTable']);

    Route::get('/tugas', [TugasController::class, 'index_user']);
    Route::get('/tugas/data', [TugasController::class, 'data']);
    Route::get('/tugas/dataFinish', [TugasController::class, 'finish']);
    Route::get('/tugas/loadCard', [TugasController::class, 'loadCard']);
    Route::get('/tugas/dataChoosed', [TugasController::class, 'dataChoosed']);
    Route::post('/tugas/submitReview', [TugasController::class, 'submit']);
});

// ROUTE FOR CHECK, DELETE LATER
Route::get('/check', function () {
    if (Session::has('role')) {
        return Session::get('role');
    } else {
        return 'no';
    }
});
