<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function download($parameter)
    {
        if (!$parameter) {
            return redirect()->to('/auth');
        } else {
            if ($parameter == 'DataTemplate') {
                $file = Storage::path('public/template/DataTemplate.xlsx');
                return response()->download($file, 'DataTemplate.xlsx');
            }else{
                return redirect()->to('/auth');
            }
        }
    }
}
