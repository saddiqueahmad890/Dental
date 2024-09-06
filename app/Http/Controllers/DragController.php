<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DragController extends Controller //api data
{
    public function api(){
        $data = Http::get("https://reqres.in/api/users?pace=1");
        return view ('api',['collection'=>$data['data']]);
    }
    
}
