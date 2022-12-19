<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // check if user has is logged in, if so redirect to home
        if (auth()->check()) {
            return redirect('/home');
        }
        return view('welcome');
    }
}
