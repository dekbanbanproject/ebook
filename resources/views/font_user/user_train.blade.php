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

        <form action="{{ url('user_train') }}" method="GET">
            @csrf
        <div class="row">  
            <div class="col-md-3 text-start">
                {{-- <button type="button" class="ladda-button btn-pill btn btn-primary d-shadow" data-bs-toggle="modal" data-bs-target="#MyModal" data-bs-toggle="tooltip" data-bs-placement="right" title="ขอไปราชการ"> 
                    <i class="fas fa-book-reader me-2"></i> 
                    ยื่นเรื่อง
                </button> --}}
                <a href="{{url('user_train_add')}}" class="ladda-button btn-pill btn btn-primary d-shadow" data-bs-toggle="tooltip" data-bs-placement="right" title="ยื่นเรื่องขอไปราชการ"> 
                    <i class="fas fa-book-reader me-2"></i> 
                    ยื่นเรื่องขอไปราชการ
                </a>
            </div>
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
                                        {{-- <th class="text-center">หน่วยงานที่จัด</th>  --}}
                                        <th class="text-center">วันที่ไป</th>  
                                        <th class="text-center">ถึงวันที่</th> 
                                        {{-- <th class="text-center">พาหนะ</th> --}}
                                        {{-- <th class="text-center">หัวหน้า</th>   --}}
                                        <th class="text-center">มอบหมายงายนให้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($train as $item) 
                                    
                                        <tr id="tr_{{$item->train_id}}" >                                                  
                                            <td class="text-center" width="5%">{{ $i++ }}</td>    
                                            <td class="text-center" width="5%">{{ $item->train_book_advert }}</td> 
                                            <td class="text-center" width="5%"><a href="{{url('user_train_edit/'.$item->train_id)}}">{{ $item->train_book_no }} </a></td>  
                                            <td class="p-2">{{ $item->train_title }}</td>  
                                            <td class="text-center" width="8%">{{ $item->train_date_go }}</td> 
                                            <td class="text-center" width="8%">{{ $item->train_date_back }}</td> 
                                            {{-- <td class="text-center" width="10%">{{ $item->train_vehicle }}</td>  --}}
                                            <td class="text-center" width="10%">{{ $item->fname }} {{ $item->lname }}</td>   
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


<div class="modal fade" id="MyModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true"> 
    <div class="modal-dialog modal-dialog-slideout">
    <div class="modal-content">
        <div class="modal-header">
            <div class="row"> 
                <div class="col-md-8">
                    <h5 class="modal-title" id="InsertModalLabel">ยื่นเรื่อง</h5>
                </div>
                <div class="col-md-4 text-end">
                    <div class="form-group">
                        <button type="button" id="SaveBtn" class="btn-icon btn-shadow btn-dashed btn btn-outline-info me-2"> 
                            <i class="pe-7s-diskette btn-icon-wrapper me-2"></i> Save
                        </button>
                        <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-danger" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark me-2"></i>Close
                        </button> 
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-body">
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
                <div class="col-md-3"> 
                    <div class="mb-3">
                        <label class="form-label" for="train_book_advert" >หนังสืออ้างอิง :</label>
                        <input type="text" class="form-control form-control-sm" id="train_book_advert" name="train_book_advert" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label" for="train_book_no" >เลขที่หนังสือ :</label>
                        <input type="text" class="form-control form-control-sm" id="train_book_no" name="train_book_no" >
                    </div>
                </div> 
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label" for="train_date_go" >วันที่ไป :</label> 
                        <div class="input-group input-group-sm">  
                            <input type="text" id="train_date_go" class="form-control" data-toggle="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-provide="datepicker" data-date-language="th-th" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label" for="train_date_back" >วันที่กลับ :</label> 
                        <div class="input-group input-group-sm">  
                            <input type="text" id="train_date_back" class="form-control" data-toggle="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-provide="datepicker" data-date-language="th-th" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label" for="train_book_no" >เรื่อง :</label>
                        <input type="text" class="form-control form-control-sm" id="train_title" name="train_title" >
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label" for="train_detail" >รายละเอียด :</label>
                        <textarea class="form-control form-control-sm" rows="3" id="train_detail" name="train_detail"></textarea>
                        
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label" for="train_locate" >สถานที่จัด :</label> 
                        <input type="text" class="form-control form-control-sm" id="train_locate" name="train_locate" >
                    </div>
                </div> 
                 
            </div>  
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label" for="train_assign_work" >มอบหมายงานให้ :</label> 
                        <select id="train_assign_work" name="train_assign_work" class="form-control" style="width: 100%"> 
                            @foreach ($users as $hn) 
                                    <option value="{{ $hn->id }}">{{ $hn->fname }} {{ $hn->lname }} </option> 
                            @endforeach
                        </select>
                    </div>
                </div> 
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label" for="train_vehicle" >ยานพาหนะที่ใช้ :</label> 
                        <div class="input-group input-group-sm">  
                            <input type="text" class="form-control form-control-sm" id="train_vehicle" name="train_vehicle" >
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label" for="train_head" >หัวหน้า :</label> 
                        <div class="input-group input-group-sm">   
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
                </div>
            </div>
            <div class="row"> 
                <div class="col"></div>
                <div class="col-md-4">
                    {{-- <div class="mb-3">
                        <input class="form-check-input dcheck me-2" type="radio" name="train_expenses" id="train_expenses" checked>
                        <label class="form-check-label mt-2" for="train_expenses">
                            เบิกค่าใช้จ่าย
                        </label>
                        <input class="form-check-input dcheck me-2" type="radio" name="train_expenses" id="train_expenses2">
                        <label class="form-check-label mt-2" for="train_expenses2">
                            ไม่เบิกค่าใช้จ่าย
                        </label>
                        
                    </div> --}}
                </div> 
                {{-- <div class="col-md-4">
                    <div class="mb-3"> 
                        <input class="form-check-input dcheck me-2" type="radio" name="train_expenses_out" id="train_expenses_out" >
                        <label class="form-check-label mt-2" for="train_expenses_out">
                            เบิกค่าใช้จ่ายจากผู้จัด
                        </label>
                        <input class="form-check-input dcheck me-2" type="radio" name="train_expenses_out" id="train_expenses_out2">
                        <label class="form-check-label mt-2" for="train_expenses_out2">
                            ไม่เบิกค่าใช้จ่ายจากผู้จัด
                        </label>
                    </div>
                </div>  --}}
                {{-- <div class="col-md-4">
                    <div class="mb-3"> 
                        <input class="form-check-input dcheck me-2" type="radio" name="train_expenses_n" id="train_expenses" value="N">
                        <label class="form-check-label mt-2" for="train_expenses_n">
                            ไม่เบิกค่าใช้จ่าย
                        </label>
                    </div>
                </div>  --}}
                <div class="col"></div>
            </div>  
        </div>
        <div class="modal-footer">
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
        $('[data-toggle="datepicker"]').datepicker({ 
                autoHide: true,
                zIndex: 2048,
        });
        $('#train_head').select2({
            dropdownParent: $('#MyModal')
        });
        $('#train_assign_work').select2({
            dropdownParent: $('#MyModal')
        });
        
        // Insertdata
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#SaveBtn').click(function() {
                var train_book_advert = $('#train_book_advert').val();
                var train_book_no = $('#train_book_no').val();
                var train_date_go = $('#train_date_go').val();
                var train_date_back = $('#train_date_back').val();
                var train_title = $('#train_title').val();
                var train_detail = $('#train_detail').val();
                var train_assign_work = $('#train_assign_work').val();
                var train_vehicle = $('#train_vehicle').val();
                var train_head = $('#train_head').val();
                var train_locate = $('#train_locate').val();
                var train_expenses = $('#train_expenses').val();
                var train_expenses_out = $('#train_expenses_out').val();
                // var train_expenses_n = $('#train_expenses_n').val();
                // alert(train_expenses);
                $.ajax({
                    url: "{{ route('u.user_train_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        train_book_advert, train_book_no, train_date_go,
                        train_date_back, train_title, train_detail,train_expenses,train_expenses_out,
                        train_assign_work, train_vehicle,train_head,train_locate
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'เพิ่มข้อมูลสำเร็จ',
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
                        } else {

                        }

                    },
                });
            });
      
    }); 
</script>
@endsection
