<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminTestController extends Controller
{
    /**
     * @return string
     */
    public function test()
    {
        return view('pos.create_pos');
    }
}
