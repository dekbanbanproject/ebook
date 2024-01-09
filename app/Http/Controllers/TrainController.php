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
use PDF;
use setasign\Fpdi\Fpdi;
 
 

class TrainController extends Controller
{
   
    public function user_train(Request $request)
    {
        $storeid   = Auth::user()->store_id;
        $iduser    = Auth::user()->id;
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
                    AND user_id = "'. $iduser.'"
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
                    AND user_id = "'. $iduser.'"
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
        if ($dataedit->train_signature == '') {
            $signature = ''; 
        } else {
            $signature = base64_encode(file_get_contents($dataedit->train_signature)); 
        }
        
        
 
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

    public function user_train_print(Request $request, $id)
    { 
        $dataedit = Train::leftjoin('users', 'users.id', '=', 'train.user_id')->leftjoin('users_prefix', 'users_prefix.prefix_id', '=', 'users.pname')
            ->leftjoin('position', 'position.POSITION_ID', '=', 'users.position_id')
            ->where('train_id', '=', $id)->first();
        
        $org = DB::table('orginfo')->where('orginfo_id','=',1)
            ->leftjoin('users','users.id','=','orginfo.orginfo_po_id')
            ->leftjoin('users_prefix','users_prefix.prefix_code','=','users.pname')
            ->first();
        $po = $org->prefix_name.' '.$org->fname.'  '.$org->lname;

        define('FPDF_FONTPATH', 'font/');
        require(base_path('public') . "/fpdf/WriteHTML.php");

        $pdf = new Fpdi(); // Instantiation   start-up Fpdi

        function dayThai($strDate)
        {
            $strDay = date("j", strtotime($strDate));
            return $strDay;
        }
        function monthThai($strDate)
        {
            $strMonth = date("n", strtotime($strDate));
            $strMonthCut = array("", "มกราคม", "กุมภาพันธ์ ", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
            $strMonthThai = $strMonthCut[$strMonth];
            return $strMonthThai;
        }
        function yearThai($strDate)
        {
            $strYear = date("Y", strtotime($strDate)) + 543;
            return $strYear;
        }
        function time($strtime)
        {
            $H = substr($strtime, 0, 5);
            return $H;
        }

        function DateThai($strDate)
        {
            if ($strDate == '' || $strDate == null || $strDate == '0000-00-00') {
                $datethai = '';
            } else {
                $strYear = date("Y", strtotime($strDate)) + 543;
                $strMonth = date("n", strtotime($strDate));
                $strDay = date("j", strtotime($strDate));
                $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
                $strMonthThai = $strMonthCut[$strMonth];
                $datethai = $strDate ? ($strDay . ' ' . $strMonthThai . ' ' . $strYear) : '-';
            }
            return $datethai;
        }

        function DateThaifu($strDate)
        {
            if ($strDate == '' || $strDate == null || $strDate == '0000-00-00') {
                $datethai = '';
            } else {
                $strYear = date("Y", strtotime($strDate)) + 543;
                $strMonth = date("n", strtotime($strDate));
                $strDay = date("j", strtotime($strDate));
                $strMonthCut = array("", "มกราคม", "กุมภาพันธ์ ", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
                $strMonthThai = $strMonthCut[$strMonth];
                $datethai = $strDate ? ($strDay . ' ' . $strMonthThai . ' ' . $strYear) : '-';
            }
            return $datethai;
        }

        $date = date_create($dataedit->created_at);
        $datnow =  date_format($date, "Y-m-j");

        // ข้าพเจ้ามอบหมายงานให้
        $assignwork = Train::leftjoin('users', 'users.id', '=', 'train.train_assign_work')->leftjoin('users_prefix', 'users_prefix.prefix_id', '=', 'users.pname')
        ->leftjoin('position', 'position.POSITION_ID', '=', 'users.position_id')
        ->where('train_id', '=', $id)->first();
        $assign = $assignwork->prefix_name.' '.$assignwork->fname.'  '.$assignwork->lname;
        $assign_posi = $assignwork->POSITION_NAME;

        $pdf->SetLeftMargin(22);
        $pdf->SetRightMargin(5);
       
        $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
        $pdf->AddFont('THSarabunNew Bold', '', 'THSarabunNew Bold.php');
        $pdf->SetFont('THSarabunNew Bold', '', 19);
        // $pdf->AddPage("L", ['100', '100']);
        $pdf->AddPage("P");
        $pdf->Image('assets/images/crut.png', 22, 15, 16, 16);

        $pdf->Cell(135);
        $pdf->SetFont('THSarabunNew', '', 14);
        $no = $pdf->Text(160,14,iconv( 'UTF-8','TIS-620','สำนักงานสาธารณสุขอำเภอสตึก' )); 
        $pdf->Text(160,19,iconv( 'UTF-8','TIS-620','เลขที่รับ' ));
        $pdf->Text(160,25,iconv( 'UTF-8','TIS-620','วันที่ ......../.................../.............' ));
        $pdf->Text(160,30,iconv( 'UTF-8','TIS-620','เวลา ..........................................' ));
        $pdf->Cell(50,22,$no, 1,0, 'C' );
   
        $pdf->SetFont('THSarabunNew Bold', '', 27);
        $pdf->Text(80, 25, iconv('UTF-8', 'TIS-620', 'บันทึกข้อความ'));
        $pdf->SetFont('THSarabunNew', '', 17);
        // $pdf->Text(75, 33, iconv('UTF-8', 'TIS-620', 'โรงพยาบาล ' . $org->orginfo_name));
        $pdf->SetFont('THSarabunNew Bold', '', 17);
        $pdf->Text(25, 41, iconv('UTF-8', 'TIS-620', 'ส่วนราชการ '));
        $pdf->SetFont('THSarabunNew', '', 17);
        $pdf->Text(50, 41, iconv('UTF-8', 'TIS-620', ''.$org->orginfo_name.' อำเภอสตึก จังหวัดบุรีรัมย์ '));
        $pdf->SetFont('THSarabunNew Bold', '', 17);
        $pdf->Text(25, 49, iconv('UTF-8', 'TIS-620', 'ที่ '));   
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(97, 49, iconv('UTF-8', 'TIS-620', 'วันที่ '. DateThaifu($datnow)));  

        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(35, 49, iconv('UTF-8', 'TIS-620', ''. $dataedit->train_book_no));
        $pdf->SetFont('THSarabunNew Bold', '', 17);
        $pdf->Text(25, 57, iconv('UTF-8', 'TIS-620', 'เรื่อง '));
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(35, 57, iconv('UTF-8', 'TIS-620', 'ขออนุมัติเดินทางไปราชการนอกสำนักงาน'));
        // x1,y1,x2,y2
        $pdf->Line(25, 60, 180, 60);   // 25 คือ ย่อหน้า  // 45 คือ margintop   // 180 คือความยาวเส้น 
        $pdf->SetFont('THSarabunNew Bold', '', 15);
        $pdf->Text(25, 65, iconv('UTF-8', 'TIS-620', 'เรียน สาธารณสุขอำเภอสตึก  '));
        $pdf->SetFont('THSarabunNew', '', 15); 
        $pdf->Text(35, 73, iconv('UTF-8', 'TIS-620', 'ข้าพเจ้า  '. $dataedit->prefix_name . '' . $dataedit->fname . '  ' . $dataedit->lname));
        $pdf->Text(95, 73, iconv('UTF-8', 'TIS-620', 'ตำแหน่ง  '. $dataedit->POSITION_NAME ));
        $pdf->Text(25, 80, iconv('UTF-8', 'TIS-620', 'ปฎิบัติงานประจำอยู่ที่ '.$org->orginfo_name.' มึความประสงค์ขออนุมัติเดินทางไปเข้าร่วม'));
        $pdf->Text(25, 88, iconv('UTF-8', 'TIS-620', 'เป็นวิทยากรประชุมเชิงปฎิบัติการเรียกเก็บค่าบริการผู้ป่วยสิทธิประกันสังคมและสิทธิ์อื่นๆ ของกลุ่มโรงพยาบาลส่งเสริม'));
        $pdf->Text(25, 96, iconv('UTF-8', 'TIS-620', 'สุขภาพตำบล ในจังหวัดบุรีรัมย์ ปีงบประมาณ 2567 ดังโปรแกรมดังต่อไปนี้'));
        $pdf->Text(25, 104, iconv('UTF-8', 'TIS-620', 'สถานที่ปฎิบัติราชการ '. $dataedit->train_locate_name));
        $pdf->Text(25, 112, iconv('UTF-8', 'TIS-620', 'งานที่ปฎิบัติ '. $dataedit->train_detail));
        $pdf->Text(25, 120, iconv('UTF-8', 'TIS-620', 'วันที่ไป '. DateThaifu($dataedit->train_date_go)));
        $pdf->Text(70, 120, iconv('UTF-8', 'TIS-620', 'วันที่กลับ '. DateThaifu($dataedit->train_date_back)));
        $pdf->Text(35, 128, iconv('UTF-8', 'TIS-620', 'โดยรถยนต์ '. $dataedit->train_vehicle .'  ทะเบียน '. $dataedit->train_vehicle_pai.'      ในระหว่างที่ข้าพเจ้าไปราชการครั้งนี้'));
        $pdf->Text(25, 136, iconv('UTF-8', 'TIS-620', 'ข้าพเจ้ามอบหมายงานให้ '. $assign.'   ตำแหน่ง  '. $assign_posi ));

        $pdf->Image($dataedit->train_signature, 82, 175, 50, 17, "png");
        $pdf->Text(35, 177, iconv('UTF-8', 'TIS-620', 'จึงเรียนมาเพื่อโปรดพิจารณา'));
        $pdf->Text(80, 190, iconv('UTF-8', 'TIS-620', '(ลงชื่อ) .................................................... ผู้ขออนุญาต'));
        $pdf->SetFont('THSarabunNew', '', 15);
        $pdf->Text(88, 198, iconv('UTF-8', 'TIS-620', '( ..................................................... )'));
        $pdf->Text(80, 206, iconv('UTF-8', 'TIS-620', 'ตำแหน่ง'));
        $pdf->Text(97, 206, iconv('UTF-8', 'TIS-620', ''. $dataedit->POSITION_NAME));

        $pdf->Image($dataedit->train_signature, 40, 205, 50, 17, "png");
        $pdf->Text(35, 220, iconv('UTF-8', 'TIS-620', '(ลงชื่อ) .................................................... ผู้มอบ'));
        $pdf->Text(40, 227, iconv('UTF-8', 'TIS-620', '( .......................................................... )')); 

        $pdf->Text(110, 220, iconv('UTF-8', 'TIS-620', '(ลงชื่อ) .................................................... ผู้รับมอบ'));
        $pdf->Text(115, 227, iconv('UTF-8', 'TIS-620', '( .......................................................... )'));

        $pdf->Text(35, 242, iconv('UTF-8', 'TIS-620', 'ความเห็นของผู้บังคับบัญชา'));
        //ผู้ขออนุญาต
        // if ($siguser != null) {  
        //     //ตรงกลาง
        //     $pdf->Image($siguser, 80, 85, 50, 17, "png");
        //     $pdf->SetFont('THSarabunNew', '', 15);
        //     $pdf->Text(71, 95, iconv('UTF-8', 'TIS-620', '(ลงชื่อ)                                        ผู้แจ้งซ่อม'));
        //     $pdf->SetFont('THSarabunNew', '', 15);
        //     // $pdf->Text(85, 105, iconv('UTF-8', 'TIS-620', '(   ' . $dataedit->com_repaire_user_name . '   )'));
        // } else {
            
        // }

        // $pdf->Line(25, 110, 180, 110);   // 25 คือ ย่อหน้า  // 45 คือ margintop   // 180 คือความยาวเส้น 
        
        if ($dataedit->train_active == "APPROVE") { 
            $pdf->Image(base_path('public') . '/fpdf/img/checked.png', 47, 247, 4, 4);  
            $pdf->Text(53, 250, iconv('UTF-8', 'TIS-620', 'เห็นควรอนุมัติ')); 

            $pdf->Image(base_path('public') . '/fpdf/img/checked.png', 140, 247, 4, 4);  
            $pdf->Text(147, 250, iconv('UTF-8', 'TIS-620', 'อนุมัติ')); 

        } else {
            $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 35, 250, 4, 4);
         }
       
         $pdf->Image($dataedit->train_signature_po, 35, 257, 50, 17, "png");
         $pdf->Text(43, 274, iconv('UTF-8', 'TIS-620', '('.$po.' )'));
         $pdf->Text(25, 282, iconv('UTF-8', 'TIS-620', 'ผู้อำนวยการ'.$org->orginfo_name));

         $pdf->Image($dataedit->train_signature_sso, 124, 257, 50, 17, "png");
         $pdf->Text(135, 274, iconv('UTF-8', 'TIS-620', '( '.$org->head_sso_name.' )'));
         $pdf->Text(137, 282, iconv('UTF-8', 'TIS-620', ''.$org->sso_name));
        //ผู้ดูแลอนุญาต
        // if ($sigstaff != null) {
        //     $pdf->Image($sigstaff, 109, 173, 50, 17, "png");
        //     $pdf->SetFont('THSarabunNew', '', 15);
        //     $pdf->Text(100, 188, iconv('UTF-8', 'TIS-620', '(ลงชื่อ)                                            ผู้อนุญาต'));
        //     // $pdf->Text(112, 198, iconv('UTF-8', 'TIS-620', '(   ' . $dataedit->car_service_staff_name . '   )'));
        // } else {
        //     // $pdf->Image($siguser, 105,173, 50, 17,"png"); 
        //     $pdf->SetFont('THSarabunNew', '', 15);
        //     $pdf->Text(100, 180, iconv('UTF-8', 'TIS-620', '(ลงชื่อ) ......................................................... ผู้อนุญาต'));
        //     $pdf->SetFont('THSarabunNew', '', 15);
        //     $pdf->Text(108, 189, iconv('UTF-8', 'TIS-620', '( .......................................................... )'));
        // }

    
        // if ($sigpo != null) { 
        //     if ($dataedit->car_service_status == "noallow") {
        //         $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 105, 217, 4, 4);
        //         $pdf->Image(base_path('public') . '/fpdf/img/checked.png', 140, 217, 4, 4);
        //     } else {
        //         $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 140, 217, 4.5, 4.5);
        //         $pdf->Image(base_path('public') . '/fpdf/img/checked.png', 105, 217, 4.5, 4.5); 
        //     } 
        //     $pdf->Image($sigpo, 109, 225, 50, 17, "png");
        //     $pdf->Text(108, 249, iconv('UTF-8', 'TIS-620', $po)); 
        //     $pdf->SetFont('THSarabunNew', '', 15);
        //     $pdf->Text(100, 240, iconv('UTF-8', 'TIS-620', '(ลงชื่อ)                                              ผู้อนุญาต')); 
        //     $pdf->Text(108, 258, iconv('UTF-8', 'TIS-620', 'ผู้อำนวยการ' . $orgpo->orginfo_name));
        // } else { 
        //     $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 105, 217, 4, 4);
        //     $pdf->Image(base_path('public') . '/fpdf/img/checkno.jpg', 140, 217, 4, 4);
        //     $pdf->SetFont('THSarabunNew', '', 15);
        //     $pdf->Text(100, 240, iconv('UTF-8', 'TIS-620', '(ลงชื่อ) ......................................................... ผู้อนุญาต'));
        //     $pdf->SetFont('THSarabunNew', '', 15);
        //     $pdf->Text(108, 249, iconv('UTF-8', 'TIS-620', '( .......................................................... )'));
        //     $pdf->SetFont('THSarabunNew', '', 15);
        //     $pdf->Text(108, 258, iconv('UTF-8', 'TIS-620', 'ผู้อำนวยการ' . $orgpo->orginfo_name));
        // }


        $pdf->Output();

        exit;
    }


 
}
