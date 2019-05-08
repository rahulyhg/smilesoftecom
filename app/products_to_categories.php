<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class products_to_categories extends Model
{
    protected $table = 'products_to_categories';
    public $timestamps = false;
    public $primaryKey = 'products_id';
}
