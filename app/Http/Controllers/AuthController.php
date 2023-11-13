<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getRole(){
        // $role = Session('role') == 1 ? 'admin' : Session('role')  == 0 ? 'user' : 'aso';

        $role = 'admin';
        if(Session('role') == 0) return $role = 'user';
        if(Session('role') == 2) return $role = 'aso';

        if($role){
            return response()->json([
                'status' => 'BERHASIL',
                'role' => $role
            ]);
        }else{
            return response()->json([
                'status' => 'GAGAL'
            ]);
        }
    }

    public function index()
    {

        if(Session('role')){

            if(Session('role') == 1){
                return redirect()->to('/admin/dashboard');
            }else{
                return redirect()->to('/user/dashboard');
            }

        }else{
            return view('auth.index');
        }

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

                $role = $passCheck['role'];
                $username = $passCheck['username'];

                Auth::login($passCheck);
                Session::put('username', $username);
                Session::put('role', $role);
                Session::put('attempt', time());

                return response()->json([
                    'status' => 'Berhasil login!',
                    'trigger' => 'BERHASIL LOGIN',
                    'role' => $role == 1 ? 'admin' : 'user'
                ]);

            }

        }

    }

}
