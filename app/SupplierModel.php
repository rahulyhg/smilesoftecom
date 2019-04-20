<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
   /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'supplier';
   public $timestamps = false;
}
