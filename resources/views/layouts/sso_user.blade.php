<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300&family=Srisakdi&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('dis/images/logo150.ico') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300&display=swap" rel="stylesheet">

    {{-- <link href="{{ asset('dis/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"> --}}
    <link href="{{ asset('dis/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dis/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('dis/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">

    <!-- jquery.vectormap css -->
    <link href="{{ asset('dis/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{ asset('dis/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('dis/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('dis/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('dis/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('dis/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('dis/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('dis/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
    <!-- select2 -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/select2/css/select2.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('select2/css/select2.min.css') }}"> 

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet"
        href="{{ asset('disacc/vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css') }}">
    {{-- <link href="{{ asset('acccph/styles/css/base.css') }}" rel="stylesheet"> --}}

    <link rel="stylesheet" href="{{ asset('disacc/vendors/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('disacc/vendors/ionicons-npm/css/ionicons.css') }}">
    <link rel="stylesheet" href="{{ asset('disacc/vendors/linearicons-master/dist/web-font/style.css') }}">
    <link rel="stylesheet"
        href="{{ asset('disacc/vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css') }}">
    {{-- <link href="{{ asset('disacc/styles/css/base.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('css/dcss.css') }}">
</head>
<style>
    body {
        font-size: 13px;
        background-color: rgb(245, 240, 240);
        background-repeat: no-repeat;
        background-attachment: fixed;
        /* background-size: cover; */
        background-size: 100% 100%;
        /* display: flex; */
        /* align-items: center; */
        /* justify-content: center; */
        /* width: 100vw;   ให้เต็มพอดี */
        /* height: 100vh; ให้เต็มพอดี  */
    }

    /* .Bgsidebar {
        background-image: url('/pkbackoffice/public/images/bgside.jpg');
        background-repeat: no-repeat;
    }

    .Bgheader {
        background-image: url('/pkbackoffice/public/images/bgheader.jpg');
        background-repeat: no-repeat;
    } */
</style>


<body data-sidebar="white" data-keep-enlarged="true" class="vertical-collpsed">
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
        use App\Http\Controllers\StaticController;
        $checkhn    = StaticController::checkhn($iduser);
        $checkpo    = StaticController::checkpo($iduser);  
        $checksso   = StaticController::checksso($iduser); 
    ?>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header" style="background-color: rgba(13, 160, 123, 0.884)">

                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box" style="background-color: rgb(255, 255, 255)">
                        <a href="" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset('dis/images/logo150.png') }}" alt="logo-sm" height="37">
                            </span>
                            <span class="logo-lg">
                                {{-- <img src="{{ asset('dis/images/logo150.png') }}" alt="logo-dark" height="20"> --}}
                                <h4 style="color:rgba(23, 189, 147, 0.74)" class="mt-4">U-Ebook</h4>
                            </span>
                        </a>

                        <a href="" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('dis/images/logo150.png') }}" alt="logo-sm-light"
                                    height="40">
                            </span>
                            <span class="logo-lg">
                                <h4 style="color:rgba(23, 189, 147, 0.74)" class="mt-4">U-Ebook</h4>
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="ri-menu-2-line align-middle" style="color: rgb(255, 255, 255)"></i>
                    </button>
                    <a href="{{ url('/') }}">
                        <h4 style="color:rgb(255, 255, 255)" class="mt-4">U-Ebook</h4>
                    </a>
 
                </div>

                <div class="d-flex">
                    <div class="dropdown d-none d-lg-inline-block ms-1">

                        {{-- @if ($checkpo != 0)
                        <a href="{{url("user_train_hn")}}" target="_blank">
                            <i class="fa-solid fa-user-group text-warning ms-4 me-2" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="ผอ."></i>
                          </a>
                          @endif --}}

                          {{-- @if ($checksso != 0)
                          <a href="{{url("user_train_sso")}}" target="_blank">
                            <i class="fa-solid fa-user-group text-danger ms-4 me-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="สสอ."></i>
                          </a>
                          @endif --}}

                        <button type="button" class="btn header-item noti-icon waves-effect"
                            data-toggle="fullscreen">
                            <i class="ri-fullscreen-line" style="color: rgb(54, 53, 53)"></i>
                        </button>
                    </div>
                    <div class="dropdown d-inline-block user-dropdown">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if (Auth::user()->img == null)
                                <img src="{{ asset('assets/images/users/avatar-7.jpg') }}" height="32px"
                                    width="32px" alt="Header Avatar" class="rounded-circle header-profile-user">
                            @else
                                <img src="{{ asset('storage/person/' . Auth::user()->img) }}" height="32px"
                                    width="32px" alt="Header Avatar" class="rounded-circle header-profile-user">
                            @endif
                            <span class="d-none d-xl-inline-block ms-1" style="font-size: 12px;color:black">
                                {{ Auth::user()->fname }} {{ Auth::user()->lname }}
                            </span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="{{ url('user_editprofile/' . Auth::user()->id) }}"
                                style="font-size: 12px"><i class="ri-user-line align-middle me-1"></i> Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}" {{-- class="text-reset notification-item" --}}
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="ri-shut-down-line align-middle me-1 text-danger"></i>
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu ">
            {{-- <div data-simplebar class="h-300">  --}}
            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title">Menu</li>
                    <li>
                        <a href="{{ url('main_user') }}"> 
                            <i class="fas fa-swatchbook text-primary"></i> 
                            <span>Main </span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ url('user_train') }}">
                            <i class="fas fa-swatchbook text-success"></i>
                            <span>ประชุม/อบรม/ดูงาน</span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ url('ct_rep_import') }}">
                            <i class="fa fa-lungs-virus text-primary"></i>
                            <span>Import Excel CT</span>
                        </a>
                    </li> --}}
                   
                </ul>
            </div>
            <!-- Sidebar -->
            {{-- </div> --}}
        </div>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">

                @yield('content')

            </div>
            <!-- End Page-content -->

            {{-- <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © โรงพยาบาลภูเขียวเฉลิมพระเกียรติ
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Created with <i class="mdi mdi-heart text-danger"></i> by ทีมพัฒนา PK-HOS
                            </div>
                        </div>
                    </div>
                </div>
            </footer> --}}


        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
    {{-- </div> --}}


    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('dis/libs/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('dis/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dis/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('dis/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('dis/libs/node-waves/waves.min.js') }}"></script>
    {{-- <script src="{{ asset('js/select2.min.js') }}"></script> --}}
    <script src="{{ asset('select2/js/select2.min.js') }}"></script>
    {{-- <script src="{{ asset('dis/libs/select2/js/select2.min.js') }}"></script> --}}
    <script src="{{ asset('dis/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('dis/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
    <script src="{{ asset('dis/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('dis/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js') }}"></script>
    <script src="{{ asset('dis/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

    <script src="{{ asset('dis/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"
        integrity="sha512-cp+S0Bkyv7xKBSbmjJR0K7va0cor7vHYhETzm2Jy//ZTQDUvugH/byC4eWuTii9o5HN9msulx2zqhEXWau20Dg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- jquery.vectormap map -->
    <script src="{{ asset('dis/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('dis/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}">
    </script>

    <!-- Required datatable js -->
    <script src="{{ asset('dis/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dis/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Buttons examples -->
    <script src="{{ asset('dis/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dis/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dis/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('dis/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('dis/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dis/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('dis/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('dis/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('dis/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('dis/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('dis/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dis/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->
    <script src="{{ asset('dis/js/pages/datatables.init.js') }}"></script>
    <script src="{{ asset('dis/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ asset('dis/libs/twitter-bootstrap-wizard/prettify.js') }}"></script>
    <script src="{{ asset('dis/js/pages/form-wizard.init.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lang/th.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- App js -->
    <script src="{{ asset('dis/js/app.js') }}"></script>
    <script src="{{ asset('js/ladda.js') }}"></script>
    @yield('footer')

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
            $('#example4').DataTable();
            $('#example5').DataTable();

            // $('#Comfirm').on('submit',function(e){
            //       e.preventDefault();
            //       alert('OJJJJOL');
            //           var form = this;

            //           $.ajax({
            //             url:$(form).attr('action'),
            //             method:$(form).attr('method'),
            //             data:new FormData(form),
            //             processData:false,
            //             dataType:'json',
            //             contentType:false,
            //             beforeSend:function(){
            //               $(form).find('span.error-text').text('');
            //             },
            //             success:function(data){
            //               if (data.status == 200 ) {
            //                 Swal.fire({
            //                   title: 'ยืนยันข้อมูลสำเร็จ',
            //                   text: "You Confirm data success",
            //                   icon: 'success',
            //                   showCancelButton: false,
            //                   confirmButtonColor: '#06D177',
            //                   // cancelButtonColor: '#d33',
            //                   confirmButtonText: 'เรียบร้อย'
            //                 }).then((result) => {
            //                   if (result.isConfirmed) {
            //                     window.location="{{ url('ct_rep') }}";
            //                   }
            //                 })
            //               } else {

            //               }
            //             }
            //           });
            //     });

        });
    </script>
</body>

</html>
