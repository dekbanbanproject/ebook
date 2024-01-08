@extends('layouts.sso_admin')
@section('title', 'd-ebook || sso')
@section('content')
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

        .bar {
            height: 50px;
            background-color: rgb(10, 218, 55);
        }

        .percent {
            position: absolute;
            left: 50%;
            color: black;
        }

        .card {
            border-radius: 3em 3em 3em 3em;
            /* box-shadow: 0 0 10px teal; */
        }

        .card-ucs {
            border-radius: 3em 3em 3em 3em;
            box-shadow: 0 0 10px rgb(3, 136, 252);
        }

        .card-ofc {
            border-radius: 3em 3em 3em 3em;
            box-shadow: 0 0 10px rgb(10, 110, 223);
        }

        .card-lgo {
            border-radius: 3em 3em 3em 3em;
            box-shadow: 0 0 10px teal;
        }

        .card-ucsti {
            border-radius: 3em 3em 3em 3em;
            box-shadow: 0 0 10px rgb(252, 144, 3);
        }

        .card-ofcti {
            border-radius: 3em 3em 3em 3em;
            box-shadow: 0 0 10px rgb(252, 3, 82);
        }

        .card-sssti {
            border-radius: 3em 3em 3em 3em;
            box-shadow: 0 0 10px rgb(94, 93, 93);
        }

        .card-lgoti {
            border-radius: 3em 3em 3em 3em;
            box-shadow: 0 0 10px teal;
        }

        .nav {

            border-radius: 3em 3em 20 20;
            background-color: aliceblue;
            /* box-shadow: 0 0 10px teal; */
        }

        .nav-link {
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
                        <h4 class="mb-sm-0">Add Staff</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Add Staff</a></li>
                                <li class="breadcrumb-item active">Staff</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
        </div> <!-- container-fluid -->

        <form action="{{ route('a.main_staff_save') }}" method="POST" id="Add_staff" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xl-3">
                    <div class="card cardshadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <div class="mt-4 mb-4">

                                        {{-- @if ($dataedits->img == null) --}}
                                            <img class="img-thumbnail rounded-circle avatar-xl" alt="200x200" id="edit_upload_preview"
                                                src="{{ asset('assets/images/users/avatar-7.jpg') }}"
                                                data-holder-rendered="true">
                                        {{-- @else
                                            <img src="{{ asset('storage/person/' . $dataedits->img) }}"
                                                id="edit_upload_preview" alt="200x200"
                                                class="img-thumbnail rounded-circle avatar-xl"  data-holder-rendered="true">
                                        @endif --}}

                                    </div>
                                    <div class="mt-4 mb-2">
                                        <h4 class="mb-sm-0">Add Profile</h4>
                                    </div>
                                    <div class="mt-2 mt-md-0">
                                        <br>
                                        <div class="input-group mb-4 mt-2">
                                            <input type="file" class="form-control" id="img" name="img"
                                                onchange="editpic(this)">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="card cardshadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="mb-3">
                                        <label class="form-label" for="pname">คำนำหน้า :</label>
                                        <select id="pname" name="pname" class="form-control "
                                            style="width: 100%">
                                            {{-- <option value=""></option> --}}
                                            @foreach ($users_prefix as $pre)
                                                 
                                                    <option value="{{ $pre->prefix_id }}">{{ $pre->prefix_name }} </option>
                                           
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="fname">ชื่อ :</label>
                                        <input type="text" class="form-control form-control-sm" id="fname" name="fname">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="lname">นามสกุล :</label>
                                        <input type="text" class="form-control form-control-sm" id="lname" name="lname" >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="cid">บัตรประชาชน</label>
                                        <input type="text" class="form-control form-control-sm" id="cid" name="cid" >
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="position_id">ตำแหน่ง</label>
                                        <select id="position_id" name="position_id" class="form-control"
                                            style="width: 100%">
                                          
                                            @foreach ($position as $po)
                                             
                                                    <option value="{{ $po->POSITION_ID }}">{{ $po->POSITION_NAME }} </option>
                                              
                                            @endforeach
                                        </select>
                                       
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="username">ชื่อผู้ใช้งาน</label>
                                        <input type="text" class="form-control form-control-sm" id="username" name="username">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="password">Password</label>
                                        <input type="password" class="form-control form-control-sm" id="password"
                                            name="password" required>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="line_token">Line Token</label>
                                        <input type="text" name="line_token" id="line_token" class="form-control form-control-sm">
                                        {{-- <textarea id="line_token" name="line_token" class="form-control" rows="2">{{ $dataedits->line_token }}</textarea> --}}
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="hn_id">หัวหน้า</label>
                                        <select id="hn_id" name="hn_id" class="form-control" style="width: 100%"> 
                                            @foreach ($users as $hn)
                                               
                                                    <option value="{{ $hn->id }}">{{ $hn->fname }} {{ $hn->lname }} </option>
                                          
                                            @endforeach
                                        </select>                                       
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="po_id">ผอ.</label>
                                        <select id="po_id" name="po_id" class="form-control"
                                            style="width: 100%"> 
                                            @foreach ($users as $po)
                                              
                                                    <option value="{{ $po->id }}">{{ $po->fname }} {{ $po->lname }} </option>
                                             
                                            @endforeach
                                        </select>                                       
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="sso_id">สสอ.</label>
                                        <select id="sso_id" name="sso_id" class="form-control"
                                            style="width: 100%"> 
                                            @foreach ($users as $sso)
                                               
                                                    <option value="{{ $sso->id }}">{{ $sso->fname }} {{ $sso->lname }} </option>
                                              
                                            @endforeach
                                        </select>                                       
                                    </div>
                                </div>
                            </div>
                      
                           

                        <div class="row">
                                <div class="col"></div>
                                <div class="col-md-3">
                                    <button type="submit" class="ladda-button btn-pill btn btn-primary d-shadow me-2">
                                        <span class="ladda-label"><i class="fa-solid fa-floppy-disk text-white me-2"></i> Save </span>
                                        <span class="ladda-spinner"></span> 
                                    </button>
                                    <a href="{{ url('main_staff') }}" class="ladda-button btn-pill btn btn-danger d-shadow">
                                        <i class="fa-solid fa-xmark me-2"></i>
                                        Cancel
                                    </a>
                                </div>
                                <div class="col"></div>
                        </div>
                             
                        </div>
                    </div>
                </div>
                <div class="col"></div>
            </div>
        </form>


    </div>



@endsection
@section('footer')
<script>
   
</script>
    <script>
        $(document).ready(function() {
                    $('#example').DataTable();
                    $('#example2').DataTable();
                    $('#pname').select2({
                        placeholder: "--เลือก--",
                        allowClear: true
                    });
                    $('#position_id').select2({
                        placeholder: "--เลือก--",
                        allowClear: true
                    });
                    $('#hn_id').select2({
                        placeholder: "--เลือก--",
                        allowClear: true
                    });
                    $('#po_id').select2({
                        placeholder: "--เลือก--",
                        allowClear: true
                    });
                    $('#sso_id').select2({
                        placeholder: "--เลือก--",
                        allowClear: true
                    });

                    $('#datepicker').datepicker({
                        format: 'yyyy-mm-dd'
                    });
                    $('#datepicker2').datepicker({
                        format: 'yyyy-mm-dd'
                    });
                    $('#stamp').on('click', function(e) {
                        if ($(this).is(':checked', true)) {
                            $(".sub_chk").prop('checked', true);
                        } else {
                            $(".sub_chk").prop('checked', false);
                        }
                    });

                    $('#Add_staff').on('submit', function(e) {
                        e.preventDefault();
                        //   alert('Person');
                        var form = this;

                        $.ajax({
                            url: $(form).attr('action'),
                            method: $(form).attr('method'),
                            data: new FormData(form),
                            processData: false,
                            dataType: 'json',
                            contentType: false,
                            beforeSend: function() {
                                $(form).find('span.error-text').text('');
                            },
                            success: function(data) {
                                if (data.status == 100) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Username...!!',
                                        text: 'Username นี้ได้ถูกใช้ไปแล้ว!',
                                    }).then((result) => {
                                        if (result.isConfirmed) {

                                        }
                                    })
                                } else {
                                    Swal.fire({
                                        title: 'เพิ่มข้อมูลสำเร็จ',
                                        text: "You Insert data success",
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
