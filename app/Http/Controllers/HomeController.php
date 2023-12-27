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

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('home');
    }
    public function main_user(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        return view('font_user.main_user',[
            'startdate'     =>     $startdate,
            'enddate'       =>     $enddate,
        ]);
    }
    public function user_editprofile(Request $request,$id)
    { 
        $storeid = Auth::user()->store_id;
        // $data['q'] = $request->query('q');
        // $query = User::select('users.*') 
        // ->where(function ($query) use ($data){
        //     $query->where('pname','like','%'.$data['q'].'%');
        //     $query->orwhere('fname','like','%'.$data['q'].'%');
        //     $query->orwhere('lname','like','%'.$data['q'].'%');
        //     $query->orwhere('tel','like','%'.$data['q'].'%');
        //     $query->orwhere('username','like','%'.$data['q'].'%');
        // });
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
    // public function admin_profile_edit(Request $request,$id)
    // {   
    //     $data['q'] = $request->query('q');
    //     $query = User::select('users.*')
    //     // ->leftjoin('store_manager','store_manager.store_id','=','users.store_id')
    //     ->where(function ($query) use ($data){
    //         $query->where('pname','like','%'.$data['q'].'%');
    //         $query->orwhere('fname','like','%'.$data['q'].'%');
    //         $query->orwhere('lname','like','%'.$data['q'].'%');
    //         $query->orwhere('tel','like','%'.$data['q'].'%');
    //         $query->orwhere('username','like','%'.$data['q'].'%');
    //     });
    //     $data['users'] = $query->orderBy('id','DESC')->get();
    //     $data['department'] = Department::get();
    //     $data['department_sub'] = Departmentsub::get();
    //     $data['department_sub_sub'] = Departmentsubsub::get();
    //     $data['position'] = Position::get();
    //     $data['status'] = Status::get();
    //     $data['users_prefix'] = Users_prefix::get();
    //     $data['users_kind_type'] = Users_kind_type::get();
    //     $data['users_group'] = Users_group::get();

    //     $dataedit = User::where('id','=',$id)->first();

    //     return view('profile.admin_profile_edit',$data,[
    //         'dataedits'=>$dataedit
    //     ]);
    // }
    
    public function user_profile_update(Request $request)
    {
        $date =  date('Y');
        $maxid = User::max('id');
        $idfile = $maxid+1; 
        $idper = $request->id; 
        // $count_check = User::where('username','=',$request->username)->count(); 

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

            // // $update->member_id =  'MEM'. $date .'-'.$idfile; 
            // if ($request->hasfile('img')) {
            //     $description = 'storage/person/'.$request->img;
            //     if (File::exists($description))
            //     {
            //         File::delete($description);
            //     }
            //     $file = $request->file('img');
            //     // dd($file);
            //     $extention = $file->getClientOriginalExtension();
            //     $filename = time().'.'.$extention; 
            //     $request->img->storeAs('person',$filename,'public'); 
            //     $update->img = $filename;
            //     $update->img_name = $filename;
            // }
            // $update->save();
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
