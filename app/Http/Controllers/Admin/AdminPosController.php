<?php

namespace App\Http\Controllers\Admin;

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

    public function getProductRow()
    {
        $pid = request('pid');
        $products = DB::selectOne("select * from products_description WHERE products_id = $pid");
        return view('pos.pro_tr')->with(['products' => $products]);

    }

    public function store_pos()
    {
        dd($_REQUEST);
        $count = count($_POST["partyId"]);
        if ($count > 0) {
            try {
                $stock = new Voucher();
                $stock->voucher_no = request('voucher_no');
                $stock->dispatch_no = request('dispatch_no');
                $stock->supplier_id = request('supplier_id');
                $stock->voucher_date = Carbon::parse(request('voucher_date'))->format('Y-m-d');
                $stock->created_time = Carbon::now('Asia/Kolkata');
                $stock->save();
                $this->addNewRows($stock->id, $count);
                return redirect('voucher')->with('message', 'Voucher has been added...!');
            } catch (\Exception $e) {
                echo $e;
            }
        } else {
            return Redirect::back()->with('errmessage', 'Please select any goods');
        }
    }

    public function addNewRows($id, $count)
    {
        for ($i = 0; $i < $count; $i++) {
            if (trim($_POST["partyId"][$i]) != "") {
                $vouchers = VoucherDetails::where(['invoice_id' => $_POST["invoice_id"][$i], 'partyId' => $_POST["partyId"][$i]])->first();
                if (!isset($vouchers)) {
                    $trn = Transaction::find($_POST["invoice_id"][$i]);
                    $trn->is_voucher_created = 1;
                    $trn->save();
                    $stock_info = new VoucherDetails();
                    $stock_info->voucher_id = $id;
                    $stock_info->partyId = $_POST["partyId"][$i];
                    $stock_info->invoice_id = $_POST["invoice_id"][$i];
                    $stock_info->bank = $_POST["bank"][$i];
//                    $stock_info->amount = $_POST["amount"][$i];
                    $stock_info->dd = $_POST["dd"][$i];
                    $stock_info->ddAmt = $_POST["ddAmt"][$i];
                    $stock_info->remark = $_POST["remark"][$i];
                    $stock_info->save();
                } else {
                    $vouchers->voucher_id = $id;
                    $vouchers->partyId = $_POST["partyId"][$i];
                    $vouchers->invoice_id = $_POST["invoice_id"][$i];
                    $vouchers->bank = $_POST["bank"][$i];
//                    $vouchers->amount = $_POST["amount"][$i];
                    $vouchers->dd = $_POST["dd"][$i];
                    $vouchers->ddAmt = $_POST["ddAmt"][$i];
                    $vouchers->remark = $_POST["remark"][$i];
                    $vouchers->save();
                }
//                $product_godown = GodownProduct::where(['godown_id' => session('godownmaster')->id, 'product_id' => $stock_info->product_id])->first();
//                if (isset($product_godown)) {
//                    $item = GodownProductSize::where(['product_godown_id' => $product_godown->id, 'size_id' => $stock_info->size_id])->first();
//                    $item->available_qty += $stock_info->qty;
//                    $item->save();
//
//                    $product_size = ProductSize::where(['product_id' => $stock_info->product_id, 'size_id' => $stock_info->size_id])->first();
//                    $product_size->stock += $stock_info->qty;
//                    $product_size->save();
//                }

            }
        }
    }

    public function customer_add()
    {
        $customer_name = request('cname');
        $contact = request('contact');
        $address = request('address');

        if (isset($contact))
        {
            $customer = new CustomerModel();
            $customer->name = $customer_name;
            $customer->contact = $contact;
            $customer->address = $address;
            $customer->save();
            return Redirect('admin/pos')->with('message', 'Customer Added Successfully:)');
        }
        else
            {
            return Redirect('admin/pos')->with('errmessage', 'Customer Registration Failed:(');
        }

    }
    public function getCustomer()
    {
        $customer = CustomerModel::where(['is_del'=>0])->get();
        return $customer;
    }

}
