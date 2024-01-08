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

class AdminController extends Controller
{
   
    public function main_staff(Request $request)
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
                    AND t.train_active = "REQ"              
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
                    AND t.train_active = "REQ"                
            '); 
        }        
               
        return view('admin.main_staff',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
        ]);
    }
    public function main_staff_add(Request $request)
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
     
        return view('admin.main_staff_add',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
        ]);
    }
    public function main_staff_save(Request $request)
    { 
        $storeid   = Auth::user()->store_id;
        $count_check = User::where('username','=',$request->username)->count(); 

        if ($count_check > 0) {
            return response()->json([
                'status'     => '100'
            ]); 
        } else {
            $add = new User;
            $add->fname       = $request->fname;
            $add->lname       = $request->lname;    
            $add->pname       = $request->pname;
            $add->cid         = $request->cid;  
            $add->position_id = $request->position_id; 
            $add->username    = $request->username; 
            $add->line_token  = $request->line_token; 
            $add->hn_id       = $request->hn_id;
            $add->po_id       = $request->po_id; 
            $add->sso_id      = $request->sso_id;
            $add->store_id    = $storeid;
            $pass             = $request->password;

            $add->password    = Hash::make($pass);
            $add->passapp     = $pass;

            if ($request->hasfile('img')) {
                $description = 'storage/person/'.$add->img;
                if (File::exists($description))
                {
                    File::delete($description);
                }
                $file = $request->file('img');
                $extention = $file->getClientOriginalExtension();
                $filename = time().'.'.$extention; 
                $request->img->storeAs('person',$filename,'public'); 
                $add->img = $filename;
                $add->img_name = $filename;
            }
            $add->save();
 
            return response()->json([
                'status'     => '200'
            ]); 
        }
         
                
    }
    public function main_staff_edit(Request $request,$id)
    { 
        $storeid   = Auth::user()->store_id;
        $dataedits = User::where('id',$id)->first();
        $data['users']              = User::where('store_id','=',$storeid)->get();
        $data['department']         = Department::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position']           = Position::get();
        $data['status']             = Status::get();
        $data['users_prefix']       = Users_prefix::get();
        $data['users_kind_type']    = Users_kind_type::get();

        return view('admin.main_staff_edit',$data,[
            // 'startdate'     =>     $startdate,
            // 'enddate'       =>     $enddate,
            'dataedits'     =>     $dataedits,
        ]);
    }
 
    public function main_staff_update(Request $request)
    { 
        // dd($request->position_id);
        $storeid   = Auth::user()->store_id;
        // $count_check = User::where('username','=',$request->username)->count(); 
        $idper = $request->id; 
        // if ($count_check > 0) {
        //     return response()->json([
        //         'status'     => '100'
        //     ]); 
        // } else {
            $update = User::find($idper);
            $update->fname       = $request->fname;
            $update->lname       = $request->lname;    
            $update->pname       = $request->pname;
            $update->cid         = $request->cid;  
            $update->position_id = $request->position_id; 
            $update->username    = $request->username; 
            $update->line_token  = $request->line_token; 
            $update->hn_id       = $request->hn_id;
            $update->po_id       = $request->po_id; 
            $update->sso_id      = $request->sso_id;
            $update->store_id    = $storeid;
            $pass             = $request->password;

            $update->password    = Hash::make($pass);
            $update->passapp     = $pass;

            if ($request->hasfile('img')) {
                $description = 'storage/person/'.$update->img;
                if (File::exists($description))
                {
                    File::delete($description);
                }
                $file = $request->file('img');
                $extention = $file->getClientOriginalExtension();
                $filename = time().'.'.$extention; 
                $request->img->storeAs('person',$filename,'public'); 
                $update->img = $filename;
                $update->img_name = $filename;
            }
            $update->save();
 
            return response()->json([
                'status'     => '200'
            ]); 
        }
         
                
    // }
    
}
