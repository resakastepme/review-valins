<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Data;
use App\Models\Reviewer;
use App\Models\Values;
use Illuminate\Support\Facades\Session;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $r)
    {
        $post = Assignment::with('getUsers')->with('getReviewers')->where('reviewer', Session::get('id'))->orderby('id', 'DESC')->paginate(5);
        $v = Values::get();

        if ($r->ajax()) {
            return view('admin.tugas.lists', compact('post'), ['values' => $v]);
        }

        return view('admin.tugas.index', compact('post'), ['values' => $v]);
    }

    public function index_user(Request $r)
    {
        $post = Assignment::with('getUsers')->with('getReviewers')->where('reviewer', Session::get('id'))->orderby('id', 'DESC')->paginate(5);
        $v = Values::get();

        if ($r->ajax()) {
            return view('admin.tugas.lists', compact('post'), ['values' => $v]);
        }

        return view('user.tugas.index', compact('post'), ['values' => $v]);
    }

    public function data()
    {
        try {
            $id = $_GET['id'];
            $q1 = Reviewer::with('getAssignment')->with('getData')->where('id_assignments', $id)->where('finish', 0)->get();
            return response()->json([
                'status' => 'ok',
                'datas' => $q1
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => $th->getMessage()
            ]);
        }
    }

    public function finish()
    {
        try {
            $id = $_GET['id'];
            $q1 = Reviewer::with('getAssignment')->with('getData')->where('id_assignments', $id)->where('finish', 1)->get();
            return response()->json([
                'status' => 'ok',
                'datas' => $q1
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => $th->getMessage()
            ]);
        }
    }

    public function loadCard()
    {
        try {
            $id = $_GET['id'];
            $q1 = Reviewer::with('getAssignment')->with('getData')->where('id_assignments', $id)->get();
            $selesai = Reviewer::where('id_assignments', $id)->where('finish', 1)->count();
            $belumSelesai = Reviewer::where('id_assignments', $id)->where('finish', 0)->count();
            $assignment = Assignment::with('getUsers')->with('getReviewer')->where('id', $id)->first();
            return response()->json([
                'status' => 'ok',
                'belum' => $belumSelesai,
                'selesai' => $selesai,
                'assignment' => $assignment,
                'datas' => $q1
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => $th->getMessage()
            ]);
        }
    }

    public function dataChoosed()
    {
        try {
            $id = $_GET['id'];
            $q = Data::where('id', $id)->first();

            return response()->json([
                'status' => 'ok',
                'datas' => $q
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => $th->getMessage()
            ]);
        }
    }

    public function submit()
    {
        try {
            $idData = $_POST['idData'];
            $idR = $_POST['idReviewer'];
            $ram3  = $_POST['ram3'];
            $ketRam3 = $_POST['ketRam3'];

            $updateData = [
                'ram3' => $ram3,
                'keterangan_ram3' => $ketRam3
            ];
            $updateR = [
                'finish' => 1
            ];

            Data::where('id', $idData)->update($updateData);
            Reviewer::where('id', $idR)->update($updateR);

            return response()->json([
                'status' => 'ok'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => $th->getMessage()
            ]);
        }
    }
}
