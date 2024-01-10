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
     
    function editpic(input) {
        var fileInput = document.getElementById('img');
        var url = input.value;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#edit_upload_preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
            fileInput.value = '';
            return false;
        }
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
                <h4 class="mb-sm-0">Main Ebook Hospital</h4>
            </div>
            <div class="col"></div>
            <div class="col-md-3 text-end">
                {{-- <a href="{{url('main_staff_add')}}" class="ladda-button btn-pill btn btn-primary d-shadow me-2" target="_blank">
                    <span class="ladda-label"><i class="fa-solid fa-user-group text-white me-2"></i> Add Staff </span>
                    <span class="ladda-spinner"></span> 
                </a>                 --}}
            </div> 
        </div> 
    </div> 
    <!-- container-fluid -->
 
 
    <div class="row mt-3">
        <div class="col-xl-12">
            <div class="card cardshadow">
                <div class="card-body">  
                    <form action="{{route('u.main_hospital_update')}}" method="POST" id="update_infoorgForm" enctype="multipart/form-data">                 
                        @csrf        
                        <input id="orginfo_id" type="hidden" class="form-control" name="orginfo_id" value="{{ $orginfo->orginfo_id}}" >

                    <div class="row">
                        <div class="col-md-3"> 
                            <div class="form-group"> 
                                @if ( $orginfo->orginfo_img == Null )
                                <img src="{{asset('assets/images/default-image.jpg')}}" id="edit_upload_preview" height="550px" width="350px" alt="Image" class="img-thumbnail">
                                @else
                                <img src="{{asset('storage/org/'.$orginfo->orginfo_img)}}" id="edit_upload_preview" height="550px" width="350px" alt="Image" class="img-thumbnail">                                 
                                @endif
                                <br>
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="img"></label>
                                    <input type="file" class="form-control" id="orginfo_img" name="orginfo_img"
                                        onchange="editpic(this)">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9"> 
                            <div class="row mt-3">                                
                                <div class="col-md-2 text-end">
                                    <label for="orginfo_name">ชื่อโรงพยาบาล :</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <input id="orginfo_name" type="text"
                                            class="form-control" name="orginfo_name" value="{{ $orginfo->orginfo_name}}" >
                                    </div>
                                </div> 
                                
                                <div class="col-md-2 text-end">
                                    <label for="orginfo_code">รหัสโรงพยาบาล :</label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input id="orginfo_code" type="text"
                                            class="form-control" name="orginfo_code"  value="{{ $orginfo->orginfo_code}}">
                                    </div>
                                </div> 
                            </div>
                            <div class="row mt-3">                                
                                <div class="col-md-2 text-end">
                                    <label for="orginfo_address">ที่อยู่ :</label>
                                </div>
                                <div class="col-md-10"> 
                                    <div class="form-floating">
                                        <textarea class="form-control" id="orginfo_address" name="orginfo_address">{{ $orginfo->orginfo_address}}</textarea>
                                      <!-- <label for="orginfo_address">ที่อยู่</label> -->
                                      </div>
                                </div>                                
                            </div>
                            <div class="row mt-3">                                
                                <div class="col-md-2 text-end">
                                    <label for="orginfo_email">อีเมล์ :</label>
                                </div>
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <input id="orginfo_email" type="text"
                                        class="form-control" name="orginfo_email"  value="{{ $orginfo->orginfo_email}}">
                                      </div>
                                </div>        
                                <div class="col-md-2 text-end">
                                    <label for="orginfo_tel">Tel :</label>
                                </div>
                                <div class="col-md-2"> 
                                    <div class="form-group">
                                        <input id="orginfo_tel" type="text"
                                        class="form-control" name="orginfo_tel"  value="{{ $orginfo->orginfo_tel}}">
                                      </div>
                                </div>                        
                            </div>
                            <div class="row mt-3">                                
                                <div class="col-md-2 text-end">
                                    <label for="orginfo_link">Link :</label>
                                </div>
                                <div class="col-md-10"> 
                                    <div class="form-group">
                                        <input id="orginfo_link" type="text"
                                        class="form-control" name="orginfo_link"  value="{{ $orginfo->orginfo_link}}">
                                      </div>
                                </div>                                
                            </div>
                            <div class="row mt-3">                                
                                <div class="col-md-2 text-end">
                                    <label for="orginfo_manage_id">หัวหน้าบริหาร :</label>
                                </div>
                                <div class="col-md-4"> 
                                    <div class="form-group">                                        
                                        <select id="orginfo_manage_id" name="orginfo_manage_id" class="form-control form-control-lg" style="width: 100%">
                                            <option value=""></option>
                                                @foreach ($users as $item1 )  
                                                @if ($orginfo->orginfo_manage_id == $item1->id)
                                                <option value="{{ $item1->id}}" selected>{{ $item1->fname}}  {{ $item1->lname}}</option> 
                                                @else
                                                <option value="{{ $item1->id}}">{{ $item1->fname}}  {{ $item1->lname}}</option> 
                                                @endif                                      
                                                                                                                      
                                                @endforeach 
                                        </select>
                                      </div>
                                </div> 
                                <div class="col-md-2 text-end">
                                    <label for="orginfo_po_id">ผู้อำนวยการ :</label>
                                </div>
                                <div class="col-md-4"> 
                                    <div class="form-group">                                        
                                        <select id="orginfo_po_id" name="orginfo_po_id" class="form-control form-control-lg" style="width: 100%">
                                            <option value=""></option>
                                                @foreach ($users as $item2 ) 
                                                @if ($orginfo->orginfo_po_id == $item2->id)
                                                <option value="{{ $item2->id}}" selected>{{ $item2->fname}}  {{ $item2->lname}}</option>    
                                                @else
                                                <option value="{{ $item2->id}}">{{ $item2->fname}}  {{ $item2->lname}}</option>    
                                                @endif                                       
                                                                                                                   
                                                @endforeach 
                                        </select>
                                      </div>
                                </div> 
                            </div>
                            {{-- <div class="card-footer mt-3"> --}}
                                <div class="col-md-12 mt-4 text-end"> 
                                    <div class="form-group">
                                        {{-- <button type="submit" class="btn btn-primary btn-sm">
                                            บันทึกข้อมูล
                                        </button>   --}}
                                        <button type="submit" class="ladda-button btn-pill btn btn-primary d-shadow me-2">
                                            <span class="ladda-label"><i class="fa-solid fa-floppy-disk text-white me-2"></i> Update </span>
                                            <span class="ladda-spinner"></span> 
                                        </button>
                                        <a href="{{ url('main_hospital_all') }}" class="ladda-button btn-pill btn btn-danger d-shadow">
                                            <i class="fa-solid fa-xmark me-2"></i>
                                            Cancel
                                        </a> 
                                    </div>                   
                                </div>   
                            {{-- </div> --}}
                           

                        </div>
                    </div>
                    
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
        $('#position_id').select2({
            placeholder: "--เลือก--",
            allowClear: true
        });
        $('#orginfo_manage_id').select2({
            placeholder: "--เลือก--",
            allowClear: true
        });
        $('#orginfo_po_id').select2({
            placeholder: "--เลือก--",
            allowClear: true
        });
        $('#sso_id').select2({
            placeholder: "--เลือก--",
            allowClear: true
        });

        $('#stamp').on('click', function(e) {
        if($(this).is(':checked',true))  
        {
            $(".sub_chk").prop('checked', true);  
        } else {  
            $(".sub_chk").prop('checked',false);  
        }  
        }); 
        $('#update_infoorgForm').on('submit',function(e){
                  e.preventDefault();            
                  var form = this; 
                  $.ajax({
                        url:$(form).attr('action'),
                        method:$(form).attr('method'),
                        data:new FormData(form),
                        processData:false,
                        dataType:'json',
                        contentType:false,
                        beforeSend:function(){
                          $(form).find('span.error-text').text('');
                        },
                        success:function(data){
                          if (data.status == 0 ) {
                            
                          } else {          
                            Swal.fire({
                              title: 'แก้ไขข้อมูลสำเร็จ',
                              text: "You Update data success",
                              icon: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#06D177', 
                              confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                              if (result.isConfirmed) {                  
                                window.location.reload(); 
                              }
                            })      
                          }
                        }
                  });
            });
    }); 
</script>
@endsection
