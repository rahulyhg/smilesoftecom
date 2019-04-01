<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use App;
use Lang;
use DB;
//for password encryption or hash protected
use Hash;
use App\Administrator;

//for authenitcate login data
use Auth;

class AdminPickupController extends Controller
{

    //listingzONES
    public function listingPickups(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ListingPickup"));

        $result = array();
        $message = array();
        $errorMessage = array();

        $zones = DB::table('pickup_points')
            ->LeftJoin('countries', 'pickup_points.city_id', '=', 'countries.countries_id')
            ->paginate(60);


        $result['message'] = $message;
        $result['pickup_points'] = $zones;

        return view("admin.pickup.listingPickups", $title)->with('result', $result);
    }

    //addcountry
    public function addPickup(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddPickup"));

        $result = array();
        $message = array();

        $countries = DB::table('countries')->get();
        $result['countries'] = $countries;
        $result['message'] = $message;

        return view("admin.pickup.addPickup", $title)->with('result', $result);
    }

    //addNewZone	
    public function addNewPickup(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.AddCountry"));
        $result = array();

        $zone_id = DB::table('pickup_points')->insertGetId([
            'city_id' => $request->city_id,
//            'zone_code' => $request->zone_code,
            'shop_address' => $request->shop_address
        ]);

        $countries = DB::table('countries')->get();
        $result['countries'] = $countries;

        $result['message'] = "Pickup Points has been added successfully!"; //Lang::get("labels.PickupAddedMessage");
        return view('admin.pickup.addPickup', $title)->with('result', $result);
    }

    //editZone
    public function editPickup(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.EditPickup"));
        $result = array();
        $result['message'] = array();

        $zones = DB::table('pickup_points')->where('id', $request->id)->get();
        $countries = DB::table('countries')->get();
        $result['countries'] = $countries;
        $result['zones'] = $zones;

        return view("admin.pickup.editPickup", $title)->with('result', $result);
    }

    //updateZone
    public function updatePickup(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.EditCountry"));

        $countryData = array();
        $countryData['message'] = 'Pickup Points has been updated successfully!';

        $countryUpdate = DB::table('pickup_points')->where('id', $request->id)->update([
            'city_id' => $request->city_id,
//            'zone_code' => $request->zone_code,
            'shop_address' => $request->shop_address

        ]);

        $country = DB::table('countries')->where('countries_id', $request->id)->get();
        $countryData['country'] = $country;

        return redirect()->back()->withErrors([Lang::get("labels.PickupUpdatedTax")]);
    }

    //deleteZone
    public function deletePickup(Request $request)
    {
        DB::table('pickup_points')->where('id', $request->id)->delete();
        return redirect()->back()->withErrors([Lang::get("labels.PickupDeletedTax")]);
    }
}
