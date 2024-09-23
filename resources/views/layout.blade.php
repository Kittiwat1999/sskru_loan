<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>
        @yield('title')
    </title>

    @yield('style')
    <title>Dashboard - NiceAdmin Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- edit css -->
    <link rel="stylesheet" type="text/css" href="{{asset('app.css')}}">

    <!-- Favicons -->
    <link href="{{asset('assets/img/favicon.png')}}" rel="icon">
    <link href="{{asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <!-- <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet"> -->
    <link href="{{asset('assets/vendor/DataTables/datatables.min.css')}}" rel="stylesheet">

    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <!-- jquery datetimepicker -->
    <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.20/build/jquery.datetimepicker.min.css">

    <!-- Template Main CSS File -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
</head>
<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="{{url('/')}}" class="logo d-flex align-items-center">
                <img src="{{asset('assets/img/logo.png')}}" alt="">
                <span class="d-none d-lg-block">SSKRU Loan</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        @php
            $privilege_map = [
                'admin' => 'แอดมิน',
                'employee' => 'พนักงานทุนฯ',
                'teacher' => 'อาจารย์ที่ปรึกษา',
                'borrower' => 'ผู้กู้ยืม',
            ]; 
            $privilege = Session::get('privilege','admin'); //borrower, teacher, employee, admin
            $firstname = Session::get('firstname');
            $lastname = Session::get('lastname');
       @endphp

    <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <img src="{{asset('assets/img/profile-'.$privilege.'.png')}}" alt="Profile" class="rounded-circle">
                <span class="d-none d-md-block dropdown-toggle ps-2">{{$firstname. ' ' .$lastname}}</span>
            </a><!-- End Profile Iamge Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <li class="dropdown-header">
                    <h6>{{$firstname. ' ' .$lastname}}</h6>
                    <span>{{$privilege_map[$privilege]}}</span>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{url('/users_profile')}}">
                        <i class="bi bi-person"></i>
                        <span>My Profile</span>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                        <i class="bi bi-question-circle"></i>
                        <span>Need Help?</span>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{url('/signout')}}">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Sign Out</span>
                    </a>
                </li>

            </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

    </ul>
    </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            @if($privilege == "admin")
            <li class="nav-heading text-secondary">Dashboard</li>
            <li class="nav-item">
                <a id="dashboard" class="nav-link collapsed" href="{{url('/admin/dashboard')}}">
                <i class="bi bi-grid-1x2"></i>
                <span>สรุปข้อมูล</span>
                </a>
            </li><!-- End สรุปข้อมูล Page Nav -->


            <!-- End คำร้องขอแก้ใขเอกสาร Page Nav -->
            <li class="nav-heading text-secondary">admin menu</li>
            <li class="nav-item">
                <a id="manage_account" class="nav-link collapsed" href="{{url('/admin/manage_account')}}">
                <i class="bi bi-person"></i>
                <span>จัดการบัญชีผู้ใช้</span>
                </a>
            </li><!-- จัดการบัญชีผู้ใช้ Page Nav -->

            <li class="nav-item">
                <a id="manage_documents" class="nav-link collapsed" href="{{url('/admin/manage_documents')}}">
                <i class="bi bi-file-earmark-spreadsheet"></i>
                <span>จัดการเอกสาร</span>
                </a>
            </li>

            <li class="nav-item">
                <a id="document_scheduler" class="nav-link collapsed" href="{{url('/admin/document_scheduler')}}">
                    <i class="bi bi-calendar-date"></i>
                    <span>กำหนดการส่งเอกสาร</span>
                </a>
            </li><!-- End กำหนดระยะเวลา Page Nav -->

            <li class="nav-item">
                <a id="manage_data" class="nav-link collapsed" href="{{url('/admin/manage_data')}}">
                <i class="bi bi-box-seam"></i>
                <span>แก้ไขข้อมูล</span>
                </a>
            </li><!-- End แก้ไขเอกสาร Page Nav -->

            <li class="nav-item">
                <a id="cache-comment" class="nav-link collapsed" href="{{url('/admin/cache-comment')}}">
                <i class="bi bi-chat-square-text"></i>
                <span>แคชและความคิดเห็น</span>
                </a>
            </li><!-- End แก้ไขเอกสาร Page Nav -->
           
        @endif

        @if(($privilege == 'admin' || $privilege == "employee"))
            <li class="nav-heading text-secondary">เอกสารผู้กู้ยืม</li>

            <li class="nav-item">
                <a id="check_document" class="nav-link collapsed" href="{{url('check_document/index')}}">
                <i class="bi bi-clipboard2-check"></i>
                <span>ตรวจเอกสาร</span>
                </a>
            </li><!-- End คำขอกู้เกินหลักสูตร Page Nav -->

            <li class="nav-item">
                <a id="search_document" class="nav-link collapsed" href="{{url('search_document')}}">
                <i class="bi bi-file-earmark-break"></i>
                <span>ค้นหาเอกสาร</span>
                </a>
            </li><!-- End ค้นหาเอกสาร Page Nav -->

        @elseif($privilege == "borrower")

            <li class="nav-heading text-secondary">กรอกข้อมูลผู้กู้</li>
            <li class="nav-item">
                <a id="information" class="nav-link collapsed" href="{{url('/borrower/information/information_list')}}">
                <i class="bi bi-pen"></i>
                <span>กรอกข้อมูลผู้กู้</span>
                </a>
            </li>
            <li class="nav-item">
                <a id="borrower_register" class="nav-link collapsed" href="{{url('/borrower/borrower_register')}}">
                <i class="bi bi-pass"></i>
                <span>ยื่นกู้รายใหม่</span>
                </a>
            </li><!-- End กรอกข้อมูลผู้กู้ Page Nav -->

            <li class="nav-heading text-secondary">เอกสาร</li>
            <li class="nav-item">
                <a id="borrower_document" class="nav-link collapsed" href="{{url('/borrower/borrower_document/index')}}">
                    <i class="bi bi-file-earmark-check"></i>
                <span>เอกสารที่ส่งแล้ว</span>
                </a>
            </li><!-- End เอกสารที่ส่งแล้ว Page Nav -->

            <li class="nav-item">
                <a id="upload_document" class="nav-link collapsed" href="{{url('/borrower/upload_document')}}">
                    <i class="bi bi-file-earmark-arrow-up"></i>
                <span>ส่งเอกสาร</span>
                </a>
            </li><!-- End ยื่นกู้รายใหม่ Page Nav -->

            <li class="nav-item">
                <a id="download_document" class="nav-link collapsed" href="{{url('/borrower/download_document')}}">
                <i class="bi bi-file-earmark-arrow-down"></i>
                <span>ดาวน์โหลดเอกสาร</span>
                </a>
            </li><!-- End ยื่นกู้รายใหม่ Page Nav -->

        @elseif($privilege == "teacher")

            <li class="nav-heading text-secondary">Pages</li>

            <li class="nav-item">
                <a id="teacher" class="nav-link collapsed" href="{{route('teacher.index')}}">
                <i class="bi bi-file-earmark-medical"></i>
                <span>รายการคำขอกู้</span>
                </a>
            </li><!-- End รายการคำขอกู้ Page Nav -->
        @endif

        </ul>

    </aside>
    <main id="main" class="main">
        @if($errors->any())
            <div class="alert alert-danger" id="error-alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (!empty(session('success')))
            <div class="alert alert-success" id="success-alert">
                {{ session('success') }}
            </div>
            <script>
                // Wait for 3000 milliseconds (3 seconds) and then remove the element
                setTimeout(function() {
                    const elementToRemove = document.getElementById('success-alert');
                    if (elementToRemove) {
                        elementToRemove.remove();
                    }
                }, 3000);
            </script>
        @endif

            <div class="modal fade" id="expiredModal" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-body row">
                        <div class="col-12 text-center mb-3 mt-4">
                            <i class="bi bi-exclamation-circle-fill text-danger fs-1"></i>
                        </div>
                        <div class="col-12 text-center">
                            <h5>คุณไม่ได้ทำรายการในเวลาที่กำหนด</h5>
                        </div>
                        <div class="col-12 text-center mb-3">
                            <small>เพื่อความปลอดภัยในการทำรายการ</small><br>
                            <small>กรุณาเข้าสู่ระบบใหม่อีกครั้ง</small>
                        </div>
                    </div>
                    <div class="modal-footer row">
                        <div class="col-12 text-center">
                            <a href="{{url('/signout')}}" class="btn btn-primary">เข้าสู่ระบบใหม่</a>
                        </div>
                    </div>
                  </div>
                </div>
              </div>

        @yield('content')

    </main>
    <footer id="footer" class="footer">
        <div class="copyright">
        &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->

    <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
    <script src="{{asset('assets/vendor/echarts/echarts.min.js')}}"></script>
    <script src="{{asset('assets/vendor/quill/quill.min.js')}}"></script>
    <script src="{{asset('assets/vendor/DataTables/datatables.min.js')}}"></script>
    <script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>
    <!-- <script src="assets/vendor/simple-datatables/simple-datatables.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.20/build/jquery.datetimepicker.full.min.js"></script>


    <!-- Template Main JS File -->
    <script src="{{asset('assets/js/main.js')}}"></script>

    <script>
        // const hostName = "http://127.0.0.1:8000";

        function activeSidebar(paths){
            for(let i = 0; i <= paths.length; i ++){
                let activeElement = document.getElementById(paths[i]);
                if(activeElement != null){
                    activeElement.className = 'nav-link '
                    var firstChild = activeElement.firstElementChild;
                    firstChild.className += '-fill';
                    break;
                }
            }
        }
        var path = window.location.pathname; //get path name
        path = path.split('/');             //split path with '/'
        activeSidebar(path);          // call active sidebar function

        </script>
        @yield('script')
</body>
</html>
