<?php

namespace App\Http\Controllers\IT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItHomeController extends Controller
{
    public function index(Request $request) {
        $data = $request->session()->all();

        if($data['groupname'] == 'ผู้ดูแลระบบ'){
            // Return the view with the necessary data
            return view('it.it_home', compact(
                'data', 
            ));
        } else {
            $request->session()->put('error', 'คุณไม่มีสิทธิ์เข้าใช้งานระบบนี้!');
            return redirect()->route('dashboard');
        }
    }
}
