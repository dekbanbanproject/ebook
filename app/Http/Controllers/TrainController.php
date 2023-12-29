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
use Illuminate\Support\Facades\File;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Auth;

class TrainController extends Controller
{
   
    public function user_train(Request $request)
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

        return view('font_user.user_train_add',$data,[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
        ]);
    }
        
    public function user_train_save(Request $request)
    { 
        $date =  date('Y-m-d');
         
        Train::insert([ 
            'train_book_advert'        => $request->train_book_advert, 
            'train_book_no'            => $request->train_book_no, 
            'train_date_go'            => $request->train_date_go, 
            'train_date_back'          => $request->train_date_back,
            'train_title'              => $request->train_title, 
            'train_detail'             => $request->train_detail,
            'train_assign_work'        => $request->train_assign_work,
            'train_vehicle'            => $request->train_vehicle,
            'train_head'               => $request->train_head, 
            'train_date'               => $date, 
            'train_locate'             => $request->train_locate, 
            'train_expenses'           => $request->train_expenses,
            'train_expenses_out'       => $request->train_expenses_out,
            // 'train_expenses'           => $request->train_expenses_w,
        ]); 
        
     
        return response()->json([
            'status'     => '200'
        ]); 
      
         
                
    }

    // public function password_update(Request $request)
    // {
    //     $idper =  Auth::user()->id;
        
    //     $update = User::find($idper);

    //     $update->password = Hash::make($request->password);
        
    //     $update->save();

    //     return response()->json([
    //         'status'     => '200'
    //     ]);
        
    
        
    // }
}
