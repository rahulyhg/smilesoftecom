<?php

namespace App\Http\Controllers;

use App\WarehouseModel;
use App\WarehouseStaffModel;
use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Admin\AdminCategoriesController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\AdminSiteSettingController;

class WareHouseController extends Controller
{
    function login()
    {
        return view('warehouse.warehouse_login');
    }

    function loginCheck(Request $request)
    {
        $validator = Validator::make(
            array(
                'username' => $request->username,
                'password' => $request->password,
            ),
            array(
                'username' => 'required | email',
                'password' => 'required',
            )
        );
        if ($validator->fails()) {
            return redirect('warehouse_login')->withErrors($validator)->withInput();
        } else {
            //check authentication of email and password
            $username = request('username');
            $password = request('password');
            $warehouse = WarehouseModel::where(['username' => $username, 'password' => $password, 'is_del' => 0])->first();
            {
                if (isset($warehouse)) {
                    $request->session()->put('warehouse', $warehouse);
                    return redirect('warehouse_dashboard');
                } else {
                    return redirect('warehouse_login')->with('message', 'Username / Password Invalid');
                }
            }
        }

    }
    public function warehouse_dashboard()
    {
        return view('warehouse.dashboard');
    }

//logout
    function logout(Request $request)
    {
        $request->session()->forget('warehouse');
        return redirect('warehouse_login');
    }
    function warehouse_staff()
    {
        $staff = WarehouseStaffModel::where(['is_del'=>0])->paginate(10);
        return view('warehouse.staff_warehouse')->with(['staff'=>$staff]);
    }
    function add_staff()
    {
        return view('warehouse.add_staff');
    }

    function insert_staff()
    {
        $staff = new WarehouseStaffModel();
        $staff->name = request('name');
        $staff->warehouse_id = request('warehouse_id');
        $staff->contact = request('contact');
        $staff->username = request('username');
        $staff->password = request('password');
        $staff->created_date = Carbon::now()->format('Y-m-d');
        $staff->save();

        return redirect()->back()->withErrors('Staff member has been added successfully!')->with(['staff'=>$staff]);
//        return view('warehouse.add_staff')->with(['staff'=>$staff]);
    }
    function staff_edit(Request $request)
    {
        $staff = WarehouseStaffModel::find(request('id'));
        return view('warehouse.staff_edit')->with(['staff'=>$staff]);
    }

    function staff_update()
    {
        $staff_id = request('sid');
        $staff = WarehouseStaffModel::find($staff_id);
        $staff->name = request('name');
        $staff->contact = request('contact');
        $staff->username = request('username');
        $staff->password = request('password');
        $staff->save();

        return redirect('warehouse_staff')->withErrors('Staff member has been updated successfully!');
    }
    function staff_del()
    {
//        return request('sid');
        $staff = WarehouseStaffModel::find(request('sid'));
        $staff->is_del = 1;
        $staff->save();
        return redirect()->back()->withErrors('Staff member has been deleted!');
    }

    function warehouse_products()
    {
        
            $title = array('pageTitle' => Lang::get("labels.Products"));
            $language_id = '1';
            $results = array();

            //get function from other controller
            $myVar = new AdminCategoriesController();
            $subCategories = $myVar->getSubCategories($language_id);

            $data = DB::table('products')
                ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
                ->LeftJoin('manufacturers', function ($join) {
                    $join->on('manufacturers.manufacturers_id', '=', 'products.manufacturers_id');
                })
                ->LeftJoin('specials', function ($join) {
                    $join->on('specials.products_id', '=', 'products.products_id')->where('status', '=', '1');
                });

            if (isset($_REQUEST['categories_id']) and !empty($_REQUEST['categories_id']) or !empty(session('categories_id'))) {
                $data->leftJoin('products_to_categories', 'products.products_id', '=', 'products_to_categories.products_id')
                    ->leftJoin('categories', 'categories.categories_id', '=', 'products_to_categories.categories_id');
            }

            $data->select('products.*', 'products_description.*', 'specials.specials_id', 'manufacturers.*', 'specials.products_id as special_products_id', 'specials.specials_new_products_price as specials_products_price', 'specials.specials_date_added as specials_date_added', 'specials.specials_last_modified as specials_last_modified', 'specials.expires_date')
                ->where('products_description.language_id', '=', $language_id);

            if (isset($_REQUEST['categories_id']) and !empty($_REQUEST['categories_id'])) {

                if (!empty(session('categories_id'))) {
                    $cat_array = explode(',', session('categories_id'));
                    $data->whereIn('products_to_categories.categories_id', '=', $cat_array);
                }

                $data->where('products_to_categories.categories_id', '=', $_REQUEST['categories_id']);

            } else {
                if (!empty(session('categories_id'))) {
                    $cat_array = explode(',', session('categories_id'));
                    $data->whereIn('products_to_categories.categories_id', $cat_array);
                }
            }

            if (isset($_REQUEST['product']) and !empty($_REQUEST['product'])) {
                $data->where('products_name', 'like', '%' . $_REQUEST['product'] . '%');
            }

            $products = $data->orderBy('products.products_id', 'DESC')->paginate(40);

            $results['subCategories'] = $subCategories;
            $results['products'] = $products;

            //get function from other controller
            $myVar = new AdminSiteSettingController();
            $results['currency'] = $myVar->getSetting();
            $results['units'] = $myVar->getUnits();

            $currentTime = array('currentTime' => time());
            return view("warehouse.warehouse_products", $title)->with('results', $results);
            // return view('warehouse.warehouse_login');
    }

    public function addinventory(Request $request)
    {
       

            $title = array('pageTitle' => Lang::get("labels.ProductInventory"));
            $language_id = '1';
            $products_id = $request->id;

            $result = array();
            $message = array();
            $errorMessage = array();
            $myVar = new AdminSiteSettingController();
            $result['currency'] = $myVar->getSetting();

            $result['products'] = $this->getProducts($products_id);
            $result['message'] = $message;
            $result['errorMessage'] = $errorMessage;

            $result2 = array();
            $index = 0;
            $stocks = 0;
            $min_level = 0;
            $max_level = 0;
            $purchase_price = 0;
            if ($result['products'][0]->products_type != 1) {

                $addedStock = DB::table('inventory')->where('products_id', $result['products'][0]->products_id)->where('stock_type', 'in')->sum('stock');
                $purchasedStock = DB::table('inventory')->where('products_id', $result['products'][0]->products_id)->where('stock_type', 'out')->sum('stock');

                $purchase_price = DB::table('inventory')->where('products_id', $result['products'][0]->products_id)->sum('purchase_price');
                $stocks = $addedStock - $purchasedStock;
                $manageLevel = DB::table('manage_min_max')->where('products_id', $result['products'][0]->products_id)->get();
                if (count($manageLevel) > 0) {
                    $min_level = $manageLevel[0]->min_level;
                    $max_level = $manageLevel[0]->max_level;
                }
            }

            $result['purchase_price'] = $purchase_price;
            $result['stocks'] = $stocks;
            $result['min_level'] = $min_level;
            $result['max_level'] = $max_level;
            $result['attributes'] = array();
            $products_attribute = DB::table('products_attributes')->where('products_id', '=', $products_id)->groupBy('options_id')->get();

            if (count($products_attribute) > 0) {
                $index2 = 0;

                foreach ($products_attribute as $attribute_data) {

                    $option_name = DB::table('products_options')
                        ->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
                        ->select('products_options.products_options_id', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id')->where('products_options_descriptions.language_id', $language_id)->where('products_options.products_options_id', $attribute_data->options_id)->get();

                    if (count($option_name) > 0) {

                        $temp = array();

                        $temp_option['id'] = $attribute_data->options_id;

                        $temp_option['name'] = $option_name[0]->products_options_name;

                        $attr[$index2]['option'] = $temp_option;

                        // fetch all attributes add join from products_options_values table for option value name

                        $attributes_value_query = DB::table('products_attributes')->where('products_id', '=', $products_id)->where('options_id', '=', $attribute_data->options_id)->get();

                        foreach ($attributes_value_query as $products_option_value) {

                            $option_value = DB::table('products_options_values')->join('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')->select('products_options_values.products_options_values_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')->where('products_options_values_descriptions.language_id', '=', $language_id)->where('products_options_values.products_options_values_id', '=', $products_option_value->options_values_id)->get();

                            if (count($option_value) > 0) {

                                $attributes = DB::table('products_attributes')->where([['products_id', '=', $products_id], ['options_id', '=', $attribute_data->options_id], ['options_values_id', '=', $products_option_value->options_values_id]])->get();

                                $temp_i['products_attributes_id'] = $attributes[0]->products_attributes_id;

                                $temp_i['id'] = $products_option_value->options_values_id;

                                $temp_i['value'] = $option_value[0]->products_options_values_name;

                                $temp_i['price'] = $products_option_value->options_values_price;

                                $temp_i['price_prefix'] = $products_option_value->price_prefix;

                                array_push($temp, $temp_i);

                            }

                        }

                        $attr[$index2]['values'] = $temp;

                        $result['attributes'] = $attr;

                        $index2++;
                    }

                }
            } else {
                $result['attributes'] = array();
            }

            return view("warehouse.warehouseaddinventory", $title)->with('result', $result);

        
    }
}
