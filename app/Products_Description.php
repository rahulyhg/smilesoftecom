<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products_Description extends Model
{
        protected $table = 'products_description';
    public $timestamps = false;
    public $primaryKey = 'products_id';
}
