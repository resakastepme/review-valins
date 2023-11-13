<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\DatasImport;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function process(Request $r)
    {
        $unique = time() . Str::random(10);
        Session::put('unique_id', $unique);
        $file = Excel::import(new DatasImport, $r->file('file'));
        $fileName = $r->file('file')->getClientOriginalName();

        // dd('success with id: '. Session('unique_id'));
        if ($file) {
            return redirect()->to('admin/data/preview')->with('fileName', $fileName)->with('access', 'granted');
        } else {
            return redirect()->back()->with('error', 'Failed');
        }
    }
}
