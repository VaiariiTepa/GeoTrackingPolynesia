<?php

namespace App\Http\Controllers;

use App\Geotracking;
use Illuminate\Http\Request;

class GeotrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function get_marker()
    {
        $id = $_GET[''];

        $liste_categorie = DB::select('select * from geotrackings where id = ?', [1]);

        return json_encode();
    }


}
