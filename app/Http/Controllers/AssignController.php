<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use App\Models\beacon;
use DB;

class AssignController extends Controller
{
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
    
    public function index()
    {
            // get eve_data from session
            $eve_data = auth()->user();
            
            try {
                // check if user has station_manager role
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://esi.evetech.net/latest/characters/'.$eve_data->eve_id.'/roles/?datasource=tranquility');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


                $headers = array();
                $headers[] = 'Accept: application/json';
                $headers[] = 'Authorization: Bearer '.$eve_data->accessToken.'';
                $headers[] = 'Cache-Control: no-cache';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $station_manager = false;
                $result = curl_exec($ch);
                
                if (strpos($result, 'token is expired') !== false) {
                    $this->refreshToken($eve_data->id);
                    return redirect('/home');
                }
                
                $result = json_decode($result, true);

                foreach($result["roles"] as $role){
                    if($role == 'Station_Manager'){
                        $station_manager = true;
                    }
                }

                curl_close($ch);

            } catch (\Exception $e) {
                dd($e->getMessage() . '\n' . $e->getLine() . '\n' . $e->getFile());
                return redirect('/')->with('error', 'You probably dont have station manager role');
            }

            if(!$station_manager){
                return redirect('/')->with('error', 'You dont have station manager role');
            }


            $beacons = beacon::all();

            return view('assign', compact('eve_data'));
        }
}
