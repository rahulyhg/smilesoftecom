<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryManageModel extends Model
{
    public $timestamps = false;
    protected $table = 'sub_category_product';

    public function category()
    {
        return $this->belongsTo('App/CategoryModel','category_id');
    }
}
