@extends('layouts.sso_user')
@section('title', 'd-ebook || sso')
@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Srisakdi:wght@400;700&display=swap" rel="stylesheet">
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
</script>
<?php
if (Auth::check()) {
    $type = Auth::user()->type;
    $iduser = Auth::user()->id;
} else {
    echo "<body onload=\"TypeAdmin()\"></body>";
    exit();
}
$url = Request::url();
$pos = strrpos($url, '/') + 1;
$ynow = date('Y') + 543;
$yb = date('Y') + 542;
use App\Http\Controllers\StaticController;
        $checkhn    = StaticController::checkhn($iduser);
        $checkpo    = StaticController::checkpo($iduser);  
        $checksso   = StaticController::checksso($iduser);
?>

<style>
    #button {
        display: block;
        margin: 20px auto;
        padding: 30px 30px;
        background-color: #eee;
        border: solid #ccc 1px;
        cursor: pointer;
    }

    #overlay {
        position: fixed;
        top: 0;
        z-index: 100;
        width: 100%;
        height: 100%;
        display: none;
        background: rgba(0, 0, 0, 0.6);
    }

    .cv-spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .spinner {
        width: 250px;
        height: 250px;
        border: 10px #ddd solid;
        border-top: 10px #1fdab1 solid;
        border-radius: 50%;
        animation: sp-anime 0.8s infinite linear;
    }

    @keyframes sp-anime {
        100% {
            transform: rotate(360deg);
        }
    }

    .is-hide {
        display: none;
    }
    .bar{
        height: 50px;
        background-color: rgb(10, 218, 55);
    }
    .percent{
        position: absolute;
        left: 50%;
        color: black;
    }       
    .card{
        border-radius: 3em 3em 3em 3em;
        /* box-shadow: 0 0 10px teal; */
    }
    .card-ucs{
        border-radius: 3em 3em 3em 3em;
        box-shadow: 0 0 10px rgb(3, 136, 252);
    }
    .card-ofc{
        border-radius: 3em 3em 3em 3em;
        box-shadow: 0 0 10px rgb(10, 110, 223);
    }
    .card-lgo{
        border-radius: 3em 3em 3em 3em;
        box-shadow: 0 0 10px teal;
    }
    .card-ucsti{
        border-radius: 3em 3em 3em 3em;
        box-shadow: 0 0 10px rgb(252, 144, 3);
    }
    .card-ofcti{
        border-radius: 3em 3em 3em 3em;
        box-shadow: 0 0 10px rgb(252, 3, 82);
    }
    .card-sssti{
        border-radius: 3em 3em 3em 3em;
        box-shadow: 0 0 10px rgb(94, 93, 93);
    }
    .card-lgoti{
        border-radius: 3em 3em 3em 3em;
        box-shadow: 0 0 10px teal;
    }
    .nav{
     
        border-radius: 3em 3em 20 20;
        background-color: aliceblue;
        /* box-shadow: 0 0 10px teal; */
    }
    .nav-link{
        border-radius: 20 20 10 10;
        box-shadow: 0 0 10px teal;
    }
    .Head1{
			font-family: 'Srisakdi', sans-serif;
            font-size: 17px;
            /* font-style: normal; */
          font-weight: 700;
		}
        .detail{
            font-size: 13px;
        }
</style>
  
<div class="tabs-animation">
    <div id="preloader">
        <div id="status">
            <div class="spinner">
            </div>
        </div>
    </div>
    <div class="row text-center">
        <div id="overlay">
            <div class="cv-spinner">
                <span class="spinner"></span>
            </div>
        </div> 
    </div>
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-md-4">
                <h4 class="mb-sm-0">Main Ebook</h4>
            </div>
            <div class="col"></div>
            <div class="col-md-3 text-end">
                {{-- <a href="" class="ladda-button btn-pill btn btn-info d-shadow"> --}}
                {{-- <a href="" class="btn btn-info btn-rounded btn-sm waves-effect waves-light d-shadow">
                    <span class="ladda-label"> 
                        <i class="fa-solid fa-user-group text-white me-3 ms-3"></i>
                        <label for="" style="color: white;font-size:20px;" class="me-3 Head1">ผอ.</label>
                    </span> 
                </a> 
                <a href="" class="btn btn-primary btn-rounded btn-sm waves-effect waves-light d-shadow">
                    <span class="ladda-label">
                         <i class="fa-solid fa-user-group text-white me-3 ms-3"></i>
                        <label for="" style="color: white;font-size:20px;" class="me-3 Head1">สสอ.</label>
                    </span> 
                </a>  --}}
                {{-- <a href="{{url('user_train_po')}}" class="btn btn-info btn-rounded btn-sm waves-effect waves-light"><i class="fa-solid fa-user-group text-white me-2 ms-2"></i>
                    <label for="" style="color: white;" class="me-3 Head1">ผอ.</label>
                </a>
                <a href="{{url('user_train_sso')}}" class="btn btn-primary btn-rounded btn-sm waves-effect waves-light"><i class="fa-solid fa-user-group text-white me-2 ms-2"></i>
                    <label for="" style="color: white;" class="me-3 Head1">สสอ.</label>
                </a> --}}
                @if ($checkpo != 0)
                    <a href="{{url('user_train_po')}}" class="ladda-button btn-pill btn btn-primary d-shadow me-2" target="_blank">
                        <span class="ladda-label"><i class="fa-solid fa-user-group text-white me-2"></i> PO </span>
                        <span class="ladda-spinner"></span> 
                    </a>
                @endif
                @if ($checksso != 0)
                    <a href="{{ url('user_train_sso') }}" class="ladda-button btn-pill btn btn-danger d-shadow" target="_blank">
                        <i class="fa-solid fa-user-group me-2"></i>
                        SSO
                    </a>
                @endif
            </div>
            
            {{-- <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Main Ebook</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"> 
                                <a href="" class="ladda-button btn-pill btn btn-info d-shadow">
                                    <span class="ladda-label"> <i class="fa-solid fa-user-group text-white me-3 ms-3"></i>
                                        <label for="" style="color: white;font-size:20px;" class="me-3 Head1">ผอ.</label>
                                    </span> 
                                </a> 
                            </li>
                             
                            <li class="breadcrumb-item">
                                <a href="" class="ladda-button btn-pill btn btn-primary d-shadow">
                                    <span class="ladda-label">
                                         <i class="fa-solid fa-user-group text-white me-3 ms-3"></i>
                                        <label for="" style="color: white;font-size:20px;" class="me-3 Head1">สสอ.</label>
                                    </span> 
                                </a> 
                            </li>
                        </ol>
                    </div>

                </div>
            </div> --}}

        </div>
        <!-- end page title -->
    </div> <!-- container-fluid -->

        {{-- <form action="{{ url('main_user') }}" method="GET">
            @csrf
        <div class="row">  
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-6 text-end">
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control d-shadow" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control d-shadow" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}"/>   
                        <button type="submit" class="ladda-button btn-pill btn btn-primary d-shadow" data-style="expand-left">
                            <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                            <span class="ladda-spinner"></span>
                        </button>  
                </div> 
            </div>
        </div>      
        </form> --}}
 
    <div class="row mt-3">
        <div class="col-xl-12">
            <div class="card cardshadow">
                <div class="card-body">  
                    <p class="mb-0">
                        {{-- <div class="table-responsive">
                            <table id="example" class="table table-hover table-sm dt-responsive nowrap"
                            style=" border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr> 
                                        <th width="5%" class="text-center">ลำดับ</th>  
                                        <th class="text-center">หนังสืออ้างอิง</th>
                                        <th class="text-center" >เลขที่หนังสือ</th>
                                        <th class="text-center" >เรื่อง</th>
                                        <th class="text-center">หน่วยงานที่จัด</th>
                                        <th class="text-center">ประเภท</th> 
                                        <th class="text-center">วันที่</th>  
                                        <th class="text-center">ถึงวันที่</th> 
                                        <th class="text-center">พาหนะ</th>
                                        <th class="text-center">หัวหน้า</th>  
                                        <th class="text-center">ค่าสารทึบแสง</th>
                                        <th class="text-center">before</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                            </table>
                        </div> --}}
                    </p>
                </div>
            </div>
        </div>
    </div> 
</div>
 
 
@endsection
@section('footer')
<script>
    $(document).ready(function() {
        $('#example').DataTable();
        $('#example2').DataTable();
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#stamp').on('click', function(e) {
        if($(this).is(':checked',true))  
        {
            $(".sub_chk").prop('checked', true);  
        } else {  
            $(".sub_chk").prop('checked',false);  
        }  
        }); 
    }); 
</script>
@endsection
