<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManufacturerModel extends Model
{
    protected $table = 'manufacturers';
    public $timestamps = false;
    public $primaryKey = 'manufacturers_id';

    public function manufacturerinfo()
    {
        return $this->belongsTo('App/ManufacturerInfoModel','manufacturers_id');
    }
}
