<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;

class HomeController extends Controller
{
    public function index()
    {
        dd(Auth::User());
        return view('index');
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
