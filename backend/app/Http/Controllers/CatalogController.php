<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{
    public function getCatalog(Request $request){
        try {
            $data = DB::table($request->catalog)->select('id', 'code', 'name')->where('tenant_id', Auth::user()->tenant_id)->where('deleted_at', null)->get();
            return [
                'data' => $data
            ];
        } catch (\Throwable $th) {
            return ResponseManager::error($th->getMessage(), 500);
        }
    }
}
