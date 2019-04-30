<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse_inventory_history_Model extends Model
{
   /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'warehouse_inventory_history';
   public $timestamps = false;

   public function product()
   {
      return $this->belongsTo('App\Products_Description' , 'pid');
   }
}
