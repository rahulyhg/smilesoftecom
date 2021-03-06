<?php

namespace App\Http\Controllers;

use App\BarcodeModel;
use App\CategoryModel;
use App\CustomerModel;
use App\ErrorLog;
use App\Http\Controllers\Admin\AdminCategoriesController;
use App\Http\Controllers\Admin\AdminManufacturerController;
use App\POSInfoModel;
use App\POSModel;
use App\Products_Description;
use App\products_to_categories;
use App\Warehouse_inventory_history_Model;
use App\Warehouse_Inventory_Model;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;

class POSController extends Controller
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
        if ($request->session()->has('warehouse')) {
            $products = Products_Description::where(['language_id' => 1])->get();
        } elseif ($request->session()->has('staff')) {
//            return json_encode(session('staff'));

            $products = DB::table('products_description')
                ->join('warehouse_inventory', function ($join) {
                    $join->on('products_description.products_id', '=', 'warehouse_inventory.pid')
                        ->where('warehouse_inventory.w_id', '=', session('staff')->warehouse_id)
//                        ->where('warehouse_inventory.stock' != 0)
                        ->where(['language_id' => 1]);
                })->orderBy('products_description.products_name', 'asc')->paginate(request('page'));
//            $products = Products_Description::where(['language_id'=>1, 'w_id'=>session('staff')->warehouse_id])->get();
        } else {
            $products = Products_Description::where(['language_id' => 1])->get();
        }
//        $products = DB::select("select * from products_description");
        //DB::table('products_description')->where('products_description.products_name', 'LIKE', "%$pro_name%")->get('products_name');
        return view('pos.product_list')->with(['products' => $products]);

    }

    public function recent_invoice()
    {
//        $warehouse_id = session('warehouse')->id;
//        $staff_id = session('staff')->id;
        $invoice = POSModel::orderBy('id', 'desc')->take(10)->get();
//        $invoice = DB::select("select * from pos");
        return view('pos.pos_list')->with(['invoice' => $invoice]);
    }

    public function getProductRow()
    {
        $pid = request('pid');
        $products = DB::selectOne("select * from products_description WHERE products_id = $pid");
        $ware_inv = Warehouse_Inventory_Model::where(['pid' => $pid, 'w_id' => session('staff')->warehouse_id])->first();
        if ($ware_inv->stock > 0){
            return view('pos.pro_tr')->with(['products' => $products, 'stock' => $ware_inv->stock]);
        }else{
            return 'Stock Not Available';
        }
    }

    public function getProductRowScan()
    {
        $pid = request('barcode');

        if ($pid != null) {
            $barcode = BarcodeModel::where(['barcode' => $pid])->first();
            if (isset($barcode)) {
                $products = DB::selectOne("select * from products_description WHERE products_id = $barcode->product_id");
                $ware_inv = Warehouse_Inventory_Model::where(['pid' => $barcode->products_id, 'w_id' => session('staff')->warehouse_id])->first();

                if ($ware_inv->stock > 0) {
                    return view('pos.pro_tr')->with(['products' => $products, 'stock' => $ware_inv->stock]);
                } else {
                    return 'Stock Not Available';
                }
            } /*elseif (preg_match('~[0-9]~', $pid) == false) {
            $products = DB::selectOne("select * from products_description WHERE products_name like '%$pid%'");
            return view('pos.pro_tr')->with(['products' => $products]);
        }*/
            $desc = DB::selectOne("select * from products_description WHERE products_name like '%$pid%'");
            if (isset($desc)) {
                $products = DB::selectOne("select * from products_description WHERE products_name like '%$pid%'");
                $ware_inv = Warehouse_Inventory_Model::where(['pid' => $products->products_id, 'w_id' => session('staff')->warehouse_id])->first();
                if ($ware_inv->stock > 0) {
                    return view('pos.pro_tr')->with(['products' => $products, 'stock' => $ware_inv->stock]);
                } else {
                    return 'Stock Not Available';
                }
            } else {
                return 'Not Available';
            }
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
                    $stock->payment_mode = request('payment_mode');
                    $stock->wid = session('staff')->warehouse_id;
                    $stock->sid = session('staff')->id;
                    $stock->created_time = Carbon::now('Asia/Kolkata');
                    $stock->save();
                    $this->addNewRows($stock->id, $count);
                    $pos = $stock->id;
//                    return redirect('invoice')->with('message', 'POS has been added...!');
                    return view('pos.print_invoice')->with(['pos_main' => $stock]);
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
                    $win = Warehouse_Inventory_Model::where(['w_id' => session('staff')->warehouse_id, 'pid' => $_POST["products_id"][$i]])->first();
                    if (isset($win)) {
                        $win->stock -= $stock_info->qty;
                        $win->save();

                        $winhi = new Warehouse_inventory_history_Model();
                        $winhi->w_id = session('staff')->warehouse_id;
                        $winhi->pid = $_POST["products_id"][$i];
                        $winhi->stock -= $stock_info->qty;
                        $winhi->save();

                    }
                } else {
                    $vouchers->pos_id = $id;
//                    $vouchers->product_id = $_POST["products_id"][$i];
                    $vouchers->qty += $_POST["quantity"][$i];
//                    $vouchers->price = $_POST["price"][$i];
//                    $vouchers->total = $_POST["totalAmt"][$i];
                    $vouchers->save();

                    $win = Warehouse_Inventory_Model::where(['w_id' => session('staff')->warehouse_id, 'pid' => $_POST["products_id"][$i]])->first();
                    if (isset($win)) {
                        $win->stock -= $vouchers->qty;
                        $win->save();
                        $winhi = new Warehouse_inventory_history_Model();
                        $winhi->w_id = session('staff')->warehouse_id;
                        $winhi->pid = $_POST["products_id"][$i];
                        $winhi->stock -= $vouchers->qty;
                        $winhi->save();
                    }
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
            return redirect('pos')->with('message', 'Customer Added Successfully:)');
        } else {
            return redirect('pos')->with('errmessage', 'Customer Registration Failed:(');
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

    public function inv()
    {
        return view('pos.print_invoice');
    }

    public function print_pos($id)
    {
        $pos_main = POSModel::find($id);
        $pos_info = POSInfoModel::where(['pos_id' => $id])->get();
        return view('pos.print_invoice')->with(['pos_main' => $pos_main, 'pos_info' => $pos_info]);
    }

//    public function autoComplete(Request $request)
//    {
//        $data = Products_Description::select("products_name")
//            ->where("products_name","LIKE","%{$request->input('query')}%")
//            ->get();
//
//        return response()->json($data);
//    }

    public function autoComplete(Request $request)
    {
        $query = $request->get('term', '');

        $products = Products_Description::where('products_name', 'LIKE', '%' . $query . '%')->take(10)->get();

        $data = array();
        foreach ($products as $product) {
            $ware_inv = Warehouse_Inventory_Model::where(['pid' => $product->products_id, 'w_id' => session('staff')->warehouse_id])->first();
            $pro = $product->products_name /*. " - Stock " .$ware_inv->stock */
            ;
            $data[] = array('value' => $pro, 'id' => $product->products_id);
        }
        if (count($data))
            return $data;
        else
            return ['value' => 'No Result Found', 'id' => ''];
    }

    public function getCategoryid()
    {
//        $category_added = products_to_categories::distinct();
        $category_added = DB::table('products_to_categories')->get();

//        dd(($category_added));
        foreach ($category_added as $cate) {
            $categortrr = CategoryModel::find($cate->categories_id);
            if (isset($categortrr)) {
                $check = products_to_categories::where(['products_id' => $cate->products_id, 'categories_id' => $categortrr->sabcategory_id])->first();
                if (!isset($check)) {
                    if (isset($categortrr->sabcategory_id)) {
                        $customer = new products_to_categories();
                        $customer->products_id = $cate->products_id;
                        $customer->categories_id = $categortrr->sabcategory_id;
                        $customer->save();
                    }
                }
            }

//            $customer = new products_to_categories();
//            $customer->products_id = 0;
//            $customer->categories_id = 0;
//            $customer->save();
        }
        echo "Done";
//        return view('pos.print_invoice');
    }

    public function get_error_log()
    {
        $errors = ErrorLog::whereNotNull('error_msg')->orderBy('id', 'desc')->paginate(30);
        return view('errors.view_errors')->with(['errors'=>$errors]);
        // $i = count($errors);
        // if (count($errors) > 0) {

        //     foreach ($errors as $error) {
        //         echo $i . "<b>.  Error Msg: </b>" . $error->error_msg . "</br>" . "<b>Controller: </b>" . $error->controller_name . "</br>" . "<b>Function: </b>" . $error->function_name . "</br><b>Time: </b>" . $error->created_time . "</br></br>";
        //         $i--;
        //     }
        // } else {
        //     return "No More Error Logs Available...";
        // }
    }
}
