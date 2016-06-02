<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Input;
use Auth;
use Skmetaly\TwitchApi\Services\TwitchApiService as TwitchApi;

class AuthController extends Controller
{

    public function login(TwitchApi $api){
        return redirect($api->authenticationURL());
    }

    public function auth(Request $request, TwitchApi $api){
        $token = $api->requestToken($request->get('code'));
        session(['token' => $token]);
        $twitchUser = $api->authenticatedUser($token);
        $user = User::firstOrNew(['username' => $twitchUser["display_name"]]);
        if($user->exists === false){
            $user->username = $twitchUser["display_name"];
            $user->email = $twitchUser["email"];
            $user->save();
        } else {
            Auth::login($user);
        }

        return redirect('/');
    }
}
