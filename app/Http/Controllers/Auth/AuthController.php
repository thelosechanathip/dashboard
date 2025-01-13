<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\OpdUser;
use App\Models\Log\LoginLogModel;

class AuthController extends Controller
{
    public function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return the server IP if the client IP is not found using this method.
    }

    public function verifyUsername(Request $request) {
        $username = $request->input('loginname'); // ตรวจสอบชื่อฟิลด์ให้ตรง
        $userExists = OpdUser::where('loginname', $username)->exists();
    
        if ($userExists != '') {
            // กรณี Username มีในระบบ
            return response()->json([
                'status' => 200,
                'title' => 'Success',
                'message' => 'Username exists in the system.',
                'icon' => 'success'
            ]);
        } else {
            // กรณี Username ไม่มีในระบบ
            return response()->json([
                'status' => 400,
                'title' => 'Error',
                'message' => 'ไม่มี Username ในระบบกรุณาตรวจ Username ใหม่อีกครั้ง!',
                'icon' => 'error'
            ]);
        }
    }    

    public function index(Request $request) {
        $data = $request->session()->all();
        $request->session()->forget('error');
        return view('auth.login', compact('data'));
    }

    public function login(Request $request)
    {
        $credentials = $request->only('loginname', 'passweb');

        // สร้าง query ก่อนที่จะ execute
        $query = OpdUser::where('loginname', $credentials['loginname']);

        // ดึง SQL query พร้อมกับ bindings
        $sql = $query->toSql();
        $bindings = $query->getBindings();

        // แทนที่เครื่องหมาย `?` ด้วยค่าจริงที่ถูก bind
        $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);

        // Execute query
        $user = $query->first();

        if ($user) {
            $pass_hash = md5($credentials['passweb']);

            // ตรวจสอบว่าผู้ใช้มีอยู่และรหัสผ่านตรงกัน
            if ($pass_hash == $user->passweb || strtoupper($pass_hash) == $user->passweb) {
                // if($user->groupname === 'ผู้ดูแลระบบ' ) {
                    Auth::login($user);
                    $request->session()->put('loginname', $user->loginname);
                    $request->session()->put('name', $user->name);
                    $request->session()->put('groupname', $user->groupname);
                    $request->session()->put('department', $user->department);

                    // ดึง IP และ Hostname
                    $ipAddress = $this->getIp();
                    $ipAddress = $_SERVER['REMOTE_ADDR'];
                    $hostname = gethostbyaddr($ipAddress);

                    // เก็บคำสั่ง SQL และข้อมูลการเข้าสู่ระบบลงใน log
                    $login_log_data = [
                        'fullname' => $user->name,
                        'username' => $user->loginname,
                        'command_sql' => $fullSql,  // บันทึกคำสั่ง SQL ที่ถูก generate
                        'type' => 'LOGIN',
                        'ipaddress' => $ipAddress,
                        'hostname' => $hostname,
                    ];

                    // บันทึก log การเข้าสู่ระบบ
                    if(LoginLogModel::create($login_log_data)) {

                    }
                    return redirect()->intended('/dashboard');
                // } else {
                //     $request->session()->put('error', 'ขออภัยในความไม่สะดวก ขณะนี้ทางทีม IT ได้ทำการปิดปรับปรุงระบบใหม่ ขอบคุณครับ!');
                //     return redirect()->intended('/');
                // }
            } else {
                // รหัสผ่านไม่ถูกต้อง
                $request->session()->put('error', 'Username หรือ Password ไม่ถูกต้องกรุณากรอกใหม่!');
                // $request->session()->put('error', 'ทาง IT ขออนุญาติปิดปรับปรุงระบบ');
                return redirect()->intended('/');
            }
        }

        // ถ้าไม่มี user ที่ match
        return redirect()->back()->withErrors(['login' => 'Invalid credentials provided']);
    }


    public function logout(Request $request)
    {
        $ipAddress = request()->ip();
        $hostname = gethostbyaddr($ipAddress);
        $data = $request->session()->all();

        // เก็บคำสั่ง SQL และข้อมูลการเข้าสู่ระบบลงใน log
        $login_log_data = [
            'fullname' => $data['name'],
            'username' => $data['loginname'],
            'type' => 'LOGOUT',
            'ipaddress' => $ipAddress,
            'hostname' => $hostname,
        ];

        Auth::logout();

        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if(LoginLogModel::create($login_log_data)) {
            return redirect('/');
        }
    }
}
