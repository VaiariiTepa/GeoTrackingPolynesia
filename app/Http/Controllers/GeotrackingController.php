<?php

namespace App\Http\Controllers;

use App\Geotracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function get_marcker()
    {
        $id = $_GET['id_categorie'];
        echo($id);
        $liste_categorie = DB::select('select * from geotrackings where id = '.$id);

        return json_encode($liste_categorie);
    }


}
