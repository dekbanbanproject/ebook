@extends('layouts.sso_user')
@section('title', 'd-ebook || sso')
@section('content')
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
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Main Ebook</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Main Ebook</a></li>
                            <li class="breadcrumb-item active">Ebook</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
    </div> <!-- container-fluid -->

        <form action="{{ url('main_user') }}" method="GET">
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
        </form>


       
 

    <div class="row mt-3">
        <div class="col-xl-12">
            <div class="card cardshadow">
                <div class="card-body">  
                    <p class="mb-0">
                        <div class="table-responsive">
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
                                {{-- <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow as $item) 
                                        <tr id="tr_{{$item->a_stm_ct_id}}">                                                  
                                            <td class="text-center" width="5%">{{ $i++ }}</td>    
                                            <td class="text-center" width="5%">{{ $item->vn }}</td> 
                                            <td class="text-center" width="5%">{{ $item->hn }}</td>  
                                            <td class="text-center" width="10%">{{ $item->cid }}</td>  
                                            <td class="p-2" >{{ $item->ptname }}</td>  
                                            <td class="text-center" style="color:rgb(216, 95, 14)" width="5%">{{ $item->ptty_spsch }}</td>  
                                            <td class="text-center" width="10%">{{ number_format($item->price_check, 2) }}</td>  
                                        </tr>
 
                                    @endforeach
                                </tbody> --}}
                            </table>
                        </div>
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
