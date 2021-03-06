<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxClassModel extends Model
{
    protected $table = 'tax_class';
    public $timestamps = false;
    public $primaryKey = 'tax_class_id';

    public function taxRate()
    {
        return $this->belongsTo('App/TaxRatesModel','tax_class_id');
    }
}
