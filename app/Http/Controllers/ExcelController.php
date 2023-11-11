<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\DatasImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function proccess(Request $r){
    if($r['file']->hasFile('excelUploadForm')){

        // $excel = Excel::import(new DatasImport, $r->file('excelUploadForm'));
        // if($excel){
            return response()->json([
                'status' => 'BERHASIL'
            ]);
        // }else{
        //     return response()->json([
        //         'status' => 'GAGAL'
        //     ]);
        // }

    }else{
        return response()->json([
            'status' => 'FILE GAGAL'
        ]);
    }
   }
}
