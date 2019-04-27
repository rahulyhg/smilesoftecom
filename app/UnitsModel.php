<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitsModel extends Model
{
    public $timestamps = false;
    protected $table = 'units';
    public $primaryKey = 'unit_id';
}
