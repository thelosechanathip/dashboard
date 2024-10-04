<?php

namespace App\Http\Controllers\IT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Dashboard_Setting\WorkingTypeModel;

class WorkingTypeController extends Controller
{
    public function index(Request $request) {

        $data = $request->session()->all();

        $request->session()->forget('error');

        return view('it.working_type', compact(
            'data', 
        ));
    }
}
