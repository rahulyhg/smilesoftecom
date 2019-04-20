<?php

namespace App\Http\Controllers;

use App\WarehouseModel;
use Illuminate\Http\Request;
use Validator;
use App;
use Lang;
use DB;
//for password encryption or hash protected
use Hash;
use App\Administrator;

//for authenitcate login data
use Auth;

class AdminWarehouseController extends Controller
{
    public function warehouse()
    {
        $warehouselist = WarehouseModel::whereis_del(0)->get();
        return view('warehouse.warehouse')->with(['warehouselist' => $warehouselist]);
    }
}
