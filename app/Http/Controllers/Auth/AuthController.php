<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\OpdUser;

class AuthController extends Controller
{
    public function index(Request $request) {
        $data = $request->session()->all();
        $request->session()->forget('error');
        return view('auth.login', compact('data'));
    }

    public function login(Request $request)
    {
        $credentials = $request->only('loginname', 'passweb');

        // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
        $user = OpdUser::where('loginname', $credentials['loginname'])->first();

        if ($user) {
            $pass_hash = md5($credentials['passweb']);
            // ตรวจสอบว่าผู้ใช้มีอยู่และรหัสผ่านตรงกัน
            if ($pass_hash == $user->passweb || strtoupper($pass_hash) == $user->passweb) {
                Auth::login($user);
                $request->session()->put('loginname', $user->loginname);
                $request->session()->put('name', $user->name);
                $request->session()->put('groupname', $user->groupname);
                $request->session()->put('department', $user->department);
                return redirect()->intended('/dashboard');
            } else {
                $request->session()->put('error', 'Username หรือ Password ไม่ถูกต้องกรุณากรอกใหม่!');
                return redirect()->intended('/');
            }
        }

        return redirect()->back()->withErrors(['login' => 'Invalid credentials provided']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
