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
 

    <div class="row">
        <div class="col-xl-12">
            <div class="card cardshadow">
                <div class="card-body">  
                  252555555555555555555
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