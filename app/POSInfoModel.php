<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class POSInfoModel extends Model
{
    protected $table = 'pos_info';
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo('App/Products_Description', 'product_id');
    }
}
