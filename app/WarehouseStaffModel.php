<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class WarehouseStaffModel extends Model
{
    protected $table = 'warehouse_staff';
    public $timestamps = false;

    public function warehouse()
    {
        return $this->belongsTo('App\WarehouseModel', 'warehouse_id');
    }
}
