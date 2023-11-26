<?php

namespace App\Http\Controllers;

use App\Models\Reviewer;
use App\Models\Assignment;
use App\Models\Data;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

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
        $qUser = User::where('username', '!=', Session::get('username'))->get();

        return view('admin.beriTugas.index', [
            'updated_at' => $q,
            'witel' => $q2,
            'rekon' => $q3,
            'keterangan_aso' => $q4,
            'keterangan_ram3' => $q5,
            'users' => $qUser
        ]);
    }

    public function quick()
    {
        $qtimestamp = $_GET['quickTimestamp'];
        $qwitel = $_GET['quickWitel'];
        $qrekon = $_GET['quickRekon'];
        $qaso = $_GET['quickAso'];
        $qketAso = $_GET['quickKetASO'];
        $qram3 = $_GET['quickRAM3'];
        $qketRam3 = $_GET['quickKetRAM3'];
        $query = Data::query();
        if ($qtimestamp != 'null') $query->where('created_at', 'LIKE', '%' . $qtimestamp . '%');
        if ($qwitel != 'null') $query->where('witel', $qwitel);
        if ($qrekon != 'null') $query->where('rekon', $qrekon);
        if ($qaso == 'kosong') {
            $query->where('approve_aso', null);
        } elseif ($qaso != 'semua') {
            $query->where('approve_aso', $qaso);
        }
        if ($qketAso == 'kosong') {
            $query->where('keterangan_aso', null)->orWhere('keterangan_aso', '-');
        } elseif ($qketAso != 'semua') {
            $query->where('keterangan_aso', $qketAso);
        }
        if ($qram3 == 'kosong') {
            $query->where('ram3', null);
        } elseif ($qram3 != 'semua') {
            $query->where('ram3', $qram3);
        }
        if ($qketRam3 == 'kosong') {
            $query->where('keterangan_ram3', null)->orWhere('keterangan_ram3', '-');
        } elseif ($qketRam3 != 'semua') {
            $query->where('keterangan_ram3', $qketRam3);
        }
        $data = $query->where('id_reviewer', null)->get();
        if ($data) {
            return response()->json([
                'status' => 'query success',
                'count' => count($data),
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 'Controller Not Working'
            ]);
        }
    }

    public function quickAssign()
    {
        try {
            $jumlahData = $_GET['jumlahData'];
            $assign = $_GET['assign'];
            $komentar = $_GET['komentar'];
            $komentarRill = $komentar;
            if ($komentar == null) $komentarRill = 'Tolong kerjakan ini ya~';
            $dataQuery = $_GET['dataQuery'];
            $unique = time() . Str::random(10);
            $reviewer = User::where('username', $assign)->first();
            $tugas_dari = User::where('username', Session::get('username'))->first();
            Assignment::create([
                'id_reviewer' => $unique,
                'reviewer' => $reviewer->id,
                'tugas_dari' => $tugas_dari->id,
                'komentar' => $komentarRill
            ]);
            $id_assignments = Assignment::where('id_reviewer', $unique)->first();
            $counters = 0;
            foreach ($dataQuery as $data) {
                Data::where('id', $data['id'])->update([
                    'id_reviewer' => $unique
                ]);
                Reviewer::create([
                    'id_assignments' => $id_assignments->id,
                    'id_datas' => $data['id']
                ]);
                $counters++;
                if ($counters == $jumlahData) break;
            }
            return response()->json([
                'status' => 'ok',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => $th->getMessage()
            ]);
        }
    }
}
