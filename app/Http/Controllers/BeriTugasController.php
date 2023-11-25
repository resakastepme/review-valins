<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

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

        if ($qtimestamp != 'null') $query->where('updated_at', 'LIKE', '%' . $qtimestamp . '%');
        if ($qwitel != 'null') $query->where('witel', $qwitel);
        if ($qrekon != 'null') $query->where('rekon', $qrekon);
        if ($qaso != 'null') $query->where('approve_aso', $qaso);
        if ($qketAso != 'null') $query->where('keterangan_aso', $qketAso);
        if ($qram3 != 'null') $query->where('ram3', $qram3);
        if ($qketRam3 != 'null') $query->where('keterangan_ram3', $qketRam3);

        $data = $query->get();

        if($data){
            return response()->json([
                'status' => 'query success',
                'count' => count($data),
                'data' => $data
            ]);
        }else{
            return response()->json([
                'status' => 'Controller Not Working'
            ]);
        }
    }

    public function quickAssign(){
        return 'lmao';
    }
}
