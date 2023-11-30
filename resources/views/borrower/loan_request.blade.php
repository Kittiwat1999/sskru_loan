@extends('layout')
@section('titile')
borrower loan request
@endsection
@section('content')
<section class="section Editing">
    <div class="card">
        <div class="card-body pt-3">
            <!-- Default Tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="contr-tab" data-bs-toggle="tab" data-bs-target="#contr" type="button" role="tab" aria-controls="contr" aria-selected="true">รายงานสถานภาพ</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="confiem-money-tab" data-bs-toggle="tab" data-bs-target="#confiem-money" type="button" role="tab" aria-controls="confiem-money" aria-selected="false">บันทึกกิจกรรม</button>
                </li>
              </ul>
              <div class="tab-content pt-2" id="myTabContent">
                <div class="tab-pane fade show active" id="contr" role="tabpanel" aria-labelledby="contr-tab">
                    <br>

                    <!-- Extra Large Modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExtralargeModal">
                        ตัวอย่างเอกสาร
                    </button>

                    <div class="modal fade" id="ExtralargeModal" tabindex="-1">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">ตัวอย่างเอกสาร</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div align="center">
                                        <img src="assets/img/ยื่นกู้ต่อเนื่อง.png" alt="" width="700px">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Extra Large Modal-->
                    <br><br><br>

                    <div align="center">
                        <br><br><br>

                        <!-- Default List group -->
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">

                                <div class="d-grid w-75">
                                    <button class="btn btn-primary" type="button">ดาวน์โหลดเอกสาร</button>
                                </div>
                                <br><br>

                                <div class="row-cols-auto">
                                    <div class="col-md-6">
                                        <label for="file" class="text-black">สำเนาบัตรประชาชนผู้กู้</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div>
                                            <input name="file" type="file" class="form-control" id="file">
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row-cols-auto">
                                        <div class="col-md-4">
                                            <label for="file" class="text-black">สำเนาใบรายงานผลการเรียน</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div>
                                                <input name="file" type="file" class="form-control" id="file">
                                            </div>
                                        </div>
                                        <br>

                                            <div class="row-cols-auto">
                                                <div class="col-md-2">
                                                    <label for="file" class="text-black">บันทึกกิจกรรม</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div>
                                                        <input name="file" type="file" class="form-control"
                                                            id="file">
                                                    </div>
                                                </div>
                            </li>
                        </ul><!-- End Default List group -->
                        <br><br>
                    </div>
                    <div align="right">
                        <button type="button" class="btn btn-primary" onclick="nextPgae('confiem-money-tab')">
                            ถัดไป
                        </button>
                    </div>
                </div>
                <div class="tab-pane fade" id="confiem-money" role="tabpanel" aria-labelledby="confiem-money-tab">
                    <br>
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th scope="col-2">ชื่อโครงการ</th>
                                <th scope="col-2">สถานที่</th>
                                <th scope="col-2">วัน/เดือน/ปี</th>
                                <th scope="col-2">จำนวนชั่วโมง</th>
                                <th scope="col-2">ลักษณะกิจกรรม</th>
                                <th scope="col-2">แนบหลักฐาน</th>
                            </tr>
                        </thead>
                        <tbody id="table-body" class="text-center">
                            <tr>
                                <td>ปรับภูมิทัศน์โรงเรียน</td>
                                <td>โรงเรียนบ้านดู่</td>
                                <td>11/11/2566</td>
                                <td class="text-center">12</td>
                                <td>ถางหญ้าที่รกมากๆ</td>
                                <td class="text-center">
                                    <button class="btn btn-danger"><i class="bi bi-filetype-pdf"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>ปรับภูมิทัศน์โรงเรียน</td>
                                <td>โรงเรียนบ้านดู่</td>
                                <td>11/11/2566</td>
                                <td class="text-center">12</td>
                                <td>ถางหญ้าที่รกมากๆ</td>
                                <td class="text-center">
                                    <button class="btn btn-danger"><i class="bi bi-filetype-pdf"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>ปรับภูมิทัศน์โรงเรียน</td>
                                <td>โรงเรียนบ้านดู่</td>
                                <td>11/11/2566</td>
                                <td class="text-center">12</td>
                                <td>ถางหญ้าที่รกมากๆ</td>
                                <td class="text-center">
                                    <button class="btn btn-danger"><i class="bi bi-filetype-pdf"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>ปรับภูมิทัศน์โรงเรียน</td>
                                <td>โรงเรียนบ้านดู่</td>
                                <td>11/11/2566</td>
                                <td class="text-center">12</td>
                                <td>ถางหญ้าที่รกมากๆ</td>
                                <td class="text-center">
                                    <button class="btn btn-danger"><i class="bi bi-filetype-pdf"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>ปรับภูมิทัศน์โรงเรียน</td>
                                <td>โรงเรียนบ้านดู่</td>
                                <td>11/11/2566</td>
                                <td class="text-center">12</td>
                                <td>ถางหญ้าที่รกมากๆ</td>
                                <td class="text-center">
                                    <button class="btn btn-danger"><i class="bi bi-filetype-pdf"></i></button>
                                </td>
                            </tr>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center">60</td>
                                <td></td>
                                <td class="text-center">

                                    <div>
                                        <div>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#verticalycentered">
                                                เพิ่มข้อมูล<i class="bi bi-file-earmark-plus"></i>
                                            </button>
                                        </div>
                                        <div class="modal fade" id="verticalycentered" tabindex="-1">
                                            <div class="modal-dialog modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">เพิ่มข้อมูลกิจกรรม</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>

                                                            <div class="row-cols-auto">

                                                                <div class="col-md-2 text-start">
                                                                    <label for="firstname"
                                                                        class="text-secondary">ชื่อโครงการ</label>
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <div>
                                                                        <input name="firstname" type="text"
                                                                            class="form-control" id="firstname">
                                                                    </div><br>
                                                                </div>

                                                                <div class="col-md-2 text-start">
                                                                    <label for="lastname"
                                                                        class="text-secondary">สถานที่</label>
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <div>
                                                                        <input name="lastname" type="text"
                                                                            class="form-control" id="lastname">
                                                                    </div><br>
                                                                </div>

                                                                <div class="col-md-2 text-start">
                                                                    <label for="username"
                                                                        class="text-secondary">วัน/เดือน/ปี</label>
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <div>
                                                                        <input name="username" type="date"
                                                                            class="form-control" id="username">
                                                                    </div><br>
                                                                </div>

                                                                <div class="col-md-2 text-start">
                                                                    <label for="password"
                                                                        class="text-secondary">จำนวนชั่วโมง</label>
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <div>
                                                                        <input name="password" type="number"
                                                                            class="form-control" id="password">
                                                                    </div>
                                                                    <br>
                                                                </div>

                                                                <div class="row-cols-auto">
                                                                    <div class="col-md-2 text-start">
                                                                        <label for="password"
                                                                            class="text-secondary">ลักษณะกิจกรรม</label>
                                                                    </div>
                                                                    <div class="col-md-10">
                                                                        <div>
                                                                            <input name="password" type="text"
                                                                                class="form-control"
                                                                                id="password">
                                                                        </div>
                                                                        <br>

                                                                        <div class="col-md-2 text-start">
                                                                            <label for="password"
                                                                                class="text-secondary">แนบไฟล์</label>
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            <div>
                                                                                <input name="password"
                                                                                    type="file"
                                                                                    class="form-control"
                                                                                    id="password">
                                                                            </div>
                                                                            <br>
                                                                        </div>

                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">ยกเลิก</button>
                                                        <button type="submit"
                                                            class="btn btn-primary">เพิ่มข้อมูล</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div align="right">
                        <button type="button" class="btn btn-primary">
                            ถัดไป
                        </button>
                    </div>
                </div>
              </div><!-- End Default Tabs -->
        </div>
    </div>
</section>
<script>
    function nextPgae(page){
        console.log(page);
        document.getElementById(page).click();
        window.scrollTo(0, 0);
      }
</script>
@endsection