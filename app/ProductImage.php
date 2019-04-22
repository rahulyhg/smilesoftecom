<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'products_images';
    public $timestamps = false;
    public $primaryKey = 'products_id';
}
