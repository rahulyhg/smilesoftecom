<?php

namespace App\Http\Controllers;

use App\WarehouseModel;
use App\WarehouseStaffModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Http\Request;

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
                'password' => $request->password
            ),
            array
            (
                'username' => 'required | email',
                'password' => 'required'
            )
        );
        if ($validator->fails()) {
            return redirect('warehouse_login')->withErrors($validator)->withInput();
        } else {
            //check authentication of email and password
//            $credentials = ['email' => request('username'), 'psasword' => request('password')];
////            Hash::check($credentials['password'], $user->password;
//            $user = WarehouseModel::whereRaw('lower(username) = ? ', [$credentials['email']])->firstorFail();
//
//            $validPassword = Hash::check($credentials['password'], $request->password);
//
//            if ($user  && $validPassword)
//            {
//                return $user.$validPassword;
//            }

            $username = request('username');
            $password = request('password');
            $warehouse = WarehouseModel::where(['username' => $username, 'password' => $password, 'is_del' => 0])->first();
            {
                if (isset($warehouse)) {
                    $request->session()->put('warehouse', $warehouse);
                    return redirect('warehouse_dashboard');
                } else {
                    return redirect()->back()->withErrors(['Username / Password Invalid']);
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
        $warehouse_id = session('warehouse')->id;
        $staff = WarehouseStaffModel::where(['is_del'=>0,'warehouse_id'=>$warehouse_id])->paginate(10);
        return view('warehouse.staff_warehouse')->with(['staff'=>$staff]);
    }
    function add_staff()
    {
        return view('warehouse.add_staff');
    }

    function insert_staff()
    {
        $staff = new WarehouseStaffModel();
        $staff->warehouse_id = request('warehouse_id');
        $staff->name = request('name');
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
}
