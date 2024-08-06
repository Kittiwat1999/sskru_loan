@extends('layout')
@section('title','manage account')
@section('content')
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">จัดการบัญชีผู้ใช้</h5>
                <div class="row mb-4">
                    <!-- <div class="col-md-2">
                        <label for="privilage" class="col-form-label text-secondary">ประเภทผู้ใช้</label>
                    </div> -->
                    @php
                        $select_privilage = Session::get('select_privilage');
                    @endphp
                    <div class="col-md-4 mb-3">
                        <select id="select-level-show" class="form-select" aria-label="Default select example" name="privilage" required onchange="getUsersByPrivilage(this.value)">
                            <option {{($select_privilage == "admin") ? 'selected' : '' }} value="admin">แอดมิน</option>
                            <option {{($select_privilage == "employee") ? 'selected' : '' }} value="employee">พนักงานทุนฯ</option>
                            <option {{($select_privilage == "teacher") ? 'selected' : '' }} value="teacher">อาจารย์ที่ปรึกษา</option>
                            <option {{($select_privilage == "borrower") ? 'selected' : '' }} value="borrower">ผู้กู้</option>
                        </select>
                    </div>
                    <div class="col-md-5"></div>
                    <div class="col-md-3 col-sm-12 mb-3">
                        <!-- form Modal-->
                        <button type="button" class="btn btn-success w-100"  data-bs-toggle="modal" data-bs-target="#form-modal"><i class="bi bi-plus"></i> เพิ่มผู้ใช้</button>
                        <div class="modal fade" id="form-modal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title">เพิ่มผู้ใช้</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="row" action="{{route('admin.createUser')}}" method="post" id="add-user-form">
                                            @csrf
                                            <div class="col-6">
                                                <label for="prefix" class="col-form-label">คำนำหน้า</label>
                                                <select id="prefix" name="prefix" class="form-select" aria-label="Default select example" required>
                                                    <option value="" disabled selected>เลือกคำนำหน้า..</option>
                                                    <option value="นาย">นาย</option>
                                                    <option value="นาง">นาง</option>
                                                    <option value="นางสาว">นางสาว</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    กรุณาเลือกคำนำหน้า
                                                </div>
                                            </div>
                                            <div class="col-6"></div>
                                            <div class="col-6">
                                                <label for="firstname" class="col-form-label">ชื่อ</label>
                                                <input type="text" name="firstname" class="form-control" required>
                                                <div class="invalid-feedback">
                                                    กรุณากรอกชื่อ
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="lastname" class="col-form-label">นามสกุล</label>
                                                <input type="text" name="lastname" class="form-control" required>
                                                <div class="invalid-feedback">
                                                    กรุณากรอกนามสกุล
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="email" class="col-form-label">อีเมล์</label>
                                                <input type="text" name="email" class="form-control" required>
                                                <div class="invalid-feedback">
                                                    กรุณากรอกอีเมลล์
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="password" class="col-form-label">รหัสผ่าน</label>
                                                <input id="new-input-password" type="password" name="password" class="form-control" required>
                                                <div class="invalid-feedback">
                                                    กรุณากรอกรหัสผ่าน
                                                </div>
                                            </div>
                                            <div class="col-6"></div>
                                            <div class="col-12">
                                                <label for="privilage" class="col-form-label">ประเภทผู้ใช้</label>
                                                <select id="privilage" class="form-select" aria-label="Default select example" name="privilage" required onchange="user_privilage(this.value,'input-faculty','major')">
                                                    <option selected disabled value="">เลือกประเภทผู้ใช้..</option>
                                                    <option value="admin">แอดมิน</option>
                                                    <option value="employee">พนักงานทุนฯ</option>
                                                    <option value="teacher">อาจารย์ที่ปรึกษา</option>
                                                    <option value="borrower">ผู้กู้</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    กรุณาเลือกประเภทผู้ใช้
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="faculty" class="col-form-label">คณะ</label>
                                                <select id="input-faculty" class="form-select" aria-label="Default select example" name="faculty" disabled onchange="getMajorByFacultyId(this.value,'major')">
                                                    <option selected disabled value="">เลือก..</option>
                                                    @foreach($faculties as $faculty)
                                                        <option value="{{$faculty->id}}">{{$faculty->faculty_name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    กรุณาเลือกคณะ
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="major" class="col-form-label">สาขา</label>
                                                <select id="major" class="form-select" aria-label="Default select example" name="major" disabled>
                                                    <option selected disabled value="">เลือกสาขา..</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    กรุณาเลือกสาขา
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="text-end">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                            <button type="button" class="btn btn-success" onclick="submitForm('add-user-form')">เพิ่มผู้ใช้</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End form Modal-->
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="users-table">
                        <thead>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">ชื่อ-สกุล</th>
                                <th scope="col">อีเมล</th>
                                <th scope="col">สิทธ์การใช้งาน</th>
                                <th scope="col">created_at</th>
                                <th scope="col">updated-at</th>
                                <th scope="col">action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- delete user Modal-->
    <div class="modal fade" id="deleteUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="deleteUserModalContent">
                
            </div>
        </div>
    </div>
    <!-- End delete user Modal-->

    <!-- show user data Modal-->
    <div class="modal fade" id="showDataModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ข้อมูลผู้ใช้</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="showDataModal-content" class="modal-body">
                    
                </div>
            </div>
        </div>
    </div>
    <!-- end show user data Modal-->

    <script>
        var faculties = @json($faculties);

        function showUserModal(userid){
            getUserById(userid);
        }

        function getUserById(userid) {
        const modal = new bootstrap.Modal(document.getElementById('showDataModal'));
        const modalContent = document.getElementById('showDataModal-content');
            fetch(`{{url('admin/get_user_by_id/${userid}')}}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                return response.json();
                }).then(data => {
                    var user = data.user;
                    var majors = data.majors;
                    modalContent.innerHTML = `
                    <form class="row" action="{{route('admin.editAccount')}}" method="POST" id="edit-user">
                        @csrf
                        <input type="hidden" name="id" class="form-control" value="${user.id}" required>
                        <div class="col-6">
                            <label for="prefix" class="col-form-label text-secondary">คำนำหน้า</label>
                            <select id="prefix" name="prefix" class="form-select" aria-label="Default select example" required>
                                <option >เลือกคำนำหน้าชื่อ</option>
                                <option ${(user.prefix == 'นาย')? 'selected': ''} value="นาย">นาย</option>
                                <option ${(user.prefix == 'นาง')? 'selected': ''} value="นาง">นาง</option>
                                <option ${(user.prefix == 'นางสาว')? 'selected': ''} value="นางสาว">นางสาว</option>
                            </select>
                        </div>
                        <div class="col-6"></div>
                        <div class="col-6">
                            <label for="firstname" class="col-form-label">ชื่อ</label>
                            <input type="text" name="firstname" class="form-control need-custom-validate" value="${user.firstname}" required>
                            <div class="invalid-feedback">
                                กรุณากรอกชื่อ
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="lastname" class="col-form-label">นามสกุล</label>
                            <input type="text" name="lastname" class="form-control need-custom-validate" value="${user.lastname}" required>
                            <div class="invalid-feedback">
                                กรุณากรอกนามสกุล
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="email" class="col-form-label">อีเมล</label>
                            <input type="text" name="email" class="form-control need-custom-validate" value="${user.email}" required>
                            <div class="invalid-feedback">
                                กรุณากรอกอีเมลล์
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="password" class="col-form-label">รหัสผ่าน</label>
                            <input id="input-password" type="password" name="password" class="form-control" value="">
                            <div class="invalid-feedback">
                                กรุณากรอกรหัสผ่าน
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="borrower-type" class="col-form-label text-secondary">ระดับผู้ใช้</label>
                            <select id="select-level-user" class="form-select" aria-label="Default select example" name="privilage" required onchange="user_privilage(this.value,'edit-faculty','edit-major')" ${(user.privilage == 'borrower') ? 'disabled' : '' }>
                                <option ${(user.privilage == 'admin') ? 'selected':'' } value="admin">แอดมิน</option>
                                <option ${(user.privilage == 'employee') ? 'selected':'' } value="employee">พนักงานทุนฯ</option>
                                <option ${(user.privilage == 'teacher') ? 'selected':'' } value="teacher">อาจารย์ที่ปรึกษา</option>
                                <option ${(user.privilage == 'borrower') ? 'selected':'' } value="borrower">ผู้กู้</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="edit-faculty" class="col-form-label text-secondary">คณะ</label>
                            <select id="edit-faculty" class="form-select" aria-label="Default select example" name="faculty" onchange="getMajorByFacultyId(this.value,'edit-major')" ${(user.privilage == 'teacher' || user.privilage == 'faculty') ? '' : 'disabled'}>
                                <option selected disabled value="">เลือกคณะ..</option>
                                ${faculties.map((faculty) => {
                                    return `<option value="${faculty.id}" ${(user.faculty_id == faculty.id) ? 'selected' : '' } >${faculty.faculty_name}</option>`
                                }).join('')}
                            </select>
                            <div class="invalid-feedback">
                                กรุณาเลือกคณะ
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="edit-major" class="col-form-label text-secondary">สาขา</label>
                            <select id="edit-major" class="form-select" aria-label="Default select example" name="major" ${(user.privilage == 'teacher') ? '' : 'disabled'}>
                                <option selected disabled value="">เลือกสาขา..</option>
                                ${majors.map((major) => {
                                    return `<option value="${major.id}" ${(user.major_id == major.id)? 'selected' : '' } >${major.major_name}</option>`
                                }).join('')}
                            </select>
                            <div class="invalid-feedback">
                                กรุณาเลือกสาขา
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            <button type="button" class="btn btn-primary" onclick="submitForm('edit-user')" >บันทึก</button>
                        </div>
                    </form>
                    `;
                })
                .catch(error => {
                    console.error('Error fetching user:', error);
                }
            );

            modal.show();
        }

        function showDeleteModal(id, firstname, lastname){
            const modal = new bootstrap.Modal(document.getElementById('deleteUserModal'));
            const modal_content = document.getElementById('deleteUserModalContent');
            modal_content.innerHTML = ''; //reset modal content
            modal_content.innerHTML = `
                <div class="modal-header">
                    <h5 class="modal-title">ลบบัญชีผู้ใช้</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="delete-modal-content" class="modal-body">
                    ต้องการลบข้อมูลของผู้ใช้ <span class="text-danger">${firstname} ${lastname}</span>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-light" href="{{route('admin.deleteUser', ['id' => 'PLACEHOLDER_USER_ID' ])}}">ลบบัญชีผู้ใช้</a>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            `;
            modal_content.innerHTML = modal_content.innerHTML.replace('PLACEHOLDER_USER_ID', id);
            modal.show();
        }


        function showPassword(inputId) {
        var passwordInput = document.getElementById(inputId);
        var iconPassword = document.getElementById('icon-'+inputId);
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            iconPassword.className = "bi bi-eye"
        } else {
            passwordInput.type = 'password';
            iconPassword.className = "bi bi-eye-slash"
        }
        }

        function getUsersByPrivilage(select_privilage){
            window.location.href = '{{ route('admin.manageaccount.privilage', ['select_privilage' => ':select_privilage']) }}'.replace(':select_privilage', select_privilage);
        }

        function getMajorByFacultyId(faculty_id,major_element_id){

            fetch(`{{url('/admin/manage_account/get_major_by_faculty_id/${faculty_id}')}}`)
            .then(response => {
                if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(majors => {
                var select_major_element = document.getElementById(major_element_id);
                select_major_element.innerHTML = `<option selected disabled value="admin">เลือกสาขา..</option>`;
                majors.forEach((major) => {
                    var option = document.createElement('option');
                    option.value = major.id;
                    option.innerText = major.major_name;
                    select_major_element.appendChild(option);
                })
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
        }

        async function submitForm(formId){
            var validate = await validateForm(formId)
            if(validate){
                document.getElementById(formId).submit();
            }
        }
        async function validateForm(formId){
            var form = document.getElementById(formId);
            var inputText = form.querySelectorAll('input[type="text"].need-custom-validate');
            var inputSelect = form.querySelectorAll('select[required]');
            var inputPassword = form.querySelector('input[type="password"].need-custom-validate')
            var validator = true;

            if(inputPassword != null){
                if(inputPassword.value == ""){
                    validator = false;
                    var invalid_element = inputPassword.nextElementSibling;
                    if(invalid_element)invalid_element.classList.add('d-inline');
                }else{
                    var invalid_element = inputPassword.nextElementSibling;
                    if(invalid_element)invalid_element.classList.remove('d-inline');
                }
            }

            await inputText.forEach((e) => {
                if(e.value == ''){
                    validator = false;
                    var invalid_element = e.nextElementSibling;
                    if(invalid_element)invalid_element.classList.add('d-inline');
                }else{
                    var invalid_element = e.nextElementSibling;
                    if(invalid_element)invalid_element.classList.remove('d-inline');
                }
            });

            await inputSelect.forEach((e)=>{
                if(e.value == ""){
                    validator = false;
                    var invalid_element = e.nextElementSibling;
                    if(invalid_element)invalid_element.classList.add('d-inline');
                }else{
                    var invalid_element = e.nextElementSibling;
                    if(invalid_element)invalid_element.classList.remove('d-inline');
                }
            });

            return validator;
        }

        function user_privilage(privilageType,facultyId,majorId){
            var majorSelectElement = document.getElementById(majorId);
            var facultySelectElement = document.getElementById(facultyId);
            if(privilageType == 'teacher'){
                majorSelectElement.disabled = false;
                majorSelectElement.required = true;
                facultySelectElement.disabled = false;
                facultySelectElement.required = true;
            }else{
                majorSelectElement.disabled = true;
                majorSelectElement.required = false;
                facultySelectElement.disabled = true;
                facultySelectElement.required = false;
            }
        }

        $(document).ready(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:"{{ route('admin.get.users') }}",
                    type:'GET',
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'fullname', name: 'fullname' },
                    { data: 'email', name: 'email' },
                    { data: 'thai-privilage', name: 'thai-privilage' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                buttons: [],
                responsive: true,
                language: {
                    "sProcessing": "กำลังประมวลผล...",
                    "sLengthMenu": "แสดง _MENU_ รายการ",
                    "sZeroRecords": "ไม่พบข้อมูล",
                    "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 รายการ",
                    "sInfoFiltered": "(กรองจาก _MAX_ รายการทั้งหมด)",
                    "sSearch": "ค้นหา:",
                    "oPaginate": {
                        "sFirst": "แรก",
                        "sPrevious": "ก่อนหน้า",
                        "sNext": "ถัดไป",
                        "sLast": "สุดท้าย"
                    }
                }
            });
        });
    </script>
@endsection
