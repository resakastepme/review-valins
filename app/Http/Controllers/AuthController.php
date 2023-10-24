<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.index');
    }

    public function credCheck()
    {

        $email = $_GET['email'];
        $password = $_GET['password'];

        if (!$email) {
            return response()->json([
                'status' => 'Silahkan lengkapi form!',
                'trigger' => 'FORM TIDAK LENGKAP'
            ]);
        } elseif (!$password) {
            return response()->json([
                'status' => 'Silahkan lengkapi form!',
                'trigger' => 'FORM TIDAK LENGKAP'
            ]);
        }

        $emailCheck = User::where('email', $email)->first();
        if (!$emailCheck) {
            return response()->json([
                'status' => 'Username/password tidak ditemukan!',
                'trigger' => 'USERNAME/PASSWORD ERROR'
            ]);
        } else {

            $passCheck = User::where('password', md5($password))->first();
            if (!$passCheck) {
                return response()->json([
                    'status' => 'Username/password tidak ditemukan!',
                    'trigger' => 'USERNAME/PASSWORD ERROR'
                ]);
            }else{

                // Session::put('username', $username);
                return response()->json([
                    'status' => 'Berhasil login!',
                    'trigger' => 'BERHASIL LOGIN'
                ]);

            }

        }

    }

}
