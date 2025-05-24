<?php

namespace App\Http\Controllers\paket;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function show()
    {
        $paket = DB::table("packages")->get();
         return response()->json($paket);
    }
}
