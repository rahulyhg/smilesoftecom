<?php

namespace App\Http\Controllers\Admin;

use App\ProductsModel;
use App\Warehouse_Inventory_Model;
use App\WarehouseModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Validator;

class AdminWareHouseController extends Controller
{
    public function warehouse()
    {
        $title = array('pageTitle' => 'Warehouse');
        $warehouselist = WarehouseModel::whereis_del(0)->get();
//            return view('warehouse.warehouse')->with(['warehouselist' => $warehouselist]);
        return view("warehouse.warehouse", $title)->with('warehouselist', $warehouselist);

    }

    public function addwarehouse(Request $request)
    {
        $title = array('pageTitle' => 'Add Warehouse');
        return view("warehouse.addWarehouse", $title);
    }

    public function insert_warehouse(Request $request)
    {
        if (session('manufacturer_create') == 0) {
            print Lang::get("labels.You do not have to access this route");
        } else {

//            $validator = Validator::make(
//                array(
//                    'username' => $request->username,
//                    'password' => $request->password,
//                ),
//                array
//                (
//                    'username' => 'required | email',
//                    'password' => 'required',
//                )
//            );
//            if ($validator->fails()) {
//                return redirect('admin/addWarehouse')->withErrors($validator)->withInput();
//            } else {
            $warehouse = new WarehouseModel();
            $warehouse->name = request('name');
            $warehouse->location = request('location');
            $warehouse->latitude = request('latitude');
            $warehouse->longitude = request('longitude');
            $warehouse->username = request('username');
            $warehouse->password = request('password');
            $warehouse->save();

            $products = ProductsModel::get();
            foreach ($products as $item) {
                $warehouse_inventory = new Warehouse_Inventory_Model();
                $warehouse_inventory->w_id = $warehouse->id;
                $warehouse_inventory->pid = $item->products_id;
                $warehouse_inventory->stock = 0;
                $warehouse_inventory->save();
            }

            $title = array('pageTitle' => 'Add Warehouse');

//                return back()->with(['title' => $title], 'message', 'New Warehouse Has Been Added');
            return redirect()->back()->withErrors('Warehouse has been added successfully!');
        }
//        }
    }

    public
    function deletewarehouse()
    {
//        DB::table('warehouse')->where('id', request('warehouse_id'))->first();

        $warehouse = WarehouseModel::find(request('warehouse_id'));
        $warehouse->is_del = 1;
        $warehouse->save();
        return redirect()->back()->withErrors('Warehouse has been deleted successfully!');
    }

    public
    function editWarehouse(Request $request)
    {
        $title = array('pageTitle' => 'Edit Warehouse Details');

        $warehouse_id = $request->id;

        $warehouse = WarehouseModel::find($warehouse_id);

        return view("warehouse.editWarehouse", $title)->with('warehouse', $warehouse);
    }

    public
    function updatewarehouse(Request $request)
    {
        $warehouse_id = request('wid');
        $warehouse = WarehouseModel::find($warehouse_id);

        $warehouse->name = request('name');
        $warehouse->location = request('location');
        $warehouse->latitude = request('latitude');
        $warehouse->longitude = request('longitude');
        $warehouse->username = request('username');
        $warehouse->password = request('password');
        $warehouse->updated_at = Carbon::now();
        $warehouse->save();

        return redirect()->back()->withErrors('Manufacturer has been updated successfully!');

    }
}
