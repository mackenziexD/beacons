<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Artisan;

class UpdateController extends Controller
{
    public function index()
    {
        // remove spaces from Auth::user()->name
        dispatch(function () {
            $name = str_replace(' ', '', Auth::user()->name);
            Artisan::call('get:beacons '.$name);
        });
        // return back
        return redirect()->back()->with('success', 'Force Update Pushed, This has been logged.');
    }
}
