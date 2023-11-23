<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BeriTugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $q = Data::selectRaw('distinct year(updated_at) as year')->get();
        $q2 = Data::select('witel')->distinct()->get();
        $q3 = Data::select('rekon')->distinct()->get();
        $q4 = Data::select('keterangan_aso')->distinct()->get();
        $q5 = Data::select('keterangan_ram3')->distinct()->get();

        return view('admin.beriTugas.index', [
            'updated_at' => $q,
            'witel' => $q2,
            'rekon' => $q3,
            'keterangan_aso' => $q4,
            'keterangan_ram3' => $q5
        ]);
    }

    public function quick(){
        return response()->json([
            'status' => 'ok'
        ]);
    }
}
