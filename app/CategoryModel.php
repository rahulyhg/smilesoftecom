<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    public $timestamps = false;
    public $primaryKey = 'categories_id';
}
