<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SupplierModel;
use Illuminate\Http\Request;

class AdminSupplierController extends Controller
{
    public function supplier()
    {

        $title = array('pageTitle' => 'Supplier');
        $supplier = SupplierModel::whereis_del(0)->get();
        return view("admin.supplier.supplier", $title)->with('supplier', $supplier);

    }

    public function addsupplier(Request $request)
    {

        $title = array('pageTitle' => 'Add Supplier');
        return view("admin.supplier.addsupplier", $title);

    }

    public function addnewsupplier(Request $request)
    {
        $vendor = new SupplierModel();
        $vendor->name = request('name');
        $vendor->contact = request('contact');
        $vendor->gst_no = request('gst_no');
        $vendor->address = request('address');
        $vendor->bank = request('bank');
        $vendor->account = request('account');
        $vendor->save();
        return redirect('admin/supplier')->with('message', 'New Supplier has been Added');

    }

    public function editsupplier($id, Request $request)
    {

        $title = array('pageTitle' => 'Edit Supplier');
        $id = base64_decode($id);
        $supplier = SupplierModel::find($id);
        // return $supplier;
        return view("admin.supplier.editsupplier", $title)->with('supplier', $supplier);

    }

    public function updatesupplier($id, Request $request)
    {
        $vendor = SupplierModel::find($id);
        $vendor->name = request('name');
        $vendor->contact = request('contact');
        $vendor->gst_no = request('gst_no');
        $vendor->address = request('address');
        $vendor->bank = request('bank');
        $vendor->account = request('account');
        $vendor->save();
        // return redirect('admin/supplier')->with('message', 'New Supplier has been Added');
        return redirect()->back()->withErrors('Supplier has been Updated');

    }

    public function deletesupplier(Request $request)
    {

        $did = request('did');
        $vendor = SupplierModel::find($did);
        $vendor->is_del = 1;
        $vendor->save();
        return 'done';

    }

    //getManufacturer
    public function getManufacturer($language_id)
    {

        $getManufacturers = DB::table('manufacturers')
            ->leftJoin('manufacturers_info', 'manufacturers_info.manufacturers_id', '=', 'manufacturers.manufacturers_id')
            ->select('manufacturers.manufacturers_id as id', 'manufacturers.manufacturers_image as image', 'manufacturers.manufacturers_name as name', 'manufacturers_info.manufacturers_url as url', 'manufacturers_info.url_clicked', 'manufacturers_info.date_last_click as clik_date')
            ->where('manufacturers_info.languages_id', $language_id)->get();
        return ($getManufacturers);
    }
}
