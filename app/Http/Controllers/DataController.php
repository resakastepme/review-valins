<?php

namespace App\Http\Controllers;

use App\Models\PreviewData;
use Illuminate\Http\Request;
use App\Models\Data;
use Illuminate\Support\Facades\Session;
use Exception;

class DataController extends Controller
{
    public function getDataEdit()
    {
        $id = $_GET['id'];
        $q = Data::where('id', $id)->first();
        if ($q) {
            return response()->json([
                'status' => 'BERHASIL',
                'data' => $q
            ]);
        } else {
            return response()->json([
                'status' => 'GAGAL'
            ]);
        }
    }

    public function getData()
    {
        $q = Data::orderby('id', 'ASC')->get();
        $json_data['data'] = $q;
        return json_encode($json_data);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $q = Data::orderby('id', 'ASC')->get();
            $uri1 = $q[0]['eviden1'];
            $uri2 = $q[0]['eviden2'];
            $uri3 = $q[0]['eviden3'];
            $queryString1 = parse_url($uri1, PHP_URL_QUERY);
            if ($queryString1) {
                parse_str($queryString1, $queryParameters1);
                $id1 = $queryParameters1['id'];
            } else {
                $id1 = '';
            }
            if ($uri2 != '') {
                $queryString2 = parse_url($uri2, PHP_URL_QUERY);
                if ($queryString2) {
                    parse_str($queryString2, $queryParameters2);
                    $id2 = $queryParameters2['id'];
                } else {
                    $id2 = '';
                }
            } else {
                $id2 = '';
            }
            if ($uri3 != '') {
                $queryString3 = parse_url($uri3, PHP_URL_QUERY);
                if ($queryString3) {
                    parse_str($queryString3, $queryParameters3);
                    $id3 = $queryParameters3['id'];
                } else {
                    $id3 = '';
                }
            } else {
                $id3 = '';
            }
            $array_id = [
                'id1' => $id1,
                'id2' => $id2,
                'id3' => $id3
            ];
            return view('admin.data.index', [
                'datas' => $q,
                'id' => $array_id
            ]);
        } catch (Exception $e) {
            return view('admin.data.index', [
                'no data' => $e->getMessage()
            ]);
        }
    }

    public function index_user()
    {
        try {
            $q = Data::orderby('id', 'ASC')->get();
            $uri1 = $q[0]['eviden1'];
            $uri2 = $q[0]['eviden2'];
            $uri3 = $q[0]['eviden3'];
            $queryString1 = parse_url($uri1, PHP_URL_QUERY);
            if ($queryString1) {
                parse_str($queryString1, $queryParameters1);
                $id1 = $queryParameters1['id'];
            } else {
                $id1 = '';
            }
            if ($uri2 != '') {
                $queryString2 = parse_url($uri2, PHP_URL_QUERY);
                if ($queryString2) {
                    parse_str($queryString2, $queryParameters2);
                    $id2 = $queryParameters2['id'];
                } else {
                    $id2 = '';
                }
            } else {
                $id2 = '';
            }
            if ($uri3 != '') {
                $queryString3 = parse_url($uri3, PHP_URL_QUERY);
                if ($queryString3) {
                    parse_str($queryString3, $queryParameters3);
                    $id3 = $queryParameters3['id'];
                } else {
                    $id3 = '';
                }
            } else {
                $id3 = '';
            }
            $array_id = [
                'id1' => $id1,
                'id2' => $id2,
                'id3' => $id3
            ];
            return view('user.data.index', [
                'datas' => $q,
                'id' => $array_id
            ]);
        } catch (Exception $e) {
            return view('user.data.index', [
                'no data' => $e->getMessage()
            ]);
        }
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
        if ($check) {
            return response()->json([
                'status' => 'GAGAL',
                'trigger' => 'ID VALINS DUPLIKAT'
            ]);
        }
        $queryString1 = parse_url($eviden1, PHP_URL_QUERY);
        if ($queryString1) {
            parse_str($queryString1, $queryParameters1);
            $id1 = $queryParameters1['id'];
        } else {
            return response()->json([
                'status' => 'GAGAL',
                'trigger' => 'URL TIDAK VALID',
                'eviden' => 'formEviden1'
            ]);
        }
        if ($eviden2 != '') {
            $queryString2 = parse_url($eviden2, PHP_URL_QUERY);
            if ($queryString2) {
                parse_str($queryString2, $queryParameters2);
                $id2 = $queryParameters2['id'];
            } else {
                return response()->json([
                    'status' => 'GAGAL',
                    'trigger' => 'URL TIDAK VALID',
                    'eviden' => 'formEviden2'
                ]);
            }
        } else {
            $id2 = '';
        }
        if ($eviden3 != '') {
            $queryString3 = parse_url($eviden3, PHP_URL_QUERY);
            if ($queryString3) {
                parse_str($queryString3, $queryParameters3);
                $id3 = $queryParameters3['id'];
            } else {
                return response()->json([
                    'status' => 'GAGAL',
                    'trigger' => 'URL TIDAK VALID',
                    'eviden' => 'formEviden3'
                ]);
            }
        } else {
            $id3 = '';
        }
        $create = [
            'witel' => $witel,
            'id_valins' => $id_valins,
            'eviden1' => $eviden1,
            'eviden2' => $eviden2,
            'eviden3' => $eviden3,
            'id_valins_lama' => $id_valins_lama,
            'rekon' => $rekon,
            'id_eviden1' => $id1,
            'id_eviden2' => $id2,
            'id_eviden3' => $id3
        ];
        $q = Data::create($create);
        if ($q) {
            return response()->json([
                'status' => 'BERHASIL',
                'trigger' => 'BERHASIL'
            ]);
        } else {
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
    public function update()
    {
        $witel = $_POST['witel'];
        $id_valins = $_POST['id_valins'];
        $eviden1 = $_POST['eviden1'];
        $eviden2 = $_POST['eviden2'];
        $eviden3 = $_POST['eviden3'];
        $id_valins_lama = $_POST['id_valins_lama'];
        $rekon = $_POST['rekon'];
        $id = $_POST['id'];
        $hiddenIdValins = $_POST['hiddenIdValins'];
        if ($id_valins != $hiddenIdValins) {
            $check = Data::where('id_valins', $id_valins)->where('rekon', $rekon)->first();
            if ($check) {
                return response()->json([
                    'status' => 'GAGAL',
                    'trigger' => 'ID VALINS DUPLIKAT'
                ]);
            }
        }
        $queryString1 = parse_url($eviden1, PHP_URL_QUERY);
        if ($queryString1) {
            parse_str($queryString1, $queryParameters1);
            $id1 = $queryParameters1['id'];
        } else {
            return response()->json([
                'status' => 'GAGAL',
                'trigger' => 'URL TIDAK VALID',
                'eviden' => 'formEviden1'
            ]);
        }
        if ($eviden2 != '') {
            $queryString2 = parse_url($eviden2, PHP_URL_QUERY);
            if ($queryString2) {
                parse_str($queryString2, $queryParameters2);
                $id2 = $queryParameters2['id'];
            } else {
                return response()->json([
                    'status' => 'GAGAL',
                    'trigger' => 'URL TIDAK VALID',
                    'eviden' => 'formEviden2'
                ]);
            }
        } else {
            $id2 = '';
        }
        if ($eviden3 != '') {
            $queryString3 = parse_url($eviden3, PHP_URL_QUERY);
            if ($queryString3) {
                parse_str($queryString3, $queryParameters3);
                $id3 = $queryParameters3['id'];
            } else {
                return response()->json([
                    'status' => 'GAGAL',
                    'trigger' => 'URL TIDAK VALID',
                    'eviden' => 'formEviden3'
                ]);
            }
        } else {
            $id3 = '';
        }
        $update = [
            'witel' => $witel,
            'id_valins' => $id_valins,
            'eviden1' => $eviden1,
            'eviden2' => $eviden2,
            'eviden3' => $eviden3,
            'id_valins_lama' => $id_valins_lama,
            'rekon' => $rekon,
            'id_eviden1' => $id1,
            'id_eviden2' => $id2,
            'id_eviden3' => $id3
        ];
        $q = Data::where('id', $id)->update($update);
        if ($q) {
            return response()->json([
                'status' => 'BERHASIL',
                'trigger' => 'BERHASIL'
            ]);
        } else {
            return response()->json([
                'status' => 'GAGAL',
                'trigger' => 'GAGAL'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $userId = $_POST['userId'];

        $q = Data::where('id', $userId)->delete();

        if ($q) {
            return response()->json([
                'status' => 'BERHASIL'
            ]);
        } else {
            return response()->json([
                'status' => 'GAGAL'
            ]);
        }
    }

    public function preview()
    {
        if (Session('preview_access') != 'granted') {
            return redirect()->to('/auth');
        } else {
            $qPreview = PreviewData::where('unique_id', Session('unique_id'))->get();
            foreach ($qPreview as $preview) {
                $q1 = Data::where('rekon', $preview->rekon)->where('id_valins', $preview->id_valins)->first();
                if ($q1) {
                    PreviewData::where('id', $preview->id)->update([
                        'isValid' => 0
                    ]);
                }
            }
            $qPreviewNotValid = PreviewData::where('unique_id', Session('unique_id'))->where('isValid', 0)->get();
            $qPreviewValid = PreviewData::where('unique_id', Session('unique_id'))->where('isValid', 1)->get();
            // dd('success with id: ' . Session('unique_id'));
            Session::put('preview_access', 'granted');
            return view('admin.data.preview', [
                'previewValid' => $qPreviewValid,
                'previewNotValid' => $qPreviewNotValid
            ]);
        }
    }

    public function previewBatal()
    {
        $q = PreviewData::where('unique_id', Session::get('unique_id'))->delete();
        Session::pull('preview_access');
        Session::pull('unique_id');
        if ($q) {
            return redirect()->to('/' . (Session::get('role') == 1 ? 'admin' : (Session::get('role') == 2 ? 'aso' : 'user')) . '/data')->with('batalkan_status', 'Success');
        } else {
            return redirect()->to('/' . (Session::get('role') == 1 ? 'admin' : (Session::get('role') == 2 ? 'aso' : 'user')) . '/data')->with('batalkan_status', 'Failed');
        }
    }

    public function previewSubmit()
    {
        if (empty(Session::get('unique_id')))
            return redirect()->to('/auth');
        $q = PreviewData::where('unique_id', Session::get('unique_id'))->where('isValid', 1)->get();
        if ($q) {
            foreach ($q as $data) {
                $timestamp = $data['timestamp_bawaan'];
                $witel = $data['witel'];
                $id_valins = $data['id_valins'];
                $eviden1 = $data['eviden1'];
                $eviden2 = $data['eviden2'];
                $eviden3 = $data['eviden3'];
                $id_valins_lama = $data['id_valins_lama'];
                $approve_aso = $data['approve_aso'];
                $keterangan_aso = $data['keterangan_aso'];
                $ram3 = $data['ram3'];
                $keterangan_ram3 = $data['keterangan_ram3'];
                $rekon = $data['rekon'];

                if ($eviden1 != '') {
                    $queryString1 = parse_url($eviden1, PHP_URL_QUERY);
                    if ($queryString1) {
                        parse_str($queryString1, $queryParameters1);
                        $id1 = $queryParameters1['id'];
                    }
                } else {
                    $id1 = '';
                }
                if ($eviden2 != '') {
                    $queryString2 = parse_url($eviden2, PHP_URL_QUERY);
                    if ($queryString2) {
                        parse_str($queryString2, $queryParameters2);
                        $id2 = $queryParameters2['id'];
                    }
                } else {
                    $id2 = '';
                }
                if ($eviden3 != '') {
                    $queryString3 = parse_url($eviden3, PHP_URL_QUERY);
                    if ($queryString3) {
                        parse_str($queryString3, $queryParameters3);
                        $id3 = $queryParameters3['id'];
                    }
                } else {
                    $id3 = '';
                }
                $create = [
                    'timestamp_bawaan' => $timestamp,
                    'witel' => $witel,
                    'id_valins' => $id_valins,
                    'eviden1' => $eviden1,
                    'eviden2' => $eviden2,
                    'eviden3' => $eviden3,
                    'id_valins_lama' => $id_valins_lama,
                    'approve_aso' => $approve_aso,
                    'keterangan_aso' => $keterangan_aso,
                    'ram3' => $ram3,
                    'keterangan_ram3' => $keterangan_ram3,
                    'rekon' => $rekon,
                    'id_eviden1' => $id1,
                    'id_eviden2' => $id2,
                    'id_eviden3' => $id3
                ];
                Data::create($create);
                PreviewData::where('unique_id', Session::get('unique_id'))->where('isValid', 1)->where('id_valins', $id_valins)->update([
                    'isSubmit' => 1
                ]);
            }
            Session::pull('unique_id');
            Session::pull('preview_access');
            return redirect()->to('/admin/data')->with('excelStatus', 'Proses Berhasil');
        } else {
            return redirect()->to('/admin/data')->with('excelFailed', 1);
        }
    }

    public function refreshTable()
    {
        $q = Data::orderby('id', 'ASC')->get();
        $data = array();
        foreach ($q as $datas) {
            $data[] = $datas;
        }
        // dd(json_encode($data));
        return json_encode($data);
    }
}
