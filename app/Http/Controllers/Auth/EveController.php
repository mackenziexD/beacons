<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Auth;
use DB;
use App\Models\User;

class EveController extends Controller
{
    const scopes = ['esi-characters.read_corporation_roles.v1', 'esi-corporations.read_structures.v1']; //define your scopes here
    
    public function redirect(Socialite $social){

        return $social->driver('eveonline')
            ->scopes(self::scopes)
            ->redirect();
    }

    public function findOrCreateUser($user)
    {
        $authUser = User::where('eve_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }
        return User::create([
            'id' => $user->id,
            'name'     => $user->name,
            'accessToken' => $user->token,
            'refreshToken' => $user->refreshToken,
            'eve_id' => $user->id,
        ]);
    }

    public function callback(Socialite $social){
        
        try {
            $eve_data = $social->driver('eveonline')
            ->scopes(self::scopes)
            ->user();

            $authUser = $this->findOrCreateUser($eve_data);

            Auth::login($authUser, true);
            return redirect('/home');
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Something went wrong with EVE SSO');
        }

    }
}
