<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManufacturerInfoModel extends Model
{
    protected $table = 'manufacturers_info';
    public $timestamps = false;
    public $primaryKey = 'manufacturers_id';
}
