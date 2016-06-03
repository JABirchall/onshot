<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Skmetaly\TwitchApi\Services\TwitchApiService;

class AuthController extends Controller
{
    protected static $TwitchApi;
    protected static $Request;

    public function __construct(TwitchApiService $twitchApi, Request $request)
    {
        $this::TwitchApi = $twitchApi;
        $this::Request = $request;
    }

    public function login(){
        return redirect($this::TwitchApi->authenticationURL());
    }

    public function auth(){
        $token = $this::TwitchApi->requestToken($this::Request->get('code'));
        session(['token' => $token]);

        $twitchUser = $this::TwitchApi->authenticatedUser($token);
        $user = User::firstOrNew(['username' => $twitchUser["display_name"]]);

        if($user->exists === false){
            $user->username = $twitchUser["display_name"];
            $user->email = $twitchUser["email"];
            $user->save();
        }

        Auth::login($user);
        return redirect('/');
    }
}
