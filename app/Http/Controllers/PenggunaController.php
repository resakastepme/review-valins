<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $q = User::where('username', '!=', session('username'))->get();
        return view('admin.pengguna.index', [
            'users' => $q
        ]);
    }

    public function getUser(){
        $q = User::where('username', '!=', session('username'))->get();
        $json_data['data'] = $q;
        return json_encode($json_data);
    }

    public function getUserEdit(){
        $id = $_GET['id'];
        $q = User::where('id', $id)->first();
        if($q){
            return response()->json([
                'status' => 'BERHASIL',
                'data' => $q
            ]);
        }else{
            return response()->json([
                'status' => 'GAGAL'
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $username = $_GET['username'];
        $email = $_GET['email'];
        $password = $_GET['password'];
        $role = $_GET['role'];

        $username_anti_distinct = User::where('username', $username)->first();
        if( $username_anti_distinct ){
            return response()->json([
                'status' => 'Username sudah ada!',
                'trigger' => 'USERNAME SUDAH ADA'
            ]);
        }

        $email_anti_distinct = User::where('email', $email)->first();
        if($email_anti_distinct){
            return response()->json([
                'status' => 'Email sudah ada!',
                'trigger' => 'EMAIL SUDAH ADA'
            ]);
        }

        $request = [
            'username' => $username,
            'email' => $email,
            'password' => md5($password),
            'role' => $role
        ];

        $q = User::create($request);

        if ($q) {
            return response()->json([
                'status' => 'Akun sukses ditambah!',
                'trigger' => 'BERHASIL'
            ]);
        }else{
            return response()->json([
                'status' => 'Akun gagal ditambah!',
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
