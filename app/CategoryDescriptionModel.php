<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryDescriptionModel extends Model
{
    protected $table = 'categories_description';
    public $timestamps = false;
    public $primaryKey = 'categories_description_id';
}
