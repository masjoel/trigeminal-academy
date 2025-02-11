<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Helpers\AutoNumberHelper;
use App\Http\Controllers\Controller;

class AutoNumberController extends Controller
{
    public function get(Request $request)
    {
        $params = $request->all();

        $res = AutoNumberHelper::initGenerateNumber($params['prefix']);
        
        return response()->json($res);
    }
}
