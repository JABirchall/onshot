<?php

namespace App\Http\Controllers;

use App\Shot;
use Illuminate\Http\Request;

use App\Http\Requests;

class ShotController extends Controller
{
    protected $shot;
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        if(!@$_GET['json'])
            return view('shotIndex')->with('shots', Shot::paginate(15));
        else
            return response()->json(Shot::with('User')->get());
    }

    public function submit()
    {

        $result = preg_match("((https|http)\:\/\/clips.twitch.tv(\/[\/\w\d-.]+))", $this->request->url);
        if($result != 1)
            return "Only Twitch Clips are supported at the moment.";

        $content = $this->fetchPage($this->request->url);
        $result = preg_match("((http|https)\:\\\/\\\/clips-media-assets.twitch.tv(\\\/[\w\d-.]+))", $content, $matches);

        if($result != 1)
            return "An unexpected Error occurred";

        $match = preg_replace("/\\\\/", "", $matches[0]);

        $this->shot = New Shot;
        $this->shot->user_id = (Auth::check()) ? Auth::user()->id : Null;
        $this->shot->shot_url = $this->request->url;
        $this->shot->shot_download_url = $match;
        $this->shot->save();

    }

    public function download(Shot $shot)
    {
        if(Auth::check())
            return Redirect::away($shot->shot_download_url);
        else
            return abort(403);
    }

    public function view(Shot $shot)
    {
        return view('viewShot')->withShot($shot);
    }

    private function fetchPage($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }



}
