<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Geotracking extends Model
{
    public $fillable = ['nomville','lat','lon'];
}
