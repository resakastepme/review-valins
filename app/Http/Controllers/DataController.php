<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data;

class DataController extends Controller
{
    public function getData(){
        $q = Data::get();
        $json_data['data'] = $q;
        return json_encode($json_data);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $q = Data::orderby('id', 'DESC')->get();

        $uri1 = $q[0]['eviden1'];
        $uri2 = $q[0]['eviden2'];
        $uri3 = $q[0]['eviden3'];
        $queryString1 = parse_url($uri1, PHP_URL_QUERY);
        $queryString2 = parse_url($uri2, PHP_URL_QUERY);
        $queryString3 = parse_url($uri3, PHP_URL_QUERY);
        parse_str($queryString1, $queryParameters1);
        parse_str($queryString2, $queryParameters2);
        parse_str($queryString3, $queryParameters3);
        $id1 = $queryParameters1['id'];
        $id2 = $queryParameters2['id'];
        $id3 = $queryParameters3['id'];

        $array_id = [
            'id1' => $id1,
            'id2'=> $id2,
            'id3'=> $id3
        ];

        return view('admin.data.index', [
            'datas' => $q,
            'id' => $array_id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $witel = $_POST['witel'];
        $id_valins = $_POST['id_valins'];
        $eviden1 = $_POST['eviden1'];
        $eviden2 = $_POST['eviden2'];
        $eviden3 = $_POST['eviden3'];
        $id_valins_lama = $_POST['id_valins_lama'];
        $rekon = $_POST['rekon'];
        $check = Data::where('id_valins', $id_valins)->where('rekon', $rekon)->first();
        if($check){
            return response()->json([
                'status' => 'GAGAL',
                'trigger' => 'ID VALINS DUPLIKAT'
            ]);
        }
        $queryString1 = parse_url($eviden1, PHP_URL_QUERY);
        $queryString2 = parse_url($eviden2, PHP_URL_QUERY);
        $queryString3 = parse_url($eviden3, PHP_URL_QUERY);
        parse_str($queryString1, $queryParameters1);
        parse_str($queryString2, $queryParameters2);
        parse_str($queryString3, $queryParameters3);
        $id1 = $queryParameters1['id'];
        $id2 = $queryParameters2['id'];
        $id3 = $queryParameters3['id'];
        $create = [
            'witel' => $witel,
            'id_valins' => $id_valins,
            'eviden1' => $eviden1,
            'eviden2' => $eviden2,
            'eviden3'=> $eviden3,
            'id_valins_lama' => $id_valins_lama,
            'rekon' => $rekon,
            'id_eviden1' => $id1,
            'id_eviden2' => $id2,
            'id_eviden3' => $id3
        ];
        $q = Data::create($create);
        if($q){
            return response()->json([
                'status' => 'BERHASIL',
                'trigger' => 'BERHASIL'
            ]);
        }else{
            return response()->json([
                'status' => 'GAGAL',
                'trigger' => 'GAGAL'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
