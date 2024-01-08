@extends('layouts.sso_admin')
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
        <div class="row">
            <div class="col-md-4">
                <h4 class="mb-sm-0">Main Ebook Staff</h4>
            </div>
            <div class="col"></div>
            <div class="col-md-3 text-end">
                <a href="{{url('main_staff_add')}}" class="ladda-button btn-pill btn btn-primary d-shadow me-2" target="_blank">
                    <span class="ladda-label"><i class="fa-solid fa-user-group text-white me-2"></i> Add Staff </span>
                    <span class="ladda-spinner"></span> 
                </a>                
            </div> 
        </div> 
    </div> 
    <!-- container-fluid -->
 
 
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
                                        <th class="text-center">Picture</th>
                                        <th class="text-center">ชื่อ-นามสกุล</th>
                                        <th class="text-center" >cid</th>
                                        <th class="text-center" >username</th> 
                                        <th class="text-center">type</th>  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($users as $item) 
                                    
                                        <tr id="tr_{{$item->id}}" >                                                  
                                            <td class="text-center" width="5%">{{ $i++ }}</td>    
                                            <td class="text-center" width="10%">
                                                <img src="{{ asset('storage/person/' . $item->img) }}" alt="70x70"
                                                class="img-thumbnail rounded-circle avatar-lg"  data-holder-rendered="true">
                                            </td> 
                                            {{-- <td class="text-center" width="5%"><a href="{{url('user_train_edit/'.$item->train_id)}}">{{ $item->train_book_no }} </a></td>   --}}
                                            <td class="p-2">
                                                <a href="{{url('main_staff_edit/'.$item->id)}}"> {{ $item->fname }} {{ $item->lname }} </a>
                                               
                                            </td>  
                                            <td class="text-center" width="10%">{{ $item->cid }}</td> 
                                            <td class="text-center" width="10%">{{ $item->username }}</td>  
                                            <td class="text-center" width="10%">{{ $item->type }} </td>   
                                        </tr>
                                 
                                    @endforeach
                                </tbody>
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
