<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryModel extends Model
{
    public $timestamps = false;
    protected $table = 'inventory';
    public $primaryKey = 'inventory_ref_id';
}
