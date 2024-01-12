<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <title>
        @yield('title')
    </title>
    <style>

        iframe {
            width: 100%;
            height:80rem;
        }

        .text-progress-step{
            font-size: 11px;
        }

                /* file upload button */
        input[type="file"]::file-selector-button {
        border-radius: 4px;
        padding: 0 16px;
        height: 40px;
        cursor: pointer;
        background-color: #dc3545;
        color:#f8f9fa;
        border: 1px solid rgba(0, 0, 0, 0.16);
        box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.05);
        margin-right: 16px;
        transition: background-color 200ms;
        }

        /* file upload button hover state */
        input[type="file"]::file-selector-button:hover {
        background-color: #dc3540;;
        }

        /* file upload button active state */
        input[type="file"]::file-selector-button:active {
        background-color: #dc3540;;
        }
    </style>

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


    <!-- Template Main CSS File -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
</head>
<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="{{asset('assets/img/logo.png')}}" alt="">
                <span class="d-none d-lg-block">SSKRU Loan</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
            <a class="nav-link nav-icon search-bar-toggle " href="#">
                <i class="bi bi-search"></i>
            </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
        </a><!-- End Notification Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
            You have 4 new notifications
            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
            <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
            <i class="bi bi-exclamation-circle text-warning"></i>
            <div>
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
            </div>
            </li>

            <li>
            <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
            <i class="bi bi-x-circle text-danger"></i>
            <div>
                <h4>Atque rerum nesciunt</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>1 hr. ago</p>
            </div>
            </li>

            <li>
            <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
            <i class="bi bi-check-circle text-success"></i>
            <div>
                <h4>Sit rerum fuga</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>2 hrs. ago</p>
            </div>
            </li>

            <li>
            <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
            <i class="bi bi-info-circle text-primary"></i>
            <div>
                <h4>Dicta reprehenderit</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>4 hrs. ago</p>
            </div>
            </li>

            <li>
            <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
            <a href="#">Show all notifications</a>
            </li>

        </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown pe-3">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{asset('assets/img/profile-img.jpg')}}" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">K. Anderson</span>
        </a><!-- End Profile Iamge Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
            <h6>Kevin Anderson</h6>
            <span>Web Designer</span>
            </li>
            <li>
            <hr class="dropdown-divider">
            </li>

            <li>
            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
            </a>
            </li>
            <li>
            <hr class="dropdown-divider">
            </li>

            <li>
            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
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
            <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
            </a>
            </li>

        </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

    </ul>
    </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->
    <?php
        $privilage = "borrower";//admin,borrower,faculty,teacher,employee
    ?>
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            @if($privilage == "admin")
            <li class="nav-heading text-secondary">Dashboard</li>
            <li class="nav-item">
                <a id="dashboard" class="nav-link collapsed" href="{{url('/admin/dashboard')}}">
                <i class="bi bi-grid-1x2"></i>
                <span>สรุปข้อมูล</span>
                </a>
            </li><!-- End สรุปข้อมูล Page Nav -->

            <!-- <li class="nav-item">
                <a id="return_document" class="nav-link collapsed" href="{{url('/admin/return_document')}}">
                <i class="bi bi-clipboard-x"></i>
                <span>คำร้องขอแก้ใขเอกสาร</span>
                </a>
            </li> -->
            <!-- End คำร้องขอแก้ใขเอกสาร Page Nav -->
            <li class="nav-heading text-secondary">admin menu</li>
            <li class="nav-item">
                <a id="manage_account" class="nav-link collapsed" href="{{url('/admin/manage_account')}}">
                <i class="bi bi-person-square"></i>
                <span>จัดการบัญชีผู้ใช้</span>
                </a>
            </li><!-- จัดการบัญชีผู้ใช้ Page Nav -->
            
            <li class="nav-item">
                <a id="settime" class="nav-link collapsed" href="{{url('/admin/settime')}}">
                    <i class="bi bi-calendar-date"></i>
                    <span>กำหนดระยะเวลา</span>
                </a>
            </li><!-- End กำหนดระยะเวลา Page Nav -->
            
            <li class="nav-item">
                <a id="edit_informaion_request" class="nav-link collapsed" href="{{url('/admin/edit_informaion_request')}}">
                <i class="bi bi-pencil-square"></i>
                <span>คำร้องขอแก้ใขข้อมูล</span>
                </a>
            </li><!-- End คำร้องขอแก้ใขข้อมูล Page Nav -->
        @endif

        @if(($privilage == 'admin' || $privilage == "employee") || $privilage == 'faculty')
            <li class="nav-heading text-secondary">ตรวจเอกสาร</li>
            <li class="nav-item">
                <a id="new_loan_submission" class="nav-link collapsed" href="{{url('new_loan_submission')}}">
                <i class="bi bi-file-earmark-plus"></i>
                <span>รายการยื่นกู้รายใหม่</span>
                </a>
            </li><!-- End รายการยื่นกู้รายใหม่ Page Nav -->
        @endif

        @if($privilage == 'admin' || $privilage == "employee")
        
        <li class="nav-item">
            <a id="loan_submission" class="nav-link collapsed" href="{{url('loan_submission')}}">
            <i class="bi bi-file-earmark-person"></i>
            <span>รายการยื่นกู้รายเก่า</span>
            </a>
        </li><!-- End รายการยื่นกู้รายเก่า Page Nav -->

        <li class="nav-item">
            <a id="contract" class="nav-link collapsed" href="{{url('contract')}}">
            <i class="bi bi-file-break"></i>
            <span>สัญญาผู้กู้รายใหม่</span>
            </a>
        </li><!-- End สัญญาผู้กู้รายใหม่ Page Nav -->

        <li class="nav-item">
            <a id="confirm_money_withdraw" class="nav-link collapsed" href="{{url('confirm_money_withdraw')}}">
            <i class="bi bi-file-check"></i>
            <span>แบบยืนยันการเบิกเงิน</span>
            </a>
        </li><!-- End แบบยืนยันการเบิกเงิน Page Nav -->

        <li class="nav-item">
            <a id="over_course" class="nav-link collapsed" href="{{url('over_course')}}">
            <i class="bi bi-file-earmark-diff"></i>
            <span>คำขอกู้เกินหลักสูตร</span>
            </a>
        </li><!-- End คำขอกู้เกินหลักสูตร Page Nav -->

        <li class="nav-heading text-secondary">ค้นหาเอกสาร</li>

        <li class="nav-item">
            <a id="search_document" class="nav-link collapsed" href="{{url('search_document')}}">
            <i class="bi bi-search"></i>
            <span>ค้นหาเอกสาร</span>
            </a>
        </li><!-- End ค้นหาเอกสาร Page Nav -->
        @elseif($privilage == "borrower")

            <li class="nav-heading text-secondary">กรอกข้อมูลผู้กู้</li>
            <li class="nav-item">
                <a id="information" class="nav-link collapsed" href="{{url('/borrower/information')}}">
                <i class="bi bi-pen"></i>
                <span>กรอกข้อมูลผู้กู้</span>
                </a>
            </li><!-- End กรอกข้อมูลผู้กู้ Page Nav -->

            <li class="nav-heading text-secondary">รายการเอกสารที่ส่ง</li>
            <li class="nav-item">
                <a id="index" class="nav-link collapsed" href="{{url('/borrower/index')}}">
                <i class="bi bi-card-list"></i>
                <span>เอกสารที่ส่งแล้ว</span>
                </a>
            </li><!-- End เอกสารที่ส่งแล้ว Page Nav -->
            <li class="nav-heading text-secondary">ยืนกู้</li>
            <li class="nav-item">
                <a id="new_loan_request" class="nav-link collapsed" href="{{url('/borrower/new_loan_request')}}">
                <i class="bi bi-file-earmark-plus"></i>
                <span>ยื่นกู้รายใหม่</span>
                </a>
            </li><!-- End ยื่นกู้รายใหม่ Page Nav -->
            
            
            <li class="nav-item">
                <a id="loan_request" class="nav-link collapsed" href="{{url('/borrower/loan_request')}}">
                    <i class="bi bi-file-arrow-up"></i>
                    <span>ยื่นกู้รายเก่าเลื่อนชั้นปี</span>
                </a>
            </li><!-- End ยื่นกู้รายเก่าเลื่อนชั้นปี Page Nav -->
            
            <li class="nav-item">
                <a id="loan_over_course" class="nav-link collapsed" href="{{url('/borrower/loan_over_course')}}">
                    <i class="bi bi-file-earmark-diff"></i>
                    <span>ยื่นกู้เกินหลักสูตร</span>
                </a>
            </li><!-- End Error 404 Page Nav -->
            <li class="nav-heading text-secondary">ส่งเอกสาร</li>
            <li class="nav-item">
                <a id="send_contract" class="nav-link collapsed" href="{{url('/borrower/send_contract')}}">
                <i class="bi bi-file-break"></i>
                <span>ส่งสัญญาและแบบยืนยัน</span>
                </a>
            </li><!-- End ส่งสัญญาและแบบยืนยัน Page Nav -->

            <li class="nav-item">
                <a id="send_confirmation_form" class="nav-link collapsed" href="{{url('/borrower/send_confirmation_form')}}">
                <i class="bi bi-file-check"></i>
                <span>ส่งแบบยืนยัน</span>
                </a>
            </li><!-- End Login Page Nav -->
            <li class="nav-heading text-secondary">ขอแก้ใขข้อมูล</li>
            <li class="nav-item">
                <a id="edit_borrower_information" class="nav-link collapsed" href="{{url('/borrower/edit_borrower_information')}}">
                <i class="bi bi-pencil-square"></i>
                <span>ขอแก้ใขข้อมูล</span>
                </a>
            </li><!-- End Blank Page Nav -->
        @elseif($privilage == "teacher")
            <li class="nav-heading text-secondary">Pages</li>

            <li class="nav-item">
                <a id="teacher_index" class="nav-link collapsed" href="{{route('teacher_index')}}">
                <i class="bi bi-grid-1x2"></i>
                <span>รายการคำขอกู้</span>
                </a>
            </li><!-- End รายการคำขอกู้ Page Nav -->
        @endif

        </ul>

    </aside>
    <main id="main" class="main">
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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
    <script src="{{asset('assets/vendor/echarts/echarts.min.js')}}"></script>
    <script src="{{asset('assets/vendor/quill/quill.min.js')}}"></script>
    <script src="{{asset('assets/vendor/DataTables/datatables.min.js')}}"></script>
    <script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>
    <!-- <script src="assets/vendor/simple-datatables/simple-datatables.js"></script> -->


    <!-- Template Main JS File -->
    <script src="{{asset('assets/js/main.js')}}"></script>

    <script>
        const hostName = "http://127.0.0.1:8000";

        function activeSidebar(activeElement){
            console.log(activeElement)
            document.getElementById(activeElement).className = 'nav-link '
        }
        var path = window.location.pathname; //get path name
        path = path.split('/');             //split path with '/'
        console.log(path);         //log path with 
        activeSidebar(path[path.length-1]);          // call active sidebar function
           
    </script>
</body>
</html>