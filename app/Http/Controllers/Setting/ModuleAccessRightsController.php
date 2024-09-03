<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class ModuleAccessRightsController extends Controller
{
    public function index(Request $request) {
        // Retrieve session data
        $data = $request->session()->all();

        // Return the view with the necessary data
        return view('setting.module_access_rights', compact('data'));
    }
}
