<?php

namespace App\Http\Controllers;

use App\Models\Reviewer;
use App\Models\Assignment;
use App\Models\Data;
use App\Models\User;
use App\Models\Dumps;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BeriTugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $q = Data::selectRaw('distinct year(updated_at) as year')->get();
        $q2 = Data::select('witel')->distinct()->get();
        $q3 = Data::select('rekon')->distinct()->get();
        $q4 = Data::select('keterangan_aso')->distinct()->get();
        $q5 = Data::select('keterangan_ram3')->distinct()->get();
        $qUsers = User::where('username', '!=', Session::get('username'))->get();

        $post = Assignment::with('getUsers')->with('getReviewers')->orderby('id', 'DESC')->paginate(5);

        if ($request->ajax()) {
            return view('admin.beriTugas.lists', compact('post'));
        }

        return view('admin.beriTugas.index', [
            'updated_at' => $q,
            'witel' => $q2,
            'rekon' => $q3,
            'keterangan_aso' => $q4,
            'keterangan_ram3' => $q5,
            'users' => $qUsers
        ], compact('post'));
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
        $unique = time() . Str::random(10);
        // Session::set('quick_unique', $unique);
        foreach ($data as $d) {
            $create = [
                'timestamp_bawaan' => $d['timestamp_bawaan'],
                'witel' => $d['witel'],
                'id_valins' => $d['id_valins'],
                'eviden1' => $d['eviden1'],
                'eviden2' => $d['eviden2'],
                'eviden3' => $d['eviden3'],
                'id_valins_lama' => $d['id_valins_lama'],
                'approve_aso' => $d['approve_aso'],
                'keterangan_aso' => $d['keterangan_aso'],
                'ram3' => $d['ram3'],
                'keterangan_ram3' => $d['keterangan_ram3'],
                'rekon' => $d['rekon'],
                'id_eviden1' => $d['id_eviden1'],
                'id_eviden2' => $d['id_eviden2'],
                'id_eviden3' => $d['id_eviden3'],
                'unique_id' => $unique,
                'data_id' => $d['id']
            ];
            Dumps::create($create);
        }
        if ($data) {
            return response()->json([
                'status' => 'query success',
                'count' => count($data),
                'unique' => $unique
            ]);
        } else {
            return response()->json([
                'status' => 'Controller Not Working'
            ]);
        }
    }

    // public function quickAssign()
    // {
    //     try {
    //         $jumlahData = $_GET['jumlahData'];
    //         $assign = $_GET['assign'];
    //         $komentar = $_GET['komentar'];
    //         $komentarRill = $komentar;
    //         if ($komentar == null) {
    //             $komentarRill = 'Tolong kerjakan ini ya~';
    //         }
    //         $dataQuery1 = $_GET['unique'];
    //         $unique = time() . Str::random(10);
    //         $reviewer = User::where('username', $assign)->first();
    //         $tugas_dari = User::where('username', Session::get('username'))->first();
    //         Assignment::create([
    //             'id_reviewer' => $unique,
    //             'reviewer' => $reviewer->id,
    //             'tugas_dari' => $tugas_dari->id,
    //             'komentar' => $komentarRill
    //         ]);
    //         $id_assignments = Assignment::where('id_reviewer', $unique)->first();
    //         $dataQuery = Dumps::where('unique_id', $dataQuery1)->get();
    //         $counters = 0;
    //         foreach ($dataQuery as $data) {
    //             Data::where('id', $data['id'])->update([
    //                 'id_reviewer' => $unique
    //             ]);
    //             Reviewer::create([
    //                 'id_assignments' => $id_assignments->id,
    //                 'id_datas' => $data['id']
    //             ]);
    //             $counters++;
    //             if ($counters == $jumlahData) {
    //                 break;
    //             }
    //         }
    //         return response()->json([
    //             'status' => 'ok',
    //             'unique' => $dataQuery1
    //         ]);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'status' => $th->getMessage()
    //         ]);
    //     }
    // }

    public function quickAssign(Request $request)
    {
        try {
            // $request->validate([
            //     'jumlahData' => 'required',
            //     'assign' => 'required',
            //     'komentar' => '',
            //     'unique' => 'required',
            // ]);

            $jumlahData = $request->input('jumlahData');
            $assign = $request->input('assign');
            $komentar = $request->input('komentar');
            $komentarRill = $komentar;
            if ($komentar == null) {
                $komentarRill = 'Tolong kerjakan ini ya~';
            }
            $dataQuery1 = $request->input('unique');
            // return response()->json([
            //     'status' => $dataQuery1
            // ]);

            // $jumlahData = 100;
            // $assign = 'AKUN CHECK';
            // $komentarRill = 'IYA INI RILL~';
            // $dataQuery1 = '1702965826Te6A9rHYsm';

            $unique = time() . Str::random(10);
            $reviewer = User::where('username', $assign)->first();
            $tugas_dari = User::where('username', Session::get('username'))->first();

            // DB::beginTransaction();

            try {
                $assignment = Assignment::create([
                    'id_reviewer' => $unique,
                    'reviewer' => $reviewer->id,
                    'tugas_dari' => $tugas_dari->id,
                    'komentar' => $komentarRill,
                ]);

                // return response()->json([
                //     'status' => $assignment['id']
                // ]);

                $dataQuery = Dumps::where('unique_id', $dataQuery1)->get();
                // return response()->json([
                //     'status' => $assignment['id'],
                //     'throw' => $dataQuery[100]
                // ]);
                $counters = 0;

                foreach ($dataQuery as $data) {
                    $datadua = Data::where('id', $data['data_id'])->update([
                        'id_reviewer' => $unique,
                    ]);

                    $review = Reviewer::create([
                        'id_assignments' => $assignment['id'],
                        'id_datas' => $data['data_id'],
                    ]);

                    $counters++;
                    if ($counters == $jumlahData) {
                        break;
                    }
                }

                if($datadua && $review){
                    return response()->json([
                        'status' => 'ok',
                        'unique' => $dataQuery1,
                    ]);
                }else{
                    return response()->json([
                        'status' => 'not ok',
                        'throw' => $dataQuery[100]
                    ]);
                }

                // DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();

                return response()->json([
                    'status' => $e->getMessage(),
                ]);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }


    public function yeet()
    {
        $unique = $_GET['unique'];
        $q = Dumps::where('unique_id', $unique)->delete();
        if ($q) {
            return response()->json([
                'status' => 'ok'
            ]);
        } else {
            return response()->json([
                'status' => 'not ok'
            ]);
        }
    }

    public function selectiveGet()
    {
        $timestamp = $_GET['timestamp'];
        $rekon = $_GET['rekon'];
        $q = Data::query();
        if ($timestamp != 'null') {
            $q->where('updated_at', 'LIKE', '%' . $timestamp . '%');
        }
        if ($rekon != 'null') {
            $q->where('rekon', $rekon);
        }
        $result = $q->where('id_reviewer', null)->get();
        // return json_encode($result);
        return response()->json([
            'status' => 'ok',
            'data' => $result
        ]);
    }

    public function selectiveAssign()
    {
        try {
            $jumlahData = $_POST['jumlahData'];
            $assign = $_POST['assign'];
            $komentar = $_POST['komentar'];
            $datas = $_POST['datas'];
            $komentarRill = $komentar;
            if ($komentar == null) {
                $komentarRill = 'Tolong kerjakan ini ya~';
            }
            // $dataQuery1 = $_GET['unique'];
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
            // $dataQuery = Dumps::where('unique_id', $dataQuery1)->get();
            $counters = 0;
            foreach ($datas as $data) {
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
                'status' => 'ok'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => $th->getMessage()
            ]);
        }
    }

    public function lihat()
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

    public function edit()
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

    public function editValidation()
    {
        $id = $_GET['id'];
        $q = Assignment::with('getUsers')->where('id', $id)->first();
        $username = $q->getUsers->username;

        if (Session::get('username') == $username) {
            return response()->json([
                'access' => 'granted'
            ]);
        } else {
            return response()->json([
                'access' => 'not granted'
            ]);
        }
    }

    public function updateList()
    {
        $id = $_POST['id'];
        $reviewer = $_POST['reviewer'];
        $komentar = $_POST['komentar'];
        $rillKomentar = $komentar;
        if ($komentar == '') $rillKomentar = 'Tolong kerjakan ya~';

        $update = [
            'reviewer' => $reviewer,
            'komentar' => $rillKomentar
        ];

        $q = Assignment::where('id', $id)->update($update);

        if ($q) {
            return response()->json([
                'status' => 'ok'
            ]);
        } else {
            return response()->json([
                'status' => 'not ok'
            ]);
        }
    }

    public function hapusList()
    {
        try {
            $id = $_GET['id'];
            $reviewer = Reviewer::where('id_assignments', $id)->get();
            foreach ($reviewer as $r) {
                Data::where('id', $r['id_datas'])->update([
                    'id_reviewer' => null
                ]);
            }
            Assignment::where('id', $id)->delete();
            Reviewer::where('id_assignments', $id)->delete();
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
