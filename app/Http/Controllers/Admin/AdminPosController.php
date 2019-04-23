<?php

namespace App\Http\Controllers\Admin;

use App\POSInfoModel;
use App\POSModel;
use App\CustomerModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminPosController extends Controller
{
    public function create_pos()
    {
        $language_id = '1';

        //get function from other controller
        $myVar = new AdminCategoriesController();
        $result['categories'] = $myVar->allCategories($language_id);

        //get function from other controller
        $myVar = new AdminManufacturerController();
        $result['manufacturer'] = $myVar->getManufacturer($language_id);
        return view('pos.create_pos')->with('result', $result);
    }

    public function getproducts()
    {
        $pro_name = request('products_name');
        $product = DB::select("select products_name from products_description where products_name like '%$pro_name%'"); //DB::table('products_description')->where('products_description.products_name', 'LIKE', "%$pro_name%")->get('products_name');
        return $product;
    }

    public function product_list_body()
    {
        $products = DB::select("select * from products_description"); //DB::table('products_description')->where('products_description.products_name', 'LIKE', "%$pro_name%")->get('products_name');
        return view('pos.product_list')->with(['products' => $products]);

    }

    public function recent_invoice()
    {
//        $warehouse_id = request('wid');
//        $staff_id = request('sid');
        $invoice = POSModel::all();
//        $invoice = DB::select("select * from pos");
        return view('pos.pos_list')->with(['invoice' => $invoice]);
    }

    public function getProductRow()
    {
        $pid = request('pid');
        $products = DB::selectOne("select * from products_description WHERE products_id = $pid");
        return view('pos.pro_tr')->with(['products' => $products]);

    }

    public function store_pos()
    {
        if (isset($_POST["products_id"]) && count($_POST["products_id"]) > 0) {
            $count = count($_POST["products_id"]);
            if ($count > 0) {
                try {
                    $stock = new POSModel();
                    $stock->invoice_no = "SP" . rand(1000, 9999);
                    $stock->invoice_date = Carbon::now('Asia/Kolkata');
                    $stock->customer_id = request('customer_id');
                    $stock->grand_total = request('final_total');
                    $stock->wid = 1;
                    $stock->sid = 1;
                    $stock->created_time = Carbon::now('Asia/Kolkata');
                    $stock->save();
                    $this->addNewRows($stock->id, $count);
                    return redirect('admin/pos')->with('message', 'POS has been added...!');
                } catch (\Exception $e) {
                    echo $e;
                }
            } else {
                return Redirect::back()->with('errmessage', 'Please select any goods');
            }
        } else {
            return Redirect::back()->with('errmessage', 'Please select any products');
        }
    }

    public function addNewRows($id, $count)
    {
        for ($i = 0; $i < $count; $i++) {
            if (trim($_POST["products_id"][$i]) != "") {
                $vouchers = POSInfoModel::where(['product_id' => $_POST["products_id"][$i], 'pos_id' => $id])->first();
                if (!isset($vouchers)) {
                    $stock_info = new POSInfoModel();
                    $stock_info->pos_id = $id;
                    $stock_info->product_id = $_POST["products_id"][$i];
                    $stock_info->qty = $_POST["quantity"][$i];
                    $stock_info->price = $_POST["price"][$i];
                    $stock_info->total = $_POST["totalAmt"][$i];
                    $stock_info->save();
                } else {
                    $vouchers->pos_id = $id;
                    $vouchers->product_id = $_POST["products_id"][$i];
                    $vouchers->qty = $_POST["quantity"][$i];
                    $vouchers->price = $_POST["price"][$i];
                    $vouchers->total = $_POST["totalAmt"][$i];
                    $vouchers->save();
                }
            }
        }
    }

    public function customer_add()
    {
        $customer_name = request('cname');
        $contact = request('contact');
        $address = request('address');

        if (isset($contact)) {
            $customer = new CustomerModel();
            $customer->name = $customer_name;
            $customer->contact = $contact;
            $customer->address = $address;
            $customer->save();
            return Redirect('admin/pos')->with('message', 'Customer Added Successfully:)');
        } else {
            return Redirect('admin/pos')->with('errmessage', 'Customer Registration Failed:(');
        }

    }

    public function getCustomer()
    {
        $customer = CustomerModel::where(['is_del' => 0])->get();
        return $customer;
    }

    public function getCustID()
    {
        $customer = CustomerModel::where()->get();
        return $customer;
    }

}
