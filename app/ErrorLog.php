<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Mail;

class ErrorLog extends Model
{
    protected $table = 'error_log';
    public $timestamps = false;

    public static function store_error($err_msg, $controller_name, $function_name)
    {
        $store_error = new ErrorLog();
        $store_error->error_msg = $err_msg;
        $store_error->controller_name = $controller_name;
        $store_error->function_name = $function_name;
        $store_error->created_time = Carbon::now('Asia/Kolkata');
        $store_error->save();
    }

//     public static function send_mail()
//     {
//         $_SESSION['schedular'] = InterviewSchedular::find(request('isid'));

//         Mail::send(['html' => 'mail'], ['name', 'Saisun'], function ($message) {
//             $otheremails = request('other_email');
//             $schedular = InterviewSchedular::find(request('isid'));
//             $message->to($schedular->hr->email, 'To ' . ucfirst($schedular->hr->name))->subject('Saisun Groups - Interview Schedule List');
//             if ($otheremails != null) {
//                 foreach ($otheremails as $otheremail) {
//                     $message->bcc($otheremail, null);
//                 }
//             }
//             $message->from('saisungroupetrack@gmail.com', 'Saisun Groups - Support Team');
// //            $message->attach('abc.jpg');
//         });
// //        return redirect('/');
//     }
}
