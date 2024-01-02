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

class TrainController extends Controller
{
   
    public function user_train(Request $request)
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
                    ,t.train_vehicle,t.train_vehicle_pai,p.fname,p.lname
                    FROM train t
                    LEFT OUTER JOIN train_location tl ON tl.train_location_id = t.train_locate
                    LEFT OUTER JOIN users p ON p.id = t.train_assign_work 
                    WHERE t.train_date_go BETWEEN "'.$startdate.'" and "'.$enddate.'"
                
            '); 
        } else {
            $data['train'] = DB::connection('mysql')->select(' 
                SELECT t.train_id
                    ,t.train_book_advert,t.train_book_no,t.train_date,t.train_title,tl.train_location_name,t.train_detail,t.train_date_go,t.train_date_back
                    ,t.train_vehicle,t.train_vehicle_pai,p.fname,p.lname
                    FROM train t
                    LEFT OUTER JOIN train_location tl ON tl.train_location_id = t.train_locate
                    LEFT OUTER JOIN users p ON p.id = t.train_assign_work 
                    WHERE t.train_date_go BETWEEN "'.$newDate.'" and "'.$date.'"
                
            '); 
        }   
           
        return view('font_user.user_train',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
        ]);
    }

    public function user_train_add(Request $request)
    {
        $storeid = Auth::user()->store_id;
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $data['users']              = User::where('store_id','=',$storeid)->get();
        $data['department']         = Department::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position']           = Position::get();
        $data['status']             = Status::get();
        $data['users_prefix']       = Users_prefix::get();
        $data['users_kind_type']    = Users_kind_type::get();
        $data['users_group']        = Users_group::get(); 
        $data['train_location']     = Train_location::get(); 

        return view('font_user.user_train_add',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
        ]);
    }
    function addlocation(Request $request)
    {     
     if($request->location_name!= null || $request->location_name != ''){    
         $count_check = Train_location::where('train_location_name','=',$request->location_name)->count();           
            if($count_check == 0){    
                    $add = new Train_location(); 
                    $add->train_location_name = $request->location_name;
                    $add->save(); 
            }
            }
                $query =  DB::table('train_location')->get();            
                $output='<option value="">--สถานที่จัด--</option>';                
                foreach ($query as $row){
                    if($request->location_name == $row->train_location_name){
                        $output.= '<option value="'.$row->train_location_id.'" selected>'.$row->train_location_name.'</option>';
                    }else{
                        $output.= '<option value="'.$row->train_location_id.'">'.$row->train_location_name.'</option>';
                    }   
            }    
        echo $output;        
    }
        
    public function user_train_save(Request $request)
    { 
        $date        =  date('Y-m-d');
        $add_img     = $request->input('signature');  
        $sige_id      = User::where('id','=',$request->train_assign_work)->first();
        $head_id      = User::where('id','=',$request->train_head)->first();
        $locate_id    = Train_location::where('train_location_id','=',$request->train_locate)->first();
        
        if ($add_img != '') {
            Train::insert([ 
                'train_book_advert'        => $request->train_book_advert, 
                'train_book_no'            => $request->train_book_no, 
                'train_date_go'            => $request->train_date_go, 
                'train_date_back'          => $request->train_date_back,
                'train_title'              => $request->train_title, 
                'train_detail'             => $request->train_detail,

                'train_assign_work'        => $request->train_assign_work,
                'train_assign_work_name'   => $sige_id->fname. '  '.$sige_id->lname,

                'train_vehicle'            => $request->train_vehicle,
                'train_vehicle_pai'        => $request->train_vehicle_pai,

                'train_head'               => $request->train_head, 
                'train_head_name'          => $head_id->fname. '  '.$head_id->lname,

                'train_date'               => $date, 
               
                'train_locate'             => $request->train_locate, 
                'train_locate_name'        => $locate_id->train_location_name,

                'user_id'                  => $request->user_id, 
                'train_signature'          => $add_img,
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

    public function user_train_edit(Request $request,$id)
    {   
        $storeid = Auth::user()->store_id;
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $data['users']              = User::where('store_id','=',$storeid)->get();
        $data['department']         = Department::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position']           = Position::get();
        $data['status']             = Status::get();
        $data['users_prefix']       = Users_prefix::get();
        $data['users_kind_type']    = Users_kind_type::get();
        $data['users_group']        = Users_group::get(); 
        $data['train_location']     = Train_location::get(); 

        $dataedit = Train::where('train_id','=',$id)->first(); 
        $signature = base64_encode(file_get_contents($dataedit->train_signature)); 
 
        return view('font_user.user_train_edit',$data,[
            'dataedits'   => $dataedit,
            'signature'   => $signature
        ]);
    }

    public function user_train_update(Request $request)
    { 
        $date         =  date('Y-m-d');
        $add_img      = $request->input('signature'); 
        $train_id     = $request->input('train_id'); 
        $sige_id      = User::where('id','=',$request->train_assign_work)->first();
        $head_id      = User::where('id','=',$request->train_head)->first();
        $locate_id    = Train_location::where('train_location_id','=',$request->train_locate)->first();

        if ($add_img != '') {
            Train::where('train_id',$train_id)->update([ 
                'train_book_advert'        => $request->train_book_advert, 
                'train_book_no'            => $request->train_book_no, 
                'train_date_go'            => $request->train_date_go, 
                'train_date_back'          => $request->train_date_back,
                'train_title'              => $request->train_title, 
                'train_detail'             => $request->train_detail,

                'train_assign_work'        => $request->train_assign_work,
                'train_assign_work_name'   => $sige_id->fname. '  '.$sige_id->lname,

                'train_vehicle'            => $request->train_vehicle,
                'train_vehicle_pai'        => $request->train_vehicle_pai,

                'train_head'               => $request->train_head, 
                'train_head_name'          => $head_id->fname. '  '.$head_id->lname,

                'train_date'               => $date, 

                'train_locate'             => $request->train_locate, 
                'train_locate_name'        => $locate_id->train_location_name,

                'user_id'                  => $request->user_id, 
                'train_signature'          => $add_img,
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
