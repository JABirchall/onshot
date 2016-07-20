<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Skmetaly\TwitchApi\Services\TwitchApiService;

class TwitchController extends Controller
{
    protected $twitchApi;
    protected $twitchUser;
    protected $request;
    protected $user;

    public function __construct(TwitchApiService $twitchApi, Request $request)
    {
        $this->twitchApi = $twitchApi;
        $this->$request = $request;
    }

    public function login()
    {
        if(is_null(Auth::User()))
            return redirect($this->twitchApi->authenticationURL());
        else
            return redirect('/');
    }

    public function logout()
    {
        return redirect('/')->withLogout(Auth::logout());
    }

    public function auth()
    {
        $this->twitchUser["token"] = $this->twitchApi->requestToken($this->request->code);

        session(['token' => $this->twitchUser["token"]]);

        $this->twitchUser += $this->twitchApi->authenticatedUser($this->twitchUser["token"]);
        $this->user = User::firstOrNew(['username' => $this->twitchUser["display_name"]]);
        

        if($this->user->exists === False){
            $this->user->username = $this->twitchUser["display_name"];
            $this->user->email = $this->twitchUser["email"];
            $this->user->token = $this->twitchUser["token"];
            $this->user->save();
        }

        Auth::loginUsingId($this->user->id);
        return redirect('/');
    }
}
