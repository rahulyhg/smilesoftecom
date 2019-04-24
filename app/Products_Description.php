<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products_Description extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products_description';
    public $timestamps = false;
    public $primaryKey = 'products_id';
}
