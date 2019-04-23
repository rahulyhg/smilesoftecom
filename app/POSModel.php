<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CustomerModel;

class POSModel extends Model
{
    protected $table = 'pos';
    public $timestamps = false;

    public function warehouse()
    {
        return $this->belongsTo('/App/WarehouseModel','wid');
    }
    public function staff()
    {
        return $this->belongsTo('/App/WarehouseStaffModel','sid');
    }
    public function customer()
    {
        return $this->belongsTo('App/CustomerModel','customer_id');
    }
}
