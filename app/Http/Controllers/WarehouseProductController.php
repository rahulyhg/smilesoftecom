<?php

namespace App\Http\Controllers;

use App\BarcodeModel;
use App\CategoryDescriptionModel;
use App\CategoryModel;
use App\Http\Controllers\WarehouseAlertController;
use App\Http\Controllers\WarehouseCategoriesController;
use App\Http\Controllers\WarehouseManufacturerController;
use App\Http\Controllers\WarehouseSiteSettingController;
use App\InventoryModel;
use App\ManufacturerModel;
use App\Products_Description;
use App\ProductsModel;
use App\TaxClassModel;
use App\TaxRatesModel;
use App\UnitsModel;
use App\Warehouse_inventory_history_Model;
use App\Warehouse_Inventory_Model;
use App\WarehouseModel;
//use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class WarehouseProductController extends Controller
{
    public function products(Request $request)
    {
        $title = array('pageTitle' => 'Products');
        $language_id = '1';
        $results = array();

        //get function from other controller
        $myVar = new WarehouseCategoriesController();
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
        $myVar = new WarehouseSiteSettingController();
        $results['currency'] = $myVar->getSetting();
        $results['units'] = $myVar->getUnits();

        $currentTime = array('currentTime' => time());
        return view("warehouse.warehouse_products.products", $title)->with('results', $results);
    }

    //deleteProduct
    public function deleteproduct(Request $request)
    {
        $products_id = $request->products_id;

        $categories = DB::table('products_to_categories')->where('products_id', $products_id)->delete();
        $categories = DB::table('products')->where('products_id', $products_id)->delete();
        $categories = DB::table('specials')->where('products_id', $products_id)->delete();
        $categories = DB::table('products_description')->where('products_id', $products_id)->delete();
        $categories = DB::table('products_attributes')->where('products_id', $products_id)->delete();
        $categories = DB::table('inventory')->where('products_id', $products_id)->delete();
        $categories = DB::table('inventory_detail')->where('products_id', $products_id)->delete();
        $categories = DB::table('flash_sale')->where('products_id', $products_id)->delete();
        $categories = DB::table('products_images')->where('products_id', $products_id)->delete();

        return redirect()->back()->withErrors('Product has been deleted successfully!');
    }

    //get product
    public function getProducts($products_id)
    {

        $language_id = 1;

        $product = DB::table('products')
            ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->leftJoin('manufacturers', 'manufacturers.manufacturers_id', '=', 'products.manufacturers_id')
            ->leftJoin('manufacturers_info', 'manufacturers.manufacturers_id', '=', 'manufacturers_info.manufacturers_id')
            ->LeftJoin('specials', function ($join) {
                $join->on('specials.products_id', '=', 'products.products_id')->where('status', '=', '1');
            })
            ->select('products.*', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_id', 'specials.products_id as special_products_id', 'specials.specials_new_products_price as specials_products_price', 'specials.specials_date_added as specials_date_added', 'specials.specials_last_modified as specials_last_modified', 'specials.expires_date')
            ->where('products_description.language_id', '=', $language_id);

        if ($products_id != null) {
            $product->where('products.products_id', '=', $products_id);
        } else {
            $product->orderBy('products.products_id', 'DESC');
        }

        $products = $product->get();
        return ($products);
    }

    function barcode_generate(Request $request)
    {
        $bid = request('bid');
        $barcount = request('barcount');
        $request->session()->put('bar_id', $bid);
        $request->session()->put('bar_qty', $barcount);
        $pdf = PDF::loadView('printbarcode');
        return $pdf->stream();

//        $data = \App\BarcodeModel::whereproduct_id($bid)->first();
//        $i = 1;
//        for ($j = 1; $j <= $barcount; $j++) {
//            echo '<img src="data:image/png;base64,' . \Milon\Barcode\DNS1D::getBarcodePNG($data->barcode, "C39+", 2, 33, array(1, 1, 1), true) . '" alt="barcode"   />';
//            echo '<br>';
//            if ($i == 3) {
//                $i = 0;
//            }
//            $i++;
//        }
//        return $pdf->stream();
    }

    public function addproduct(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddProduct"));
        $language_id = '1';

        $result = array();

        //get function from other controller
        $myVar = new WarehouseCategoriesController();
        $result['categories'] = $myVar->allCategories($language_id);

        //get function from other controller
        $myVar = new WarehouseManufacturerController();
        $result['manufacturer'] = $myVar->getManufacturer($language_id);

        //tax class
//            $taxClass = DB::table('tax_class')->get();
        $taxClass = TaxClassModel::get();
        $result['taxClass'] = $taxClass;

        $taxRate = TaxRatesModel::get();
        $result['taxRate'] = $taxRate;

        //get function from other controller
        $myVar = new WarehouseSiteSettingController();
        $result['languages'] = $myVar->getLanguages();
        $result['units'] = $myVar->getUnits();

        return view("warehouse.warehouse_products.addproduct", $title)->with('result', $result);
    }

//addNewProduct
    public function addnewproduct(Request $request)
    {
        
        if (session()->has('warehouse')) {
            $warehouse_id = session('warehouse')->id;
        } else {
            $warehouse_id = 0;
        }
        $title = array('pageTitle' => 'Add Attributes');
        $language_id = '1';
        $date_added = date('Y-m-d h:i:s');

        //get function from other controller
        $myVar = new WarehouseSiteSettingController();
        $languages = $myVar->getLanguages();
        $extensions = $myVar->imageType();

        $expiryDate = str_replace('/', '-', $request->expires_date);
        $expiryDateFormate = strtotime($expiryDate);

        if ($request->hasFile('products_image') and in_array($request->products_image->extension(), $extensions)) {
            $image = $request->products_image;
            $fileName = time() . '.' . $image->getClientOriginalName();
            $image->move('resources/assets/images/product_images/', $fileName);
            $uploadImage = 'resources/assets/images/product_images/' . $fileName;
        } else {
            $uploadImage = '';
        }

        // $products_id = DB::table('products')->insertGetId([
        //     'product_id' => $request->product_id,
        //     'quantity' => $request->quantity,
        //     'cost_price' => $request->cost_price,
        //     'selling_price' => $request->selling_price,
        //     'barcode' => $request->barcode,
        //     'pdf_path' => $request->pdf_path,
        //     'created_at' => Carbon::now()->format('Y-m-d'),
        //     'updated_at' => Carbon::now()->format('Y-m-d')
        // ]);

        $products_id = DB::table('products')->insertGetId([
            'products_image' => $uploadImage,
            'warehouse_id' => $warehouse_id,
            'manufacturers_id' => $request->manufacturers_id,
            'products_quantity' => 0,
            'products_model' => $request->products_model,
            'products_price' => $request->products_price,
            // 'products_purchase_price' => $request->products_purchase_price,
            'products_date_added' => $date_added,
            'products_weight' => $request->products_weight,
            'products_status' => $request->products_status,
            'products_tax_class_id' => $request->tax_class_id,
//                'product_cgst' => $request->cgst,
//                'product_sgst' => $request->sgst,
//                'product_igst' => $request->igst,
            'products_weight_unit' => $request->products_weight_unit,
            'low_limit' => 0,
            'products_type' => $request->products_type,
            'is_feature' => $request->is_feature,
            'is_prime' => $request->is_prime,
            'prime_percent' => $request->prime_percent,
            'products_min_order' => $request->products_min_order,
            'products_max_stock' => $request->products_max_stock,
        ]);

        $barcode = new BarcodeModel();
        $barcode->product_id = $products_id;
        $barcode->cost_price = $request->products_purchase_price;
        $barcode->selling_price = $request->products_price;
        $barcode->barcode = request('barcode');
        $barcode->save();

        $data = WarehouseModel::whereis_del(0)->get();
        foreach ($data as $obj) {
            $warehouse_inventory = new Warehouse_Inventory_Model();
            $warehouse_inventory->w_id = $obj->id;
            $warehouse_inventory->pid = $products_id;
            $warehouse_inventory->stock = 0;
            $warehouse_inventory->save();
        }

        $slug_flag = false;
        foreach ($languages as $languages_data) {
            $products_name = 'products_name_' . $languages_data->languages_id;
            $products_url = 'products_url_' . $languages_data->languages_id;
            $products_description = 'products_description_' . $languages_data->languages_id;

            //left banner
            $products_left_banner = 'products_left_banner_' . $languages_data->languages_id;

            $products_left_banner_start_date = 'products_left_banner_start_date_' . $languages_data->languages_id;
            if (!empty($request->$products_left_banner_start_date)) {

                $leftStartDate = str_replace('/', '-', $request->$products_left_banner_start_date);
                $leftStartDateFormat = strtotime($leftStartDate);
            } else {
                $leftStartDateFormat = '';
            }

            //expire date
            $products_left_banner_expire_date = 'products_left_banner_expire_date_' . $languages_data->languages_id;
            if (!empty($request->$products_left_banner_expire_date)) {
                $leftExpiretDate = str_replace('/', '-', $request->$products_left_banner_expire_date);
                $leftExpireDateFormat = strtotime($leftExpiretDate);
            } else {
                $leftExpireDateFormat = '';
            }

            //right banner
            $products_right_banner = 'products_right_banner_' . $languages_data->languages_id;

            $products_right_banner_start_date = 'products_right_banner_start_date_' . $languages_data->languages_id;
            if (!empty($request->$products_right_banner_start_date)) {
                $rightStartDate = str_replace('/', '-', $request->$products_right_banner_start_date);
                $rightStartDateFormat = strtotime($rightStartDate);
            } else {
                $rightStartDateFormat = '';
            }

            //expire date
            $products_right_banner_expire_date = 'products_right_banner_expire_date_' . $languages_data->languages_id;
            if (!empty($request->$products_right_banner_expire_date)) {
                $rightExpiretDate = str_replace('/', '-', $request->$products_right_banner_expire_date);
                $rightExpireDateFormat = strtotime($rightExpiretDate);
            } else {
                $rightExpireDateFormat = '';
            }

            //slug
            if ($slug_flag == false) {
                $slug_flag = true;

                $slug = $request->$products_name;
                $old_slug = $request->$products_name;

                $slug_count = 0;
                do {
                    if ($slug_count == 0) {
                        $currentSlug = $myVar->slugify($slug);
                    } else {
                        $currentSlug = $myVar->slugify($old_slug . '-' . $slug_count);
                    }
                    $slug = $currentSlug;
                    $checkSlug = DB::table('products')->where('products_slug', $currentSlug)->get();
                    $slug_count++;
                } while (count($checkSlug) > 0);
                DB::table('products')->where('products_id', $products_id)->update([
                    'products_slug' => $slug,
                ]);
            }
            if ($request->hasFile($products_left_banner) and in_array($request->$products_left_banner->extension(), $extensions)) {
                $image = $request->$products_left_banner;
                $fileName = 'left_' . $languages_data->languages_id . time() . '.' . $image->getClientOriginalName();
                $image->move('resources/assets/images/products_banners/', $fileName);
                $leftBanner = 'resources/assets/images/products_banners/' . $fileName;
            } else {
                $leftBanner = '';
            }

            if ($request->hasFile($products_right_banner) and in_array($request->$products_right_banner->extension(), $extensions)) {
                $image = $request->$products_right_banner;
                $fileName = 'right_' . $languages_data->languages_id . time() . '.' . $image->getClientOriginalName();
                $image->move('resources/assets/images/products_banners/', $fileName);
                $rightBanner = 'resources/assets/images/products_banners/' . $fileName;
            } else {
                $rightBanner = '';
            }

            DB::table('products_description')->insert([
                'products_name' => $request->$products_name,
                'language_id' => $languages_data->languages_id,
                'products_id' => $products_id,
                'products_url' => $request->$products_url,
                'products_left_banner' => $leftBanner,
                'products_left_banner_start_date' => $leftStartDateFormat,
                'products_left_banner_expire_date' => $leftExpireDateFormat,
                'products_right_banner' => $rightBanner,
                'products_right_banner_start_date' => $rightStartDateFormat,
                'products_right_banner_expire_date' => $rightExpireDateFormat,
                'products_description' => addslashes($request->$products_description),
            ]);
        }

        //flash sale product
        if ($request->isFlash == 'yes') {

            $startdate = $request->flash_start_date;
            $starttime = $request->flash_start_time;

            $start_date = str_replace('/', '-', $startdate . ' ' . $starttime);
            $flash_start_date = strtotime($start_date);

            $expiredate = $request->flash_expires_date;
            $expiretime = $request->flash_end_time;

            $expire_date = str_replace('/', '-', $expiredate . ' ' . $expiretime);
            $flash_expires_date = strtotime($expire_date);

            DB::table('flash_sale')->insert([
                'products_id' => $products_id,
                'flash_sale_products_price' => $request->flash_sale_products_price,
                'flash_sale_date_added' => time(),
                'flash_start_date' => $flash_start_date,
                'flash_expires_date' => $flash_expires_date,
                'flash_status' => $request->flash_status,
            ]);
        }

        //special product
        if ($request->isSpecial == 'yes') {

            DB::table('specials')->where('products_id', '=', $products_id)->update([
                'specials_last_modified' => time(),
                'date_status_change' => time(),
                'status' => 0,
            ]);

            DB::table('specials')->insert([
                'products_id' => $products_id,
                'specials_new_products_price' => $request->specials_new_products_price,
                'specials_date_added' => time(),
                'expires_date' => $expiryDateFormate,
                'status' => $request->status,
            ]);
        }

        foreach ($request->categories as $categories) {
            DB::table('products_to_categories')->insert([
                'products_id' => $products_id,
                'categories_id' => $categories,
            ]);
        }

        $options = DB::table('products_options')
            ->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
            ->select('products_options.products_options_id', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id')->where('products_options_descriptions.language_id', $language_id)->get();
        if (!empty($options) and count($options) > 0) {
            $result['options'] = $options;
        } else {
            $result['options'] = '';
        }

        $options_value = DB::table('products_options_values')->join('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')->select('products_options_values.products_options_values_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')->where('products_options_values_descriptions.language_id', '=', $language_id)->get();

        if (!empty($options_value) and count($options_value) > 0) {
            $result['options_value'] = $options_value;
        } else {
            $result['options_value'] = '';
        }

        $result['data'] = array('products_id' => $products_id, 'language_id' => $language_id);


        //notify users
        $myVar = new WarehouseAlertController();
        $alertSetting = $myVar->newProductNotification($products_id);

        if ($request->products_type == 1) {
            return redirect('addproductattribute/' . $products_id);
        } else {
            return redirect('addinventory/' . $products_id);
        }

    }

    public function addinventory(Request $request)
    {
        if (session()->has('warehouse')) {
            $warehouse_id = session('warehouse')->id;
        } else {
            $warehouse_id = 0;
        }
        $title = array('pageTitle' => 'Product Inventory');
        $language_id = '1';
        $products_id = $request->id;

        $result = array();
        $message = array();
        $errorMessage = array();
        $myVar = new WarehouseSiteSettingController();
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
        if ($result['products'][0]->products_type != 0) {

            $addedStock = InventoryModel::where(['products_id'=>$result['products'][0]->products_id, 'stock_type'=>'in'])->sum('stock');

//            $addedStock = DB::table('inventory')
//                ->where('products_id', $result['products'][0]->products_id)
//                ->where('warehouse_id',$warehouse_id)
//                ->where('stock_type', 'in')->sum('stock');

            $purchasedStock = DB::table('inventory')
                ->where('products_id', $result['products'][0]->products_id)
                ->where('stock_type', 'out')
//                ->where('warehouse_id',$warehouse_id)
                ->sum('stock');

            $purchase_price = DB::table('inventory')
                ->where('products_id', $result['products'][0]->products_id)
//                ->where('warehouse_id',$warehouse_id)
                ->sum('purchase_price');

            $stocks = isset($addedStock) - isset($purchasedStock);
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
        return view("warehouse.warehouse_products.addinventory", $title)->with('result', $result);
    }

//currentstock
    public function currentstock(Request $request)
    {
        $inventory_ref_id = '';
        $warehouse_id = session('warehouse')->id;
        $products_id = $request->products_id;
        $attributes = array_filter($request->attributeid);
        $attributeid = implode(',', $attributes);
        $postAttributes = count($attributes);

        $inventories = DB::table('inventory')->where('products_id', $products_id)->where('warehouse_id',$warehouse_id)->get();
        $reference_ids = array();
        $stockIn = 0;
        $stockOut = 0;
        $purchasePrice = 0;
        $inventory_ref_id = array();
        foreach ($inventories as $inventory) {
            $totalAttribute = DB::table('inventory_detail')->where('inventory_detail.inventory_ref_id', '=', $inventory->inventory_ref_id)->get();
            $totalAttributes = count($totalAttribute);

            if ($postAttributes > $totalAttributes) {
                $count = $postAttributes;
            } elseif ($postAttributes < $totalAttributes or $postAttributes == $totalAttributes) {
                $count = $totalAttributes;
            }

            $individualStock = DB::table('inventory')->leftjoin('inventory_detail', 'inventory_detail.inventory_ref_id', '=', 'inventory.inventory_ref_id')
                ->selectRaw('inventory.*')
                ->whereIn('inventory_detail.attribute_id', [$attributeid])
                ->where(DB::raw('(select count(*) from `inventory_detail` where `inventory_detail`.`attribute_id` in (' . $attributeid . ') and `inventory_ref_id`= "' . $inventory->inventory_ref_id . '")'), '=', $count)
                ->where('inventory.inventory_ref_id', '=', $inventory->inventory_ref_id)
                ->groupBy('inventory_detail.inventory_ref_id')
                ->get();

            if (count($individualStock) > 0) {
                $inventory_ref_id[] = $individualStock[0]->inventory_ref_id;

                if ($individualStock[0]->stock_type == 'in') {
                    $stockIn += $individualStock[0]->stock;
                }

                if ($individualStock[0]->stock_type == 'out') {
                    $stockOut += $individualStock[0]->stock;
                }

                $purchasePrice += $individualStock[0]->purchase_price;
            }
        }

        //get option name and value
        $options_names = array();
        $options_values = array();
        foreach ($attributes as $attribute) {
            $productsAttributes = DB::table('products_attributes')
                ->leftJoin('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
                ->leftJoin('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
                ->select('products_attributes.*', 'products_options.products_options_name as options_name', 'products_options_values.products_options_values_name as options_values')
                ->where('products_attributes_id', $attribute)->get();

            $options_names[] = $productsAttributes[0]->options_name;
            $options_values[] = $productsAttributes[0]->options_values;
        }

        $options_names_count = count($options_names);
        $options_names = implode("','", $options_names);
        $options_names = "'" . $options_names . "'";
        $options_values = "'" . implode("','", $options_values) . "'";

        //orders products
        $orders_products = DB::table('orders_products')->where('products_id', $products_id)->get();
        /*$stockOut = 0;
        foreach($orders_products as $orders_product){
        $totalAttribute = DB::table('orders_products_attributes')->where('orders_products_id','=',$orders_product->orders_products_id)->get();
        $totalAttributes = count($totalAttribute);

        if($postAttributes>$totalAttributes){
        $count = $postAttributes;
        }elseif($postAttributes<$totalAttributes or $postAttributes==$totalAttributes){
        $count = $totalAttributes;
        }

        $products = DB::select("select orders_products.* from `orders_products` left join `orders_products_attributes` on `orders_products_attributes`.`orders_products_id` = `orders_products`.`orders_products_id` where `orders_products`.`products_id`='".$products_id."' and `orders_products_attributes`.`products_options` in (".$options_names.") and `orders_products_attributes`.`products_options_values` in (".$options_values.") and (select count(*) from `orders_products_attributes` where `orders_products_attributes`.`products_id` = '".$products_id."' and `orders_products_attributes`.`products_options` in (".$options_names.") and `orders_products_attributes`.`products_options_values` in (".$options_values.") and `orders_products_attributes`.`orders_products_id`= '".$orders_product->orders_products_id."') = ".$count." and `orders_products`.`orders_products_id` = '".$orders_product->orders_products_id."' group by `orders_products_attributes`.`orders_products_id`");
        if(count($products)>0){
        $stockOut += $products[0]->products_quantity;
        }
        }*/

        $result = array();
        $result['purchasePrice'] = $purchasePrice;
        $result['remainingStock'] = $stockIn - $stockOut;

        if (!empty($inventory_ref_id)) {
            $inventory_ref_id = implode(',', $inventory_ref_id);
            $minMax = DB::table('manage_min_max')->where([['inventory_ref_id', $inventory_ref_id], ['products_id', $products_id]])->get();
        } else {
            $minMax = '';
        }

        $result['inventory_ref_id'] = $inventory_ref_id;
        $result['minMax'] = $minMax;

        print_r(json_encode($result));

    }

//addnewstock
    public function addnewstock(Request $request)
    {
        // return $_REQUEST;
        $products_id = $request->products_id;
        $products = $this->getProducts($products_id);

        $inventory_ref_id = DB::table('inventory')->insertGetId([
            'products_id' => $products_id,
            'reference_code' => $request->reference_code,
            'stock' => $request->stockone,
//            'admin_id' => auth()->guard('admin')->user()->myid,
//            'admin_id' => 1,    //To be changed (Ashish)
            'warehouse_id' => session('warehouse')->id,
            'added_date' => time(),
            'purchase_price' => $request->purchase_price,
            'stock_type' => 'in',
        ]);

        $ware_ids = request('w_id');
        $ware_stock = request('w_stock');

        for ($i = 0; $i < count($ware_ids); $i++) {
            $warehouse_inventory = Warehouse_Inventory_Model::where(['pid' => $products_id, 'w_id' => $ware_ids[$i]])->first();

            // $warehouse_inventory->w_id = $ware_ids[$i];
            // $warehouse_inventory->pid = $products_id;
            $warehouse_inventory->stock = (isset($warehouse_inventory->stock) ? $warehouse_inventory->stock : '0') + $ware_stock[$i];
            $warehouse_inventory->save();

            $Warehouse_inventory_history_Model = new Warehouse_inventory_history_Model();
            $Warehouse_inventory_history_Model->w_id = $ware_ids[$i];
            $Warehouse_inventory_history_Model->pid = $products_id;
            $Warehouse_inventory_history_Model->stock = $ware_stock[$i];
            $Warehouse_inventory_history_Model->save();
        }
        if ($products[0]->products_type == 1) {
            foreach ($request->attributeid as $attribute) {
                if (!empty($attribute)) {
                    DB::table('inventory_detail')->insert([
                        'inventory_ref_id' => $inventory_ref_id,
                        'products_id' => $products_id,
                        'attribute_id' => $attribute,
                    ]);
                }
            }
        }
        return redirect()->back()->withErrors('Stock has been added successfully:)');
    }

//addminmax

    public function addminmax(Request $request)
    {
        $products_id = $request->products_id;
        $products = $this->getProducts($products_id);

        if ($products[0]->products_type == 1) {
            $inventory_ref_id = $request->inventory_ref_id;
        } else {
            $inventory_ref_id = 0;
        }

        $checkExist = DB::table('manage_min_max')->where('products_id', $products_id)->where('inventory_ref_id', $inventory_ref_id)->get();
        if (count($checkExist) == 0) {
            DB::table('manage_min_max')->insertGetId([
                'products_id' => $products_id,
                'min_level' => $request->min_level,
                'max_level' => $request->max_level,
                'inventory_ref_id' => $inventory_ref_id,

            ]);

        } else {

            DB::table('manage_min_max')->where('products_id', $products_id)->update([
                'min_level' => $request->min_level,
                'max_level' => $request->max_level,
                'inventory_ref_id' => $inventory_ref_id,
            ]);
        }
        return redirect()->back()->withErrors('Min/Max level has been added successfully:)');
    }

//getOptions

    public function getOptions(Request $request)
    {
        $options = DB::table('products_options')
            ->where('language_id', '=', $request->languages_id)
            ->get();

        if (count($options) > 0) {

            $options_name[] = "<option value=''>" . Lang::get("labels.ChooseValue") . "</option>";

            foreach ($options as $options_data) {

                $options_name[] = "<option value='" . $options_data->products_options_id . "'>" . $options_data->products_options_name . "</option>";
            }

        } else {

            $options_name = "<option value=''>" . Lang::get("labels.ChooseValue") . "</option>";

        }
        print_r($options_name);
    }

//getOptions

    public function getOptionsValue(Request $request)
    {
        $language_id = 1;

        $value = DB::table('products_options_values')
            ->join('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
            ->select('products_options_values_descriptions.*')
            ->where('products_options_values_descriptions.language_id', '=', $language_id)
            ->where('products_options_values.products_options_id', '=', $request->option_id)
            ->get();

        if (count($value) > 0) {

            foreach ($value as $value_data) {

                $value_name[] = "<option value='" . $value_data->products_options_values_id . "'>" . $value_data->options_values_name . "</option>";

            }

        } else {

            $value_name = "<option value=''>Choose Value</option>";

        }

        print_r($value_name);

    }

//addproductattribute

    public function addproductattribute(Request $request)
    {
        $language_id = 1;

        $title = array('pageTitle' => Lang::get("labels.AddAttributes"));

        $products_id = $request->id;

        $subcategory_id = $request->subcategory_id;

        //get function from other controller

        $myVar = new WarehouseSiteSettingController();
        $result['languages'] = $myVar->getLanguages();

        $options = DB::table('products_options')->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')->where('products_options_descriptions.language_id', '=', $language_id)->get();

        $result['options'] = $options;

        $result['subcategory_id'] = $subcategory_id;

        $options_value = DB::table('products_options_values')->get();

        $result['options_value'] = $options_value;

        $result['data'] = array('products_id' => $products_id);

        $products_attributes = DB::table('products_attributes')
            ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
            ->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_attributes.options_id')
            ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
            ->join('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_attributes.options_values_id')
            ->select('products_attributes.*', 'products_options_descriptions.options_name', 'products_options_values_descriptions.options_values_name')
            ->where('products_attributes.products_id', '=', $products_id)
            ->where('products_options_descriptions.language_id', '=', $language_id)
            ->where('products_options_values_descriptions.language_id', '=', $language_id)
            ->orderBy('products_attributes_id', 'DESC')
            ->get();

        $result['products_attributes'] = $products_attributes;
        //dd($result['products_attributes']);

        return view("warehouse.warehouse_products.addproductattribute", $title)->with('result', $result);
    }

//addproductImages

    public function addproductimages(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddImages"));

        $products_id = $request->id;

        $result['data'] = array('products_id' => $products_id);

        $products_images = DB::table('products_images')
            ->where('products_id', '=', $products_id)
            ->orderBy('sort_order', 'ASC')
            ->get();

        $result['products_images'] = $products_images;

        return view("warehouse.warehouse_products.addproductimages", $title)->with('result', $result);
    }

    public function addnewproductattribute(Request $request)
    {

        if (!empty($request->products_options_id) and !empty($request->products_id) and !empty($request->products_options_values_id) and isset($request->options_values_price)) {

            $checkRecord = DB::table('products_attributes')->where([

                'options_id' => $request->products_options_id,

                'options_values_id' => $request->products_options_values_id,

                'products_id' => $request->products_id,

            ])->get();

            if (count($checkRecord) > 0) {

                $products_attributes = 'already';

            } else {

                $language_id = 1;

                $products_attributes_id = DB::table('products_attributes')->insertGetId([

                    'products_id' => $request->products_id,

                    'options_id' => $request->products_options_id,

                    'options_values_id' => $request->products_options_values_id,

                    'options_values_price' => $request->options_values_price,

                    'price_prefix' => $request->price_prefix,

                    'is_default' => $request->is_default,

                ]);

                $products_attributes = DB::table('products_attributes')
                    ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
                    ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
                    ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
                    ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
                    ->select('products_attributes.*', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
                    ->where('products_options_descriptions.language_id', '=', $language_id)
                    ->where('products_options_values_descriptions.language_id', '=', $language_id)
                    ->where('products_attributes.products_id', '=', $request->products_id)
                    ->where('products_attributes.is_default', '=', '0')
                    ->orderBy('products_attributes_id', 'DESC')
                    ->get();
            }

        } else {

            $products_attributes = 'empty';

        }

        return ($products_attributes);

    }

//addNewDefaultAttribute

    public function
    addnewdefaultattribute(Request $request)
    {
//        dd($_REQUEST);
        $language_id = 1;

        $products_attributes = '';


        if (!empty($request->products_options_id) and !empty($request->products_id) and !empty($request->products_options_values_id)) {

            $checkRecord = DB::table('products_attributes')->where([

                'options_id' => $request->products_options_id,

                'products_id' => $request->products_id,

                'options_values_id' => $request->products_options_values_id,

            ])->get();

            if (count($checkRecord) > 0) {

                $products_attributes = 'already';

            } else {

                $products_attributes_id = DB::table('products_attributes')->insertGetId([

                    'products_id' => $request->products_id,

                    'options_id' => $request->products_options_id,

                    'options_values_id' => $request->products_options_values_id,

                    'options_values_price' => '0',

                    'price_prefix' => '+',

                    'is_default' => $request->is_default,

                ]);

                $products_attributes = DB::table('products_attributes')
                    ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
                    ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
                    ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
                    ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
                    ->select('products_attributes.*', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
                    ->where('products_options_descriptions.language_id', '=', $language_id)
                    ->where('products_options_values_descriptions.language_id', '=', $language_id)
                    ->where('products_attributes.products_id', '=', $request->products_id)
                    ->where('products_attributes.is_default', '=', '1')
                    ->orderBy('products_attributes_id', 'DESC')
                    ->get();

            }

        } else {
            $products_attributes = 'empty';
        }
        return $products_attributes;
    }

    public function updateproductattribute(Request $request)
    {
        $language_id = 1;

        $checkRecord = DB::table('products_attributes')->where([

            'options_id' => $request->products_options_id,

            'options_values_id' => $request->products_options_values_id,

            'products_id' => $request->products_id,

        ])->get();

        DB::table('products_attributes')->where('products_attributes_id', '=', $request->products_attributes_id)->update([

            'options_id' => $request->products_options_id,

            'options_values_id' => $request->products_options_values_id,

            'options_values_price' => $request->options_values_price,

            'price_prefix' => $request->price_prefix,

        ]);

        $products_attributes = DB::table('products_attributes')
            ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
            ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
            ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
            ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
            ->select('products_attributes.*', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
            ->where('products_options_descriptions.language_id', '=', $language_id)
            ->where('products_options_values_descriptions.language_id', '=', $language_id)
            ->where('products_attributes.products_id', '=', $request->products_id)
            ->where('products_attributes.is_default', '=', '0')
            ->orderBy('products_attributes_id', 'DESC')
            ->get();

        return ($products_attributes);
    }

    public function updatedefaultattribute(Request $request)
    {
        if (!empty($request->products_options_id) and !empty($request->products_id) and !empty($request->products_options_values_id)) {
            $language_id = 1;
            $checkRecord = DB::table('products_attributes')->where([
                'options_id' => $request->products_options_id,
                'options_values_id' => $request->products_options_values_id,
                'products_id' => $request->products_id,
            ])->get();
            DB::table('products_attributes')->where('products_attributes_id', '=', $request->products_attributes_id)->update([
                'options_id' => $request->products_options_id,
                'options_values_id' => $request->products_options_values_id,
            ]);
            $products_attributes = DB::table('products_attributes')
                ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
                ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
                ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
                ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
                ->select('products_attributes.*', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
                ->where('products_options_descriptions.language_id', '=', $language_id)
                ->where('products_options_values_descriptions.language_id', '=', $language_id)
                ->where('products_attributes.products_id', '=', $request->products_id)
                ->where('products_attributes.is_default', '=', '1')
                ->orderBy('products_attributes_id', 'DESC')
                ->get();
        } else {
            $products_attributes = 'empty';
        }
        return ($products_attributes);
    }


//editProduct

    public function editproduct(Request $request)
    {
        $title = array('pageTitle' => 'Edit Product');

        $language_id = '1';

        $products_id = $request->id;

        $category_id = '0';

        $result = array();

        //get categories from CategoriesController controller

        $myVar = new WarehouseCategoriesController();

        $result['categories'] = $myVar->allCategories($language_id);

        //get function from other controller

        $myVar = new WarehouseSiteSettingController();

        $result['languages'] = $myVar->getLanguages();

        $result['units'] = $myVar->getUnits();

        //tax class

        $taxClass = DB::table('tax_class')->get();

        $result['taxClass'] = $taxClass;

        //get all sub categories

        $subCategories = DB::table('categories')
            ->leftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
            ->select('categories.categories_id as id', 'categories_description.categories_name as name')
            ->where('parent_id', '!=', '0')->where('categories_description.language_id', $language_id)->get();

        $result['subCategories'] = $subCategories;

        //get function from ManufacturerController controller

        $myVar = new WarehouseManufacturerController();

        $result['manufacturer'] = $myVar->getManufacturer($language_id);

        $product = DB::table('products')
            ->where('products.products_id', '=', $products_id)
            ->get();

        $description_data = array();

        foreach ($result['languages'] as $languages_data) {

            $description = DB::table('products_description')->where([

                ['language_id', '=', $languages_data->languages_id],

                ['products_id', '=', $products_id],

            ])->get();

            if (count($description) > 0) {

                $description_data[$languages_data->languages_id]['products_name'] = $description[0]->products_name;

                $description_data[$languages_data->languages_id]['products_url'] = $description[0]->products_url;

                $description_data[$languages_data->languages_id]['products_description'] = $description[0]->products_description;

                $description_data[$languages_data->languages_id]['products_left_banner'] = $description[0]->products_left_banner;

                $description_data[$languages_data->languages_id]['products_left_banner_start_date'] = $description[0]->products_left_banner_start_date;

                $description_data[$languages_data->languages_id]['products_left_banner_expire_date'] = $description[0]->products_left_banner_expire_date;

                $description_data[$languages_data->languages_id]['products_right_banner'] = $description[0]->products_right_banner;

                $description_data[$languages_data->languages_id]['products_right_banner_start_date'] = $description[0]->products_right_banner_start_date;

                $description_data[$languages_data->languages_id]['products_right_banner_expire_date'] = $description[0]->products_right_banner_expire_date;

                $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;

                $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;

            } else {

                $description_data[$languages_data->languages_id]['products_name'] = '';

                $description_data[$languages_data->languages_id]['products_url'] = '';

                $description_data[$languages_data->languages_id]['products_description'] = '';

                $description_data[$languages_data->languages_id]['products_left_banner'] = '';

                $description_data[$languages_data->languages_id]['products_left_banner_start_date'] = '';

                $description_data[$languages_data->languages_id]['products_left_banner_expire_date'] = '';

                $description_data[$languages_data->languages_id]['products_right_banner'] = '';

                $description_data[$languages_data->languages_id]['products_right_banner_start_date'] = '';

                $description_data[$languages_data->languages_id]['products_right_banner_expire_date'] = '';

                $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;

                $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;

            }

        }

        $result['description'] = $description_data;

        $result['product'] = $product;

        //get product category

        $categories = DB::table('products_to_categories')
            ->leftJoin('categories', 'categories.categories_id', '=', 'products_to_categories.categories_id')
            ->leftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
            ->where('products_id', '=', $products_id)->where('categories_description.language_id', '=', $language_id)
            ->get();

        $mainCategories = array();

        $subCategories = array();

        foreach ($categories as $category) {

            if ($category->parent_id == 0) {

                $mainCategories[] = $category->categories_id;

            }

            if ($category->parent_id != 0) {

                $subCategories[] = $category->categories_id;

            }

        }

        $result['subCategories'] = $subCategories;

        $result['mainCategories'] = $mainCategories;

        $getSpecialProduct = DB::table('specials')->where('products_id', $products_id)->orderby('specials_id', 'desc')->limit(1)->get();

        if (count($getSpecialProduct) > 0) {

            $specialProduct = $getSpecialProduct;

        } else {

            $specialProduct[0] = (object)array('specials_id' => '', 'products_id' => '', 'specials_new_products_price' => '', 'status' => '', 'expires_date' => '');

        }

        $result['specialProduct'] = $specialProduct;

        $getflashProduct = DB::table('flash_sale')->where('products_id', $products_id)->orderby('flash_sale_id', 'desc')->limit(1)->get();

        if (count($getflashProduct) > 0) {

            $flashProduct = $getflashProduct;

        } else {

            $flashProduct[0] = (object)array('products_id' => '', 'products_id' => '', 'flash_sale_products_price' => '', 'flash_status' => '', 'flash_start_date' => '', 'flash_expires_date' => '');

        }

        $result['flashProduct'] = $flashProduct;

        return view("warehouse.warehouse_products.editproduct", $title)->with('result', $result);
    }

//updateProduct

    public function updateproduct(Request $request)
    {
        $language_id = '1';

        $products_id = $request->id;

        $products_last_modified = date('Y-m-d h:i:s');

        $expiryDate = str_replace('/', '-', $request->expires_date);

        $expiryDateFormate = strtotime($expiryDate);

        //get function from other controller

        $myVar = new WarehouseSiteSettingController();

        $languages = $myVar->getLanguages();

        $extensions = $myVar->imageType();

        //check slug

        if ($request->old_slug != $request->slug) {

            $slug = $request->slug;

            $slug_count = 0;

            do {

                if ($slug_count == 0) {

                    $currentSlug = $myVar->slugify($request->slug);

                } else {

                    $currentSlug = $myVar->slugify($request->slug . '-' . $slug_count);

                }

                $slug = $currentSlug;

                $checkSlug = DB::table('products')->where('products_slug', $currentSlug)->where('products_id', '!=', $products_id)->get();

                $slug_count++;

            } while (count($checkSlug) > 0);

        } else {

            $slug = $request->slug;

        }

        if ($request->hasFile('products_image') and in_array($request->products_image->extension(), $extensions)) {

            $image = $request->products_image;

            $fileName = time() . '.' . $image->getClientOriginalName();

            $image->move('resources/assets/images/product_images/', $fileName);

            $uploadImage = 'resources/assets/images/product_images/' . $fileName;

        } else {

            $uploadImage = $request->oldImage;

        }

        DB::table('products')->where('products_id', '=', $products_id)->update([

            'products_image' => $uploadImage,

            'manufacturers_id' => $request->manufacturers_id,

            'products_quantity' => 0,

            'products_model' => $request->products_model,

            'products_price' => $request->products_price,

            'products_last_modified' => $products_last_modified,

            'products_weight' => $request->products_weight,

            'products_status' => $request->products_status,

            'products_tax_class_id' => $request->tax_class_id,

            'products_weight_unit' => $request->products_weight_unit,

            'low_limit' => 0,

            'products_slug' => $slug,

            'products_type' => $request->products_type,

            'is_feature' => $request->is_feature,

            'is_prime' => $request->is_prime,
            'prime_percent' => $request->prime_percent,

            'products_min_order' => $request->products_min_order,

            'products_max_stock' => $request->products_max_stock,

        ]);

        foreach ($languages as $languages_data) {

            $products_name = 'products_name_' . $languages_data->languages_id;

            $products_url = 'products_url_' . $languages_data->languages_id;

            $products_description = 'products_description_' . $languages_data->languages_id;

            //left banner

            $products_left_banner = 'products_left_banner_' . $languages_data->languages_id;

            $products_left_banner_start_date = 'products_left_banner_start_date_' . $languages_data->languages_id;

            if (!empty($request->$products_left_banner_start_date)) {

                $leftStartDate = str_replace('/', '-', $request->$products_left_banner_start_date);

                $leftStartDateFormat = strtotime($leftStartDate);

            } else {

                $leftStartDateFormat = '';

            }

            //expire date

            $products_left_banner_expire_date = 'products_left_banner_expire_date_' . $languages_data->languages_id;

            if (!empty($request->$products_left_banner_expire_date)) {

                $leftExpiretDate = str_replace('/', '-', $request->$products_left_banner_expire_date);

                $leftExpireDateFormat = strtotime($leftExpiretDate);

            } else {

                $leftExpireDateFormat = '';

            }

            //right banner

            $products_right_banner = 'products_right_banner_' . $languages_data->languages_id;

            $products_right_banner_start_date = 'products_right_banner_start_date_' . $languages_data->languages_id;

            if (!empty($request->$products_right_banner_start_date)) {

                $rightStartDate = str_replace('/', '-', $request->$products_right_banner_start_date);

                $rightStartDateFormat = strtotime($rightStartDate);

            } else {

                $rightStartDateFormat = '';

            }

            //expire date

            $products_right_banner_expire_date = 'products_right_banner_expire_date_' . $languages_data->languages_id;

            if (!empty($request->$products_right_banner_expire_date)) {

                $rightExpiretDate = str_replace('/', '-', $request->$products_right_banner_expire_date);

                $rightExpireDateFormat = strtotime($rightExpiretDate);

            } else {

                $rightExpireDateFormat = '';

            }

            $old_left_banner = 'old_left_banner_' . $languages_data->languages_id;

            $old_right_banner = 'old_right_banner_' . $languages_data->languages_id;

            if ($request->hasFile($products_left_banner) and in_array($request->$products_left_banner->extension(), $extensions)) {

                $image = $request->$products_left_banner;

                $fileName = $languages_data->languages_id . time() . '.' . $image->getClientOriginalName();

                $image->move('resources/assets/images/products_banners/', $fileName);

                $leftBanner = 'resources/assets/images/products_banners/' . $fileName;

            } else {

                $leftBanner = $request->$old_left_banner;

            }

            if ($request->hasFile($products_right_banner) and in_array($request->$products_right_banner->extension(), $extensions)) {

                $image = $request->$products_right_banner;

                $fileName = $languages_data->languages_id . time() . '.' . $image->getClientOriginalName();

                $image->move('resources/assets/images/products_banners/', $fileName);

                $rightBanner = 'resources/assets/images/products_banners/' . $fileName;

            } else {

                $rightBanner = $request->$old_right_banner;

            }

            $checkExist = DB::table('products_description')->where('products_id', '=', $products_id)->where('language_id', '=', $languages_data->languages_id)->get();

            if (count($checkExist) > 0) {

                DB::table('products_description')->where('products_id', '=', $products_id)->where('language_id', '=', $languages_data->languages_id)->update([

                    'products_name' => $request->$products_name,

                    'products_url' => $request->$products_url,

                    'products_left_banner' => $leftBanner,

                    'products_right_banner' => $rightBanner,

                    'products_left_banner_start_date' => $leftStartDateFormat,

                    'products_left_banner_expire_date' => $leftExpireDateFormat,

                    'products_right_banner_start_date' => $rightStartDateFormat,

                    'products_right_banner_expire_date' => $rightExpireDateFormat,

                    'products_description' => addslashes($request->$products_description),

                ]);

            } else {

                DB::table('products_description')->insert([

                    'products_name' => $request->$products_name,

                    'language_id' => $languages_data->languages_id,

                    'products_id' => $products_id,

                    'products_url' => $request->$products_url,

                    'products_left_banner' => $leftBanner,

                    'products_right_banner' => $rightBanner,

                    'products_left_banner_start_date' => $leftStartDateFormat,

                    'products_left_banner_expire_date' => $leftExpireDateFormat,

                    'products_right_banner_start_date' => $rightStartDateFormat,

                    'products_right_banner_expire_date' => $rightExpireDateFormat,

                    'products_description' => addslashes($request->$products_description),

                ]);

            }

        }

        //delete categories

        DB::table('products_to_categories')->where([

            'products_id' => $products_id,

        ])->delete();

        foreach ($request->categories as $categories) {

            DB::table('products_to_categories')->insert([

                'products_id' => $products_id,

                'categories_id' => $categories,

            ]);

        }

        //special product

        if ($request->isSpecial == 'yes') {

            DB::table('specials')->where('products_id', '=', $products_id)->update([

                'specials_last_modified' => time(),

                'date_status_change' => time(),

                'status' => 0,

            ]);

            DB::table('specials')->insert([

                'products_id' => $products_id,

                'specials_new_products_price' => $request->specials_new_products_price,

                'specials_date_added' => time(),

                'expires_date' => $expiryDateFormate,

                'status' => $request->status,

            ]);

        } else if ($request->isSpecial == 'no') {

            DB::table('specials')->where('products_id', '=', $products_id)->update([

                'status' => 0,

            ]);

        }

        //flash sale product

        if ($request->isFlash == 'yes') {

            DB::table('flash_sale')->where('products_id', '=', $products_id)->update([

                'flash_sale_last_modified' => time(),

                'flash_status' => 0,

            ]);

            $startdate = $request->flash_start_date;

            $starttime = $request->flash_start_time;

            $start_date = str_replace('/', '-', $startdate . ' ' . $starttime);

            $flash_start_date = strtotime($start_date);

            $expiredate = $request->flash_expires_date;

            $expiretime = $request->flash_end_time;

            $expire_date = str_replace('/', '-', $expiredate . ' ' . $expiretime);

            $flash_expires_date = strtotime($expire_date);

            DB::table('flash_sale')->insert([

                'products_id' => $products_id,

                'flash_sale_products_price' => $request->flash_sale_products_price,

                'flash_sale_date_added' => time(),

                'flash_start_date' => $flash_start_date,

                'flash_expires_date' => $flash_expires_date,

                'flash_status' => $request->flash_status,

            ]);

        } else if ($request->isSpecial == 'no') {

            DB::table('flash_sale')->where('products_id', '=', $products_id)->update([

                'flash_status' => 0,

            ]);

        }

        $options = DB::table('products_options')
            ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
            ->select('products_options.products_options_id', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id')->where('products_options_descriptions.language_id', '1')->get();

        $result['options'] = $options;

        $options_value = DB::table('products_options_values')
            ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
            ->select('products_options_values.products_options_values_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
            ->where('products_options_values_descriptions.language_id', '=', $language_id)
            ->get();

        $result['options_value'] = $options_value;

        $result['data'] = array('products_id' => $products_id, 'language_id' => $language_id);

        if ($request->products_type == 1) {

            return redirect('addproductattribute/' . $products_id);

        } else {

            return redirect('addinventory/' . $products_id);
        }
    }

//deleteproductattributemodal

    public
    function deleteproductmodal(Request $request)
    {

        $products_id = $request->products_id;

        return view("deleteproductattributemodal")->with('result', $result);

    }

//editProductAttribute

    public function editproductattribute(Request $request)
    {
        $myVar = new WarehouseSiteSettingController();

        $languages = $myVar->getLanguages();

        $products_id = $request->products_id;

        $products_attributes_id = $request->products_attributes_id;

        $language_id = $request->language_id;

        $options_id = $request->options_id;

        $myVar = new WarehouseSiteSettingController();

        $languages = $myVar->getLanguages();

        $extensions = $myVar->imageType();

        $products_id = $request->products_id;

        $products_attributes_id = $request->products_attributes_id;

        $language_id = 1;

        $options_id = $request->options_id;

        $options = DB::table('products_options')
            ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
            ->select('products_options.products_options_id', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id')
            ->where('products_options_descriptions.language_id', '=', $language_id)
            ->get();

        $result['options'] = $options;

        $options_value = DB::table('products_options_values')
            ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
            ->select('products_options_values.products_options_values_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
            ->where('products_options_values_descriptions.language_id', '=', $language_id)
            ->where('products_options_values.products_options_id', '=', $options_id)
            ->get();

        $result['options_value'] = $options_value;

        $result['data'] = array('products_id' => $request->products_id, 'products_attributes_id' => $products_attributes_id, 'language_id' => $language_id);

        $products_attributes = DB::table('products_attributes')
            ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
            ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
            ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
            ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
            ->select('products_attributes.*', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
            ->where('products_options_descriptions.language_id', '=', $language_id)
            ->where('products_options_values_descriptions.language_id', '=', $language_id)
            ->where('products_attributes.products_attributes_id', '=', $products_attributes_id)
            ->get();

        $result['products_attributes'] = $products_attributes;

        $result['languages'] = $languages;

        return view("warehouse.warehouse_products.editproductattributeform")->with('result', $result);

    }

//editdefaultattributemodal

    public function editdefaultattribute(Request $request)
    {

        //get function from other controller

        $myVar = new WarehouseSiteSettingController();

        $languages = $myVar->getLanguages();

        $extensions = $myVar->imageType();

        $products_id = $request->products_id;

        $products_attributes_id = $request->products_attributes_id;

        $language_id = 1;

        $options_id = $request->options_id;

        $options = DB::table('products_options')
            ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
            ->select('products_options.products_options_id', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id')
            ->where('products_options_descriptions.language_id', '=', $language_id)
            ->get();

        $result['options'] = $options;

        $options_value = DB::table('products_options_values')
            ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
            ->select('products_options_values.products_options_values_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
            ->where('products_options_values_descriptions.language_id', '=', $language_id)
            ->where('products_options_values.products_options_id', '=', $options_id)
            ->get();

        $result['options_value'] = $options_value;

        $result['data'] = array('products_id' => $request->products_id, 'products_attributes_id' => $products_attributes_id, 'language_id' => $language_id);

        $products_attributes = DB::table('products_attributes')
            ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
            ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
            ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
            ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
            ->select('products_attributes.*', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
            ->where('products_options_descriptions.language_id', '=', $language_id)
            ->where('products_options_values_descriptions.language_id', '=', $language_id)
            ->where('products_attributes.products_attributes_id', '=', $products_attributes_id)
            ->get();

        $result['products_attributes'] = $products_attributes;

        $result['languages'] = $languages;

        return view("warehouse.warehouse_products.editdefaultattributeform")->with('result', $result);

    }

//deleteproductattributemodal

    public function deleteproductattributemodal(Request $request)
    {
        $products_id = $request->products_id;

        $products_attributes_id = $request->products_attributes_id;

        $result['data'] = array('products_id' => $products_id, 'products_attributes_id' => $products_attributes_id);

        return view("warehouse.warehouse_products.deleteproductattributemodal")->with('result', $result);
    }

//deletedefaultattributemodal

    public function deletedefaultattributemodal(Request $request)
    {
        $products_id = $request->products_id;

        $products_attributes_id = $request->products_attributes_id;

        $result['data'] = array('products_id' => $products_id, 'products_attributes_id' => $products_attributes_id);

        return view("warehouse.warehouse_products.deletedefaultattributemodal")->with('result', $result);
    }

//deleteproductattribute

    public function deleteproductattribute(Request $request)
    {
        $language_id = '1';
        $checkRecord = DB::table('products_attributes')->where([
            'products_attributes_id' => $request->products_attributes_id,
            'products_id' => $request->products_id,
        ])->delete();
        $products_attributes = DB::table('products_attributes')
            ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
            ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
            ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
            ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
            ->select('products_attributes.*', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
            ->where('products_options_descriptions.language_id', '=', $language_id)
            ->where('products_options_values_descriptions.language_id', '=', $language_id)
            ->where('products_attributes.products_id', '=', $request->products_id)
            ->where('products_attributes.is_default', '=', '0')
            ->orderBy('products_attributes_id', 'DESC')
            ->get();
        return ($products_attributes);
    }


//deletedefaultattribute

    public function deletedefaultattribute(Request $request)
    {
        $language_id = '1';

        $checkRecord = DB::table('products_attributes')->where([

            'products_attributes_id' => $request->products_attributes_id,

            'products_id' => $request->products_id,

        ])->delete();

        $products_attributes = DB::table('products_attributes')
            ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
            ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
            ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
            ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
            ->select('products_attributes.*', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
            ->where('products_options_descriptions.language_id', '=', $language_id)
            ->where('products_options_values_descriptions.language_id', '=', $language_id)
            ->where('products_attributes.products_id', '=', $request->products_id)
            ->where('products_attributes.is_default', '=', '1')
            ->orderBy('products_attributes_id', 'DESC')
            ->get();

        return ($products_attributes);
    }

//addnewproductimage

    public function addnewproductimage(Request $request)
    {
        $myVar = new WarehouseSiteSettingController();

        $extensions = $myVar->imageType();

        if ($request->hasFile('newImage') and in_array($request->newImage->extension(), $extensions)) {

            $image = $request->newImage;

            $fileName = time() . '.' . $image->getClientOriginalName();

            $image->move('resources/assets/images/product_images/', $fileName);

            $uploadImage = 'resources/assets/images/product_images/' . $fileName;

            DB::table('products_images')->insert([

                'products_id' => $request->products_id,

                'image' => $uploadImage,

                'htmlcontent' => $request->htmlcontent,

                'sort_order' => $request->sort_order,

            ]);

            $products_images = DB::table('products_images')
                ->where('products_id', '=', $request->products_id)
                ->orderBy('sort_order', 'ASC')
                ->get();

        } else {

            $products_images = '';

        }

        return ($products_images);
    }

    public
    function editproductimage(Request $request)
    {
        $products_images = DB::table('products_images')
            ->where('id', '=', $request->id)
            ->get();
        return view("warehouse.warehouse_products.editproductimageform")->with('result', $products_images);
    }

//updateproductimage

    public function updateproductimage(Request $request)
    {
        $myVar = new WarehouseSiteSettingController();

        $extensions = $myVar->imageType();

        if ($request->hasFile('newImage') and in_array($request->newImage->extension(), $extensions)) {

            $image = $request->newImage;

            $fileName = time() . '.' . $image->getClientOriginalName();

            $image->move('resources/assets/images/product_images/', $fileName);

            $uploadImage = 'resources/assets/images/product_images/' . $fileName;

        } else {

            $uploadImage = $request->oldImage;

        }

        DB::table('products_images')->where('products_id', '=', $request->products_id)->where('id', '=', $request->id)
            ->update([

                'image' => $uploadImage,

                'htmlcontent' => $request->htmlcontent,

                'sort_order' => $request->sort_order,

            ]);

        $products_images = DB::table('products_images')
            ->where('products_id', '=', $request->products_id)
            ->orderBy('sort_order', 'ASC')
            ->get();

        return ($products_images);
    }

//deleteproductimagemodal

    public function deleteproductimagemodal(Request $request)
    {
        $products_id = $request->products_id;

        $id = $request->id;

        $result['data'] = array('products_id' => $products_id, 'id' => $id);

        return view("warehouse.warehouse_products.deleteproductimagemodal")->with('result', $result);
    }

//deleteproductimage

    public function deleteproductimage(Request $request)
    {
        DB::table('products_images')->where([

            'products_id' => $request->products_id,

            'id' => $request->id,

        ])->delete();

        $products_images = DB::table('products_images')
            ->where('products_id', '=', $request->products_id)
            ->orderBy('sort_order', 'ASC')
            ->get();

        return ($products_images);
    }

//manageoptionsvalues

    public function manageoptionsvalues(Request $request)
    {
        $title = array('pageTitle' => 'Manage Values');

        $data = array();

        $myVar = new WarehouseSiteSettingController();

        $extensions = $myVar->imageType();

        $products_options_id = $request->id;

        $value = DB::table('products_options_values')->where('products_options_id', $products_options_id)->get();

        $result = array();

        $index = 0;

        foreach ($value as $values_data) {

            array_push($result, $values_data);

            $languages = $myVar->getLanguages();

            $result2 = array();

            $index2 = 0;

            foreach ($languages as $language) {

                array_push($result2, $language);

                $values = DB::table('products_options_values_descriptions')
                    ->where('products_options_values_id', '=', $values_data->products_options_values_id)
                    ->where('language_id', '=', $language->languages_id)
                    ->get();

                $result2[$index2]->values = $values;

                $index2++;

            }

            $result[$index]->data = $result2;

            $index++;

        }

        $data['languages'] = $myVar->getLanguages();

        $data['content'] = $result;

        $data['options'] = DB::table('products_options')
            ->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
            ->where('products_options.products_options_id', $products_options_id)->get();

        return view("warehouse.warehouse_products.manageoptionsvalues", $title)->with('result', $data);
    }

//addnewoptions

    public function addnewvalues(Request $request)
    {
        $result = array();

        //get function from other controller

        $myVar = new WarehouseSiteSettingController();

        $languages = $myVar->getLanguages();

        $i = 0;

        //multiple lanugauge with record

        foreach ($languages as $languages_data) {

            $products_options_values_name = 'ValuesName_' . $languages_data->languages_id;

            if ($i == 0) {

                $products_options_values_id = DB::table('products_options_values')->insertGetId([

                    'products_options_values_name' => $request->$products_options_values_name,

                    'products_options_id' => $request->products_options_id,

                ]);

                $i++;

            }

            DB::table('products_options_values_descriptions')->insert([

                'options_values_name' => $request->$products_options_values_name,

                'products_options_values_id' => $products_options_values_id,

                'language_id' => $languages_data->languages_id,

            ]);

        }
        return redirect()->back()->withErrors('Option values has been added successfully!');
    }

//editvalues

    public function editvalues(Request $request)
    {
        $title = array('pageTitle' => 'Manage Options');

        $myVar = new WarehouseSiteSettingController();

        $result['languages'] = $myVar->getLanguages();

        $edit = DB::table('products_options_values')->where('products_options_values_id', $request->id)->get();

        $description_data = array();

        foreach ($result['languages'] as $languages_data) {

            $description = DB::table('products_options_values_descriptions')->where([

                ['language_id', '=', $languages_data->languages_id],

                ['products_options_values_id', '=', $request->id],

            ])->get();

            if (count($description) > 0) {

                $description_data[$languages_data->languages_id]['name'] = $description[0]->options_values_name;

                $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;

                $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;

            } else {

                $description_data[$languages_data->languages_id]['name'] = '';

                $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;

                $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;

            }

        }

        $result['description'] = $description_data;

        $result['editoptions'] = $edit;

        return view("warehouse.warehouse_products.editvalues", $title)->with('result', $result);
    }

//updateoptions

    public function updatevalue(Request $request)
    {
        $products_options_values_id = $request->products_options_values_id;

        $myVar = new WarehouseSiteSettingController();

        $languages = $myVar->getLanguages();

        foreach ($languages as $languages_data) {

            $options_values_name = 'options_values_name_' . $languages_data->languages_id;

            $checkExist = DB::table('products_options_values_descriptions')->where('products_options_values_id', '=', $products_options_values_id)->where('language_id', '=', $languages_data->languages_id)->get();

            if (count($checkExist) > 0) {

                DB::table('products_options_values_descriptions')->where('products_options_values_id', '=', $products_options_values_id)->where('language_id', '=', $languages_data->languages_id)->update([

                    'options_values_name' => $request->$options_values_name,

                ]);

            } else {

                DB::table('products_options_values_descriptions')->insert([

                    'options_values_name' => $request->$options_values_name,

                    'language_id' => $languages_data->languages_id,

                    'products_options_values_id' => $products_options_values_id,

                ]);

            }

        }

        return redirect()->back()->withErrors('Option values has been updated successfully!');
    }

//productsAttributes

    public function attributes(Request $request)
    {
        $title = array('pageTitle' => 'Attributes');

        //get function from other controller

        $myVar = new WarehouseSiteSettingController();

        $extensions = $myVar->imageType();

        $attributes = DB::table('products_options')->get();

        $result = array();

        $index = 0;

        foreach ($attributes as $attributes_data) {

            array_push($result, $attributes_data);

            $languages = $myVar->getLanguages();

            $result2 = array();

            $index2 = 0;

            foreach ($languages as $language) {

                array_push($result2, $language);

                $attributes = DB::table('products_options_descriptions')
                    ->where('products_options_id', '=', $attributes_data->products_options_id)
                    ->where('language_id', '=', $language->languages_id)
                    ->get();

                $result2[$index2]->attributes = $attributes;
                $values = DB::table('products_options_values')
                    ->join('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
                    ->select('products_options_values_descriptions.*')
                    ->where('language_id', '=', $language->languages_id)
                    ->where('products_options_values.products_options_id', '=', $attributes_data->products_options_id)->get();
                $result2[$index2]->values = $values;
                $index2++;
            }
            $result[$index]->data = $result2;
            $index++;
        }
        return view("warehouse.warehouse_products.attributes", $title)->with('result', $result);
    }

//common controller to show attributes

    public
    function displayattributes()
    {

        //get function from other controller

        $myVar = new WarehouseSiteSettingController();

        $resutls['languages'] = $myVar->getLanguages();

        $defaultLanguage_id = $resutls['languages'][0]->languages_id;

        foreach ($resutls['languages'] as $languages) {

            if (!empty($languages->languages_id)) {

                $language_id = $languages->languages_id;

            } else {

                $language_id = $defaultLanguage_id;

            }

            $attributeOptions = DB::table('products_options')->where('products_options.language_id', '=', $language_id)->get();

            $resutls['attributeOptions_' . $languages->languages_id] = $attributeOptions;

        }

        return $resutls;

    }

//addoptions

    public function addoptions(Request $request)
    {
        $title = array('pageTitle' => 'Add Options');

        $result = array();

        //get function from other controller

        $myVar = new WarehouseSiteSettingController();

        $result['languages'] = $myVar->getLanguages();

        return view("warehouse.warehouse_products.addoptions", $title)->with('result', $result);
    }

//addnewoptions

    public function addnewoptions(Request $request)
    {
        $result = array();

        //get function from other controller

        $myVar = new WarehouseSiteSettingController();

        $languages = $myVar->getLanguages();

        $i = 0;

        //multiple lanugauge with record

        foreach ($languages as $languages_data) {

            $OptionsName = 'OptionsName_' . $languages_data->languages_id;

            if ($i == 0) {

                $products_options_id = DB::table('products_options')->insertGetId([

                    'products_options_name' => $request->$OptionsName,

                ]);

                $i++;

            }

            DB::table('products_options_descriptions')->insert([

                'options_name' => $request->$OptionsName,

                'products_options_id' => $products_options_id,

                'language_id' => $languages_data->languages_id,

            ]);

        }

        return redirect()->back()->withErrors('Option has been successfully added');
    }

//manageoptions

    public function manageoptions(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.Manage Options"));

        $myVar = new WarehouseSiteSettingController();

        $result['languages'] = $myVar->getLanguages();

        $editoptions = DB::table('products_options')->where('products_options_id', $request->id)->get();

        $description_data = array();

        foreach ($result['languages'] as $languages_data) {

            $description = DB::table('products_options_descriptions')->where([

                ['language_id', '=', $languages_data->languages_id],

                ['products_options_id', '=', $request->id],

            ])->get();

            if (count($description) > 0) {

                $description_data[$languages_data->languages_id]['name'] = $description[0]->options_name;

                $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;

                $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;

            } else {

                $description_data[$languages_data->languages_id]['name'] = '';

                $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;

                $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;

            }

        }

        $result['description'] = $description_data;

        $result['editoptions'] = $editoptions;

        return view("warehouse.warehouse_products.manageoptions", $title)->with('result', $result);
    }

//updateoptions

    public function updateoptions(Request $request)
    {
        $products_options_id = $request->products_options_id;

        $myVar = new WarehouseSiteSettingController();

        $languages = $myVar->getLanguages();

        foreach ($languages as $languages_data) {

            $options_name = 'options_name_' . $languages_data->languages_id;

            $checkExist = DB::table('products_options_descriptions')->where('products_options_id', '=', $products_options_id)->where('language_id', '=', $languages_data->languages_id)->get();

            if (count($checkExist) > 0) {

                DB::table('products_options_descriptions')->where('products_options_id', '=', $products_options_id)->where('language_id', '=', $languages_data->languages_id)->update([

                    'options_name' => $request->$options_name,
                ]);

            } else {

                DB::table('products_options_descriptions')->insert([

                    'options_name' => $request->$options_name,

                    'language_id' => $languages_data->languages_id,

                    'products_options_id' => $products_options_id,

                ]);

            }

        }
        return redirect()->back()->withErrors('Option has been updated successfully!');
    }

//addattributevalue
    public function addattributevalue(Request $request)
    {
        $attributes = array();
        $message = array();
        $errorMessage = array();

        //add value
        $products_options_values_id = DB::table('products_options_values')->insertGetId([
            'products_options_values_name' => $request->products_options_values_name,
            'language_id' => $request->language_id,
        ]);

        /*DB::table('products_options_values_to_products_options')->insertGetId([
        'products_options_id'                  =>   $request->products_options_id,
        'products_options_values_id'        =>   $products_options_values_id,
        ]);*/

        /*$attributes = DB::table('products_options_values_to_products_options')
        ->leftJoin('products_options_values', 'products_options_values.products_options_values_id','=', 'products_options_values_to_products_options.products_options_values_id')
        ->where('products_options_values_to_products_options.products_options_id','=',$request->products_options_id)->where('products_options_values.language_id','=',$request->language_id)->get();*/

        return view("warehouse.warehouse_products.attributesTable")->with('attributes', $attributes);
    }

//updateattributevalue

    public function updateattributevalue(Request $request)
    {
        $attributes = array();
        $message = array();
        $errorMessage = array();

        DB::table('products_options_values')
            ->where('products_options_values_id', '=', $request->products_options_values_id)
            ->update(['products_options_values_name' => $request->products_options_values_name]);

        /*$attributes = DB::table('products_options_values_to_products_options')
        ->leftJoin('products_options_values', 'products_options_values.products_options_values_id','=', 'products_options_values_to_products_options.products_options_values_id')
        ->where('products_options_values_to_products_options.products_options_id','=',$request->products_options_id)->where('products_options_values.language_id','=',$request->language_id)->get();*/

        //attributesTable
        return view("warehouse.warehouse_products.attributesTable")->with('attributes', $attributes);
    }

//check association of attribute with products

    public function checkattributeassociate(Request $request)
    {
        $option_id = $request->option_id;

        $products = DB::table('products_attributes')
            ->join('products', 'products.products_id', '=', 'products_attributes.products_id')
            ->join('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->where('options_id', '=', $option_id)
            ->groupBy('products_attributes.products_id')
            ->get();

        if (count($products) > 0) {

            foreach ($products as $products_data) {

                print("<li style='display:inline-block; width: 30%'>" . $products_data->products_name . "</li>");
            }
        } else {
//            to be started from here
        }
    }

//deleteattribute

    public function deleteattribute(Request $request)
    {
        $option_id = $request->option_id;
        DB::table('products_options')->where('products_options_id', '=', $option_id)->delete();
        DB::table('products_options_descriptions')->where('products_options_id', '=', $option_id)->delete();

        $values = DB::table('products_options_values')->where('products_options_id', '=', $option_id)->get();
        foreach ($values as $value) {
            DB::table('products_options_values_descriptions')->where('products_options_values_id', '=', $value->products_options_values_id)->delete();
        }
        DB::table('products_options_values')->where('products_options_id', '=', $option_id)->delete();

        return redirect()->back()->withErrors('Option has been deleted successfully!');
    }

//check association of attribute/option value with products
    public function checkvalueassociate(Request $request)
    {
        $value_id = $request->value_id;
        $products = DB::table('products_attributes')
            ->join('products', 'products.products_id', '=', 'products_attributes.products_id')
            ->join('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->where('options_values_id', '=', $value_id)
            ->get();

        if (count($products) > 0) {
            foreach ($products as $products_data) {
                print("<li style='display:inline-block; width: 30%'>" . $products_data->products_name . "</li>");
            }
        }
    }

//deleteattributeValue

    public function deletevalue(Request $request)
    {
        $value_id = $request->value_id;
        DB::table('products_options_values')->where('products_options_values_id', '=', $value_id)->delete();
        DB::table('products_options_values_descriptions')->where('products_options_values_id', '=', $value_id)->delete();

        return redirect()->back()->withErrors('Option values has been deleted successfully!');
    }

//---------------------------------------- Purchaser Start ----------------------------------------
    public function purchase()
    {
        $productDesc = Products_Description::distinct()->get();
        $collection = collect($productDesc);
        $product_name = $collection->unique('products_name');
        $product = $product_name->values()->all();

//        $brand = ManufacturerModel::where(['is_del'=>0])->get();
//        $unit = UnitsModel::where(['is_active'=>1])->get();
//        $catlist = CategoryDescriptionModel::where(['is_active'=>1])->orderBy('categories_id', 'desc')->get();
//        $vendor = Vendor::whereis_del(0)->get();
//        $catlist = Category::whereis_del(0)->whereparent_id(0)->orderBy('id', 'desc')->get();
//        return view('purchase.purchase')->with(['brand' => $brand, 'unit' => $unit, 'catlist' => $catlist, 'vendor' => $vendor]);
//        return view('warehouse.purchase.purchase')->with(['brand' => $brand, 'unit' => $unit, 'catlist' => $catlist]);
        return view('warehouse.purchase.purchase')->with(['product'=>$product]);
    }

    public function addProduct_modal()
    {
//        $brand = ManufacturerModel::orderBy('manufacturers_name', 'desc');
        $brand = DB::table('manufacturers')
            ->leftJoin('manufacturers_info', 'manufacturers_info.manufacturers_id', '=', 'manufacturers.manufacturers_id')
            ->select('manufacturers.manufacturers_id as id', 'manufacturers.manufacturers_image as image', 'manufacturers.manufacturers_name as name', 'manufacturers_info.manufacturers_url as url', 'manufacturers_info.url_clicked', 'manufacturers_info.date_last_click as clik_date')
            ->orderBy('manufacturers_name', 'ASC')
            ->get();
//        return $brand;
        $category = CategoryModel::where(['parent_id'=>0])->get();
        $tax_class = TaxClassModel::get();
//        $subcategory = CategoryModel::where(['sabcategory_id'=>0])->get();
        return view('warehouse.purchase.purchase_modal')->with(['brand'=>$brand,'category'=>$category, 'tax_class'=>$tax_class]);
    }

    public function product_upload(Request $request)
    {
        if ($request->hasFile('products_image') and in_array($request->products_image->extension(), $extensions)) {
            $image = $request->products_image;
            $fileName = time() . '.' . $image->getClientOriginalName();
            $image->move('resources/assets/images/product_images/', $fileName);
            $uploadImage = 'resources/assets/images/product_images/' . $fileName;
        } else {
            $uploadImage = '';
        }

        $products_id = DB::table('products')->insertGetId([
            'products_image' => $uploadImage,
            'manufacturers_id' => $request->manufacturers_id,
            'products_quantity' => 0,
            'products_model' => $request->products_model,
            'products_price' => $request->selling_price,
            // 'products_purchase_price' => $request->products_purchase_price,
            'products_date_added' => Carbon::now(),
            'products_weight' => $request->products_weight,
            'products_status' => $request->products_status,
            'products_tax_class_id' => $request->tax_class_id,
            'products_weight_unit' => $request->products_weight_unit,
            'low_limit' => 0,
            'products_type' => $request->products_type
        ]);

        $barcode = new BarcodeModel();
        $barcode->product_id = $products_id;
        $barcode->cost_price = $request->products_purchase_price;
        $barcode->selling_price = $request->selling_price;
        $barcode->barcode = request('barcode');
        $barcode->save();

        $data = WarehouseModel::whereis_del(0)->get();
        foreach ($data as $obj) {
            $warehouse_inventory = new Warehouse_Inventory_Model();
            $warehouse_inventory->w_id = $obj->id;
            $warehouse_inventory->pid = $products_id;
            $warehouse_inventory->stock = 0;
            $warehouse_inventory->save();
        }

        $slug_flag = false;

        if ($slug_flag == false) {
            $slug_flag = true;

            $slug = $request->products_name;
            $old_slug = $request->products_name;

            $slug_count = 0;
            do {
                if ($slug_count == 0) {
                    $currentSlug = slugify($slug);
                } else {
                    $currentSlug = slugify($old_slug . '-' . $slug_count);
                }
                $slug = $currentSlug;
                $checkSlug = DB::table('products')->where('products_slug', $currentSlug)->get();
                $slug_count++;
            } while (count($checkSlug) > 0);
            DB::table('products')->where('products_id', $products_id)->update([
                'products_slug' => $slug,
            ]);
        }

        DB::table('products_description')->insert([
            'products_name' => $request->products_name,
            'language_id' => 1,
            'products_id' => $products_id,
            'products_url' => $request->products_url_,
            'products_left_banner' => '',
            'products_left_banner_start_date' => '',
            'products_left_banner_expire_date' => '',
            'products_right_banner' => '',
            'products_right_banner_start_date' => '',
            'products_right_banner_expire_date' => '',
            'products_description' => addslashes($request->products_description),
        ]);
    }
    public function slugify($slug){

        // replace non letter or digits by -
        $slug = preg_replace('~[^\pL\d]+~u', '-', $slug);

        // transliterate
        if (function_exists('iconv')){
            $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
        }

        // remove unwanted characters
        $slug = preg_replace('~[^-\w]+~', '', $slug);

        // trim
        $slug = trim($slug, '-');

        // remove duplicate -
        $slug = preg_replace('~-+~', '-', $slug);

        // lowercase
        $slug = strtolower($slug);

        if (empty($slug)) {
            return 'n-a';
        }

        return $slug;
    }
    public function addnewrow()
    {
        $uid = request('uid');
        $brand = ManufacturerModel::where(['is_del'=>0])->get();
        $unit = UnitsModel::where(['is_active'=>1])->get();
        $catlist = CategoryDescriptionModel::where(['is_active'=>1])->orderBy('categories_id', 'desc')->get();
//        $brand = Brand::whereis_del(0)->get();
//        $unit = Unit::whereis_del(0)->get();
//        $vendor = Vendor::whereis_del(0)->get();
//        $catlist = Category::whereis_del(0)->whereparent_id(0)->orderBy('id', 'desc')->get();
        return view('warehouse.purchase.addrow')->with(['brand' => $brand, 'unit' => $unit, 'catlist' => $catlist,'uid' => $uid]);
//        return view('warehouse.purchase.addrow')->with(['uid'=>$uid]);
    }
    public function addpurchase()
    {
        return $_REQUEST;

        $subcatlist = CategoryModel::where(['is_active'=>1])->orderBy('categories_id', 'desc')->get();
    }
    public function subCategorylist()
    {
        $categoryid = request('categoryid');
        $subcatlist = CategoryModel::where(['is_active'=>1,'categoryid'=>$categoryid])->orderBy('categories_id', 'desc')->get();
    }
    public function productChange()
    {
        $productid = request('productid');
        $productData = ProductsModel::where(['products_id'=>$productid])->first();
        $productDescData = Products_Description::where(['products_id'=>$productid])->first();
        return ['productData'=>$productData, 'productDescData'=>$productDescData];
    }
//---------------------------------------- Purchaser End ----------------------------------------
}
