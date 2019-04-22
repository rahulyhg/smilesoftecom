<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsModel extends Model
{
    protected $table = 'products';
   public $timestamps = false;
   public $primaryKey = 'products_id';

}
