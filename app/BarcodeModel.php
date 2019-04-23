<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarcodeModel extends Model
{
    protected $table = 'barcode';
    public $timestamps = false;

    public function prodis()
    {
        return $this->belongsTo('App\Products_Description','product_id');
    }

}
