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
use Illuminate\Support\Facades\File;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Auth;

class TrainController extends Controller
{
   
    public function user_train(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        return view('font_user.user_train',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
        ]);
    }
    public function user_editprofile(Request $request,$id)
    { 
        $storeid = Auth::user()->store_id;
        
        // $data['users'] = $query->orderBy('id','DESC')->get();
        $data['users']              = User::where('store_id','=',$storeid)->get();
        $data['department']         = Department::get();
        $data['department_sub']     = Departmentsub::get();
        $data['department_sub_sub'] = Departmentsubsub::get();
        $data['position']           = Position::get();
        $data['status']             = Status::get();
        $data['users_prefix']       = Users_prefix::get();
        $data['users_kind_type']    = Users_kind_type::get();
        $data['users_group']        = Users_group::get(); 
        $data['dataedits']          = User::where('id','=',$id)->first();
       
        return view('font_user.user_editprofile',$data);
    }
    
    
    public function user_profile_update(Request $request)
    {
        $date =  date('Y');
        $maxid = User::max('id');
        $idfile = $maxid+1; 
        $idper = $request->id; 
       
            $update = User::find($idper);
            $update->fname       = $request->fname;
            $update->lname       = $request->lname;    
            $update->pname       = $request->pname;
            $update->cid         = $request->cid;  
            $update->position_id = $request->position_id; 
            $update->username    = $request->username; 
            $update->line_token  = $request->line_token; 
            
            $pass                = $request->password;

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

            // / 
            return response()->json([
                'status'     => '200'
            ]); 
        // }
         
                
    }

    public function password_update(Request $request)
    {
        $idper =  Auth::user()->id;
        
        $update = User::find($idper);

        $update->password = Hash::make($request->password);
        
        $update->save();

        return response()->json([
            'status'     => '200'
        ]);
        
    
        
    }
}
