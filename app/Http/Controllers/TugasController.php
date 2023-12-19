<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use Illuminate\Support\Facades\Session;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $q = Assignment::where('reviewer', Session::get('id'))->get();
        dd($q);
        return view('admin.tugas.index');
    }
}
