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
    public function index(Request $r)
    {
        $post = Assignment::with('getUsers')->with('getReviewers')->where('reviewer', Session::get('id'))->orderby('id', 'DESC')->paginate(5);

        if ($r->ajax()) {
            return view('admin.tugas.lists', compact('post'));
        }

        return view('admin.tugas.index', compact('post'));
    }
}
