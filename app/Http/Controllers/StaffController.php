<?php

namespace App\Http\Controllers;

use App\WarehouseStaffModel;
use Illuminate\Http\Request;
use Validator;

class StaffController extends Controller
{
    function login()
    {
        return view('staff.staff_login');
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
            return redirect('staff_login')->withErrors($validator)->withInput();
        } else {
            //check authentication of email and password
            $username = request('username');
            $password = request('password');
            $staff = WarehouseStaffModel::where(['username' => $username, 'password' => $password, 'is_del' => 0])->first();
            {
                if (isset($staff)) {
                    $request->session()->put('staff', $staff);
                    return redirect('staff_dashboard');
                } else {
                    return redirect('staff_login')->with('message', 'Username / Password Invalid');
                }
            }
        }

    }
    public function staff_dashboard()
    {
        return view('staff.staff_dashboard');
    }

//logout
    function logout(Request $request)
    {
        $request->session()->forget('staff');
        return redirect('staff_login');
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
}
