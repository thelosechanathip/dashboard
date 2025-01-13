<?php

namespace App\Http\Controllers\IT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestAllController extends Controller
{
    // Message Success Start
        private function messageSuccess($message) {
            return response()->json([
                'status' => 200,
                'title' => 'Success',
                'message' => $message,
                'icon' => 'success'
            ]);
        }
    // Message Success End

    // Message Error Start
        private function messageError($message) {
            return response()->json([
                'status' => 400,
                'title' => 'Error',
                'message' => $message,
                'icon' => 'error'
            ]);
        }
    // Message Error End

    // Index Working Type Start
        public function index(Request $request) {
            $data = $request->session()->all();

            if($data['groupname'] == 'ผู้ดูแลระบบ'){
                // Return the view with the necessary data
                return view('it.test_all', compact(
                    'data', 
                ));
            } else {
                $request->session()->put('error', 'คุณไม่มีสิทธิ์เข้าใช้งานระบบนี้!');
                return redirect()->route('dashboard');
            }
        }
    // Index Working Type End
}
