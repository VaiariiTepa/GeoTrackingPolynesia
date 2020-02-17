<?php

namespace App\Http\Controllers;

use App\Geotracking;
use Illuminate\Http\Request;

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $list_categorie = Geotracking::all();

        return view('home',compact('list_categorie'));
    }
}
