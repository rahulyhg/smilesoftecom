<?php

namespace App\Http\Controllers\Admin;

use App\BarcodeModel;
use App\POSInfoModel;
use App\POSModel;
use App\CustomerModel;
use App\Products_Description;
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

    public function product_list_body(Request $request)
    {
        if ($request->session()->has('warehouse'))
        {
            $warehouse_id = session('warehouse')->id;

            $products = DB::select("SELECT a.w_id, b.products_id, b.language_id, b.products_name, b.products_description, b.products_url, b.products_viewed,b.products_left_banner, b.products_left_banner_start_date, b.products_left_banner_expire_date, b.products_right_banner, b.products_right_banner_start_date, b.products_right_banner_expire_date FROM warehouse_inventory a, products_description b WHERE a.pid = b.products_id AND a.w_id = $warehouse_id");
        }
        elseif ($request->session()->has('staff'))
        {
            $warehouse_id = session('staff')->warehouse_id;
            $products = DB::select("SELECT a.w_id, b.products_id, b.language_id, b.products_name, b.products_description, b.products_url, b.products_viewed,b.products_left_banner, b.products_left_banner_start_date, b.products_left_banner_expire_date, b.products_right_banner, b.products_right_banner_start_date, b.products_right_banner_expire_date FROM warehouse_inventory a, products_description b WHERE a.pid = b.products_id AND a.w_id = $warehouse_id");
        }
        else
            {
//            $products = Products_Description::where(['language_id' => 1])->get();
        }

//        $warehouse_id = session('staff')->warehouse_id;
//        $products = DB::select("select * from warehouse_inventory WHERE w_id = (SELECT * FROM products_description ) ");


//        $products = DB::select("select * from products_description");
        //DB::table('products_description')->where('products_description.products_name', 'LIKE', "%$pro_name%")->get('products_name');
        return view('pos.product_list')->with(['products' => $products]);

    }

    public function recent_invoice(Request $request)
    {
        if ($request->session()->has('staff'))
        {
            $warehouse_id = session('staff')->warehouse_id;
            $staff_id = session('staff')->id;
            $invoice = POSModel::where(['sid'=>$staff_id, 'wid'=>$warehouse_id])->limit(5)->get();
        }
        elseif ($request->session()->has('warehouse'))
        {
            $warehouse_id = session('warehouse')->id;
            $invoice = POSModel::where(['wid'=>$warehouse_id])->limit(5)->get();
        }
        else
        {
            $invoice = POSModel::limit(5)->get();
        }
        return view('pos.pos_list')->with(['invoice' => $invoice]);
    }

    public function getProductRow()
    {
        $pid = request('pid');
        $products = DB::selectOne("select * from products_description WHERE products_id = $pid");
        return view('pos.pro_tr')->with(['products' => $products]);
    }

    public function getProductRowScan()
    {
        $pid = request('barcode');

        $barcode = BarcodeModel::where(['barcode' => $pid])->first();
        if (isset($barcode)) {
            $products = DB::selectOne("select * from products_description WHERE products_id = $barcode->product_id");
            return view('pos.pro_tr')->with(['products' => $products]);
        } /*elseif (preg_match('~[0-9]~', $pid) == false) {
            $products = DB::selectOne("select * from products_description WHERE products_name like '%$pid%'");
            return view('pos.pro_tr')->with(['products' => $products]);
        }*/
        $desc = DB::selectOne("select * from products_description WHERE products_name like '%$pid%'");
        if (isset($desc)) {
            $products = DB::selectOne("select * from products_description WHERE products_name like '%$pid%'");
            return view('pos.pro_tr')->with(['products' => $products]);
        } else {
            return 'Not Available';
        }
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

    public function print_pos($id)
    {
        $pos = POSModel::find($id);
        $pos_info = POSInfoModel::where(['pos_id' => $id])->get();
        return view('pos.print_invoice')->with(['pos' => $pos, 'pos_info' => $pos_info]);
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
