<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
    public function index()
    {
        $status = status::all();
        $status = $status->first();

        // if the status is false give html 400 error
        if($status->status == false){ return response()->view('error', ['status'=>'Service Up', 'data'=>$status], 400); }
        return response()->view('error', ['status'=>'Service Up', 'data'=>$status], 200);
    }
}
