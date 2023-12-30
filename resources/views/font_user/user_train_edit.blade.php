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
    $hnid = Auth::user()->hn_id;
} else {
    echo "<body onload=\"TypeAdmin()\"></body>";
    exit();
}
$url = Request::url();
$pos = strrpos($url, '/') + 1;
$ynow = date('Y') + 543;
$yb = date('Y') + 542;
$datenow = date('Y-m-d');
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
                transform: rotate(390deg);
            }
        }

        .is-hide {
            display: none;
        }

        .modal-dialog {
            max-width: 50%;
        }

        .modal-dialog-slideout {
            min-height: 100%;
            margin:auto 0 0 0 ;   /*  ซ้าย ขวา */
            background: #fff;
        }

        .modal.fade .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(100%, 0)scale(30);
            transform: translate(100%, 0)scale(5);
        }

        .modal.fade.show .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(0, 0);
            transform: translate(0, 0);
            display: flex;
            align-items: stretch;
            -webkit-box-align: stretch;
            height: 100%;
        }

        .modal.fade.show .modal-dialog.modal-dialog-slideout .modal-body {
            overflow-y: auto;
            overflow-x: hidden;

            /* overflow-y: hidden;
            overflow-x: auto; */
        }

        .modal-dialog-slideout .modal-content {
            border: 0;
        }

        .modal-dialog-slideout .modal-header,
        .modal-dialog-slideout .modal-footer {
            height: 4rem;
            display: block;
        }

        .datepicker {
            z-index: 2051 !important;
        }
        .dcheck{         
            width: 30px;
            height: 30px;       
            /* border-radius: 2em 2em 2em 2em; */
            /* border: 10px solid teal; */
            /* color: teal; */
            /* border-color: teal; */
            box-shadow: 0 0 10px teal;
            /* box-shadow: 0 0 10px teal; */
        }
        /* .form-label{ */
            /* font-family: sans-serif; */
            /* font-size: 13px; */
        /* } */
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
                    <h4 class="mb-sm-0">ประชุม/อบรม/ดูงาน</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">ประชุม/อบรม/ดูงาน</a></li>
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
                    <p class="mb-0">
                        <div class="row">
                            {{-- <div class="col-md-9"> 
                                <div class="mb-3">
                                    <label class="form-label" for="train_book_advert" >หนังสืออ้างอิง :</label>
                                    <input type="text" class="form-control form-control-sm" id="train_book_advert" name="train_book_advert" >
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-3 mt-4">  
                                    <button type="button" class="ladda-button btn-pill btn btn-primary d-shadow" data-bs-toggle="modal" data-bs-target="#MyModal" data-bs-toggle="tooltip" data-bs-placement="right" title="ขอไปราชการ"> 
                                        <i class="fas fa-book-reader me-2"></i> 
                                        หนังสืออ้างอิง
                                    </button> 
                            </div> --}}
                        </div>

                        <div class="row">
                            <div class="col-md-2">  
                                <label class="form-label" for="train_book_advert" >หนังสืออ้างอิง </label> 
                            </div>
                            <div class="col-md-2">   
                                <input type="text" class="form-control form-control-sm" id="train_book_advert" name="train_book_advert" value="{{$dataedits->train_book_advert}}"> 
                            </div>
                            <div class="col-md-2"> 
                                    <label class="form-label" for="train_book_no" >เลขที่หนังสือ </label> 
                            </div> 
                            <div class="col-md-2">  
                                <input type="text" class="form-control form-control-sm" id="train_book_no" name="train_book_no" value="{{$dataedits->train_book_no}}"> 
                            </div> 
                           
                            <div class="col-md-2"> 
                                <label class="form-label" for="train_date_go" >วันที่ไป </label> 
                            </div> 
                            <div class="col-md-2">  
                                <input type="text" id="train_date_go" class="form-control form-control-sm" data-toggle="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-provide="datepicker" data-date-language="th-th" autocomplete="off" value="{{$dataedits->train_date_go}}"> 
                            </div> 
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2"> 
                                <label class="form-label" for="train_title" >เรื่อง </label> 
                            </div> 
                            <div class="col-md-6">  
                                <input type="text" class="form-control form-control-sm" id="train_title" name="train_title" value="{{$dataedits->train_title}}">
                            </div> 
                           
                            <div class="col-md-2"> 
                                <label class="form-label" for="train_date_back" >วันที่กลับ </label> 
                            </div> 
                            <div class="col-md-2">  
                                <input type="text" id="train_date_back" class="form-control form-control-sm" data-toggle="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-provide="datepicker" data-date-language="th-th" autocomplete="off" value="{{$dataedits->train_date_back}}">
                            </div> 
                          
                        </div>


                        <div class="row mt-2">
                            <div class="col-md-2"> 
                                <label class="form-label" for="train_detail" >รายละเอียด </label> 
                            </div> 
                            <div class="col-md-6">  
                                <input type="text" class="form-control form-control-sm" id="train_detail" name="train_detail" value="{{$dataedits->train_detail}}">                                 
                            </div>
                            <div class="col-md-2"> 
                                    <label class="form-label" for="train_assign_work" >มอบหมายงานให้ </label> 
                            </div> 
                            <div class="col-md-2">   
                                <select id="train_assign_work" name="train_assign_work" class="form-control" style="width: 100%"> 
                                    @foreach ($users as $hn) 
                                    @if ($dataedits->train_assign_work == $hn->id)
                                    <option value="{{ $hn->id }}" selected>{{ $hn->fname }} {{ $hn->lname }} </option> 
                                    @else
                                    <option value="{{ $hn->id }}">{{ $hn->fname }} {{ $hn->lname }} </option> 
                                    @endif
                                           
                                    @endforeach
                                </select> 
                            </div> 
                          
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-md-2"> 
                                    <label class="form-label" for="train_detail" >ยานพาหนะ</label> 
                            </div> 
                            <div class="col-md-2">  
                                <input type="text" class="form-control form-control-sm" id="train_vehicle" name="train_vehicle" value="{{$dataedits->train_vehicle}}">                          
                            </div>
                            <div class="col-md-2"> 
                                <label class="form-label" for="train_vehicle_pai" >ทะเบียน </label> 
                            </div> 
                            <div class="col-md-2">  
                                <input type="text" class="form-control form-control-sm" id="train_vehicle_pai" name="train_vehicle_pai" value="{{$dataedits->train_vehicle_pai}}">                          
                            </div>
                              <div class="col-md-2"> 
                                <label class="form-label" for="train_head" >หัวหน้า </label> 
                            </div> 
                            <div class="col-md-2">                                
                                <select id="train_head" name="train_head" class="form-control" style="width: 100%"> 
                                    @foreach ($users as $hn)
                                        @if ($hnid == $hn->id)
                                            <option value="{{ $hn->id }}" selected> {{ $hn->fname }} {{ $hn->lname }} </option>
                                        @else
                                            <option value="{{ $hn->id }}">{{ $hn->fname }} {{ $hn->lname }} </option>
                                        @endif
                                    @endforeach
                                </select>                              
                            </div> 
                          
                        </div>
 
                        <div class="row mt-2">
                          <div class="col-md-2"> 
                                <label class="form-label" for="train_locate" >สถานที่จัด </label> 
                            </div> 
                            <div class="col-md-6">   
                                <select id="train_locate" name="train_locate" class="form-control show_location" style="width: 100%"> 
                                    @foreach ($train_location as $trainlocation) 
                                    @if ($dataedits->train_locate == $trainlocation->train_location_id)
                                    <option value="{{ $trainlocation->train_location_id }}" selected>{{ $trainlocation->train_location_name }}</option> 
                                    @else
                                    <option value="{{ $trainlocation->train_location_id }}">{{ $trainlocation->train_location_name }}</option> 
                                    @endif
                                            
                                    @endforeach
                                </select> 
                            </div> 
                            
                            <div class="col-md-3"> 
                                <input type="text" class="form-control form-control-sm" id="TRAN_LOCATION" name="TRAN_LOCATION" style="font-size: 13px;" placeholder="ถ้าไม่มีให้เพิ่ม"> 
                            </div> 
                            <div class="col-md-1">  
                                <button type="button" class="ladda-button btn-pill btn btn-primary d-shadow" onclick="addlocation();">  
                                    <i class="fas fa-plus"></i> 
                                </button>  
                            </div>
                         
                        </div>
                        <div class="row mt-2">  
                            <div class="col-md-2">
                                <label class="form-label" for="signature" >Signature </label> 
                            </div> 
                            <div class="col-md-4">
                                <h3 class="mt-1 text-center">Digital Signature</h3>
                                <div id="signature-pad" class="mt-3 text-center">
                                    <div style="border:solid 1px teal;height:130px;width:340px;">
                                        <div id="note" onmouseover="my_function();" class="text-center">The
                                            signature should be inside box</div>
                                        <canvas id="the_canvas" width="340px" height="130px"></canvas>
                                    </div>

                                    <input type="hidden" id="train_id" name="train_id" value="{{$dataedits->train_id}}">
                                    <input type="hidden" id="signature" name="signature">
                                    <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}">
                                    <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">

                                    <button type="button" id="clear_btn"
                                        class="btn btn-secondary d-shadow btn-sm mt-2" data-action="clear"><span
                                            class="glyphicon glyphicon-remove"></span>
                                        Clear
                                    </button>
                                    <button type="button" id="save_btn"
                                        class="btn btn-info d-shadow btn-sm mt-2 text-white" data-action="save-png"
                                        onclick="create();"><span class="glyphicon glyphicon-ok"></span>
                                        Create
                                    </button> 
                                    <button type="button" id="UpdateBtn" class="ladda-button btn-pill btn btn-success d-shadow btn-sm mt-2">
                                        <i class="fa-solid fa-circle-check text-white"></i>
                                        แก้ไขข้อมูล
                                    </button>
                                    <a href="{{ url('user_train') }}" class="ladda-button btn-pill btn btn-danger d-shadow btn-sm mt-2">
                                        <i class="fa-solid fa-xmark"></i>
                                        ปิด
                                    </a>
                                </div>
                            </div> 
                            <div class="col-md-2 mt-5">
                                <img src="data:image/png;base64,{{$signature}}" alt=""> 
                            </div>
                           
                        </div>  
                        
                    </p>
                </div>
            </div>
        </div>
    </div> 
</div>

 
 
 
@endsection
@section('footer')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script src="{{ asset('js/gcpdfviewer.js') }}"></script>
<script>
    var wrapper = document.getElementById("signature-pad");
    var clearButton = wrapper.querySelector("[data-action=clear]");
    var savePNGButton = wrapper.querySelector("[data-action=save-png]");
    var canvas = wrapper.querySelector("canvas");
    var el_note = document.getElementById("note");
    var signaturePad;
    signaturePad = new SignaturePad(canvas);
    clearButton.addEventListener("click", function(event) {
        document.getElementById("note").innerHTML = "The signature should be inside box";
        signaturePad.clear();
    });
    savePNGButton.addEventListener("click", function(event) {
        if (signaturePad.isEmpty()) {
            // alert("Please provide signature first.");
            Swal.fire(
                'กรุณาลงลายเซนต์ก่อน !',
                'You clicked the button !',
                'warning'
            )
            event.preventDefault();
        } else {
            var canvas = document.getElementById("the_canvas");
            var dataUrl = canvas.toDataURL();
            document.getElementById("signature").value = dataUrl;

            // ข้อความแจ้ง
            Swal.fire({
                title: 'สร้างสำเร็จ',
                text: "You create success",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#06D177',
                confirmButtonText: 'เรียบร้อย'
            }).then((result) => {
                if (result.isConfirmed) {}
            })
        }
    });

    function my_function() {
        document.getElementById("note").innerHTML = "";
    }
    function addlocation() {
            var location_name = document.getElementById("TRAN_LOCATION").value;
            // alert(location_name);
        
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{route('u.addlocation')}}",
                method: "GET",
                data: {
                location_name: location_name,
                    _token: _token
                },
                success: function (result) {
                    $('.show_location').html(result);
                }
            })
        }
</script>
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
        $('[data-toggle="datepicker"]').datepicker({ 
                autoHide: true,
                zIndex: 2048,
        });
        $('select').select2();
        $('#ECLAIM_STATUS').select2({
            dropdownParent: $('#detailclaim')
        });
                 
        // Insertdata
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#UpdateBtn').click(function() {
            var train_book_advert      = $('#train_book_advert').val();
            var train_book_no          = $('#train_book_no').val();
            var train_date_go          = $('#train_date_go').val();
            var train_date_back        = $('#train_date_back').val();
            var train_title            = $('#train_title').val();
            var train_detail           = $('#train_detail').val();
            var train_assign_work      = $('#train_assign_work').val();
            var train_vehicle          = $('#train_vehicle').val();
            var train_vehicle_pai      = $('#train_vehicle_pai').val();
            var train_head             = $('#train_head').val(); 
            var train_locate           = $('#train_locate').val();
            var train_id               = $('#train_id').val();
            // var train_expenses_out = $('#train_expenses_out').val(); 
            var signature             = $('#signature').val();
            var user_id               = $('#user_id').val();
            $.ajax({
                url: "{{ route('u.user_train_update') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    train_book_advert, train_book_no, train_date_go,train_vehicle_pai,
                    train_date_back, train_title, train_detail,signature,user_id,
                    train_assign_work, train_vehicle,train_head,train_locate,train_id
                },
                // train_expenses,train_expenses_out,
                success: function(data) {
                    if (data.status == 200) {
                        Swal.fire({
                            title: 'แก้ไขข้อมูลสำเร็จ',
                            text: "You Insert data success",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#06D177',
                            confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                            if (result
                                .isConfirmed) {
                                console.log(
                                    data);

                                window.location
                                    .reload();
                            }
                        })
                    } else if (data.status == 50) {
                        Swal.fire(
                            'กรุณาลงลายชื่อ !',
                            'You clicked the button !',
                            'warning'
                        )
                    } else {

                    }

                },
            });
        });

        
      
    }); 
</script>
@endsection
