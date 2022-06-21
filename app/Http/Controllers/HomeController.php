<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use App\Models\beacon;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function refreshToken($id){
        # get helious from db
        $deets = DB::table('users')->where('eve_id', '94154296')->first();

        // get the access token
        $response = \Http::asForm()->post('https://login.eveonline.com/v2/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $deets->refreshToken,
            'client_id' => env('EVE_CLIENT_ID')
            ]);

        # show me what the response looks like
        $data = $response->json();

        # update the user's access token
        # update the user's refresh token

        $update = DB::table('users')->where('name', 'Helious Jin-Mei')->update([
            'accessToken' => $data['access_token'],
            'refreshToken' => $data['refresh_token'],
        ]);

        if($update){
            return;
        }else{
            return redirect('/')->with('error', 'Token update failed. please sign in again.');
        }
    }

    public function CheckCorp($id){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://esi.evetech.net/latest/characters/'.$id.'/?datasource=tranquility');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Cache-Control: no-cache';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $data = json_decode($result);
        if($data->corporation_id == 2014367342){  return true; }
        return false;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
            // get eve_data from session
            $eve_data = auth()->user();

            $checkCorp = $this->CheckCorp($eve_data->eve_id);
            if(!$checkCorp){ return redirect('/')->with('error', 'This character is not in Blackwater USA Inc.'); }

            $beacons = beacon::all();

            // loop through beacons and format into table
            $tableData = '';
            foreach($beacons as $beacon){

                $bg = "";
                switch ($beacon->expires_in) {
                    case $beacon->expires_in <= 07:
                        $bg = 'warning';
                        break;
                    case $beacon->expires_in <= 02:
                        $bg = 'danger';
                        break;
                }

                // check if expires in contains "INCURSION"
                if(strpos($beacon->expires_in, '[INCURSION]') !== false){
                    $bg = 'pink';
                }
                
                // check if expires in contains "INCURSION"
                if(strpos($beacon->expires_in, 'OFFLINE') !== false && $beacon->expires_in <= 02){
                    $bg = 'danger';
                }

                $tableData .= '<tr class="'.$bg.'" >';
                $tableData .= '<td>'.$beacon->system.'</td>';
                $tableData .= '<td>'.$beacon->name.'</td>';
                $tableData .= '<td>'.$beacon->constellation.'</td>';
                $tableData .= '<td>'.$beacon->expires_in.'</td>';
                $tableData .= '</tr>';
            }

            return view('home', compact('eve_data', 'tableData'));
    }
}
