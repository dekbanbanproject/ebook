<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 
use Illuminate\support\Facades\Validator; 
use App\Models\Department;
use App\Models\Departmentsub;
use App\Models\Departmentsubsub;
use App\Models\Position;
use App\Models\Status;
use App\Models\Users_prefix;
use App\Models\Users_kind_type;
use App\Models\Users_group;
use App\Models\Train;
use App\Models\Train_location;
use Illuminate\Support\Facades\File;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Auth;

class SSOController extends Controller
{
   
    public function user_train_sso(Request $request)
    {
        $storeid   = Auth::user()->store_id;
        $startdate = $request->startdate;
        $enddate   = $request->enddate;
        $date      = date('Y-m-d');
        $y         = date('Y') + 543;
        $newweek   = date('Y-m-d', strtotime($date . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
        $newDate   = date('Y-m-d', strtotime($date . ' -1 months')); //ย้อนหลัง 5 เดือน
        $newyear   = date('Y-m-d', strtotime($date . ' -1 year')); //ย้อนหลัง 1 ปี
        $yearnew   = date('Y')+1;
        $yearold   = date('Y');
        $start     = (''.$yearold.'-10-01');
        $end       = (''.$yearnew.'-09-30'); 

        $data['users']              = User::where('store_id','=',$storeid)->get();
        $data['department']         = Department::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position']           = Position::get();
        $data['status']             = Status::get();
        $data['users_prefix']       = Users_prefix::get();
        $data['users_kind_type']    = Users_kind_type::get();
        // $data['train']        = Train::get(); 
        if ($startdate != '') {
            $data['train'] = DB::connection('mysql')->select(' 
                SELECT t.train_id
                    ,t.train_book_advert,t.train_book_no,t.train_date,t.train_title,tl.train_location_name,t.train_detail,t.train_date_go,t.train_date_back
                    ,t.train_vehicle,t.train_vehicle_pai,p.fname,p.lname,t.train_active
                    FROM train t
                    LEFT OUTER JOIN train_location tl ON tl.train_location_id = t.train_locate
                    LEFT OUTER JOIN users p ON p.id = t.train_assign_work 
                    WHERE t.train_date_go BETWEEN "'.$startdate.'" and "'.$enddate.'"  
                    AND t.train_active = "AGREE"              
            '); 
        } else {
            $data['train'] = DB::connection('mysql')->select(' 
                SELECT t.train_id
                    ,t.train_book_advert,t.train_book_no,t.train_date,t.train_title,tl.train_location_name,t.train_detail,t.train_date_go,t.train_date_back
                    ,t.train_vehicle,t.train_vehicle_pai,p.fname,p.lname,t.train_active
                    FROM train t
                    LEFT OUTER JOIN train_location tl ON tl.train_location_id = t.train_locate
                    LEFT OUTER JOIN users p ON p.id = t.train_assign_work 
                    WHERE t.train_date_go BETWEEN "'.$newDate.'" and "'.$date.'" 
                    AND t.train_active = "AGREE"                
            '); 
        }        
               
        return view('font_user.user_train_sso',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
        ]);
    }
      

    public function user_train_sso_approve(Request $request)
    { 
        $date         =  date('Y-m-d');
        $add_img      = $request->input('signature'); 
        $train_id     = $request->input('train_id'); 

        if ($add_img != '') {
            Train::where('train_id',$train_id)->update([ 
                 
                'train_active'                => 'APPROVE', 
                'train_signature_sso'          => $add_img,
            ]);  
            return response()->json([
                'status'     => '200'
            ]); 
        } else {
            return response()->json([
                'status'     => '50',
            ]);
        }                
    }
    public function user_train_sso_noapprove(Request $request)
    { 
        $date         =  date('Y-m-d');
        $add_img      = $request->input('signature'); 
        $train_id     = $request->input('train_id'); 

        if ($add_img != '') {
            Train::where('train_id',$train_id)->update([ 
                 
                'train_active'                => 'NOAPPROVE', 
                'train_signature_sso'          => $add_img,
            ]);  
            return response()->json([
                'status'     => '200'
            ]); 
        } else {
            return response()->json([
                'status'     => '50',
            ]);
        }              
    }
    
}
