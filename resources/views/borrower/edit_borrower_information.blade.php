@extends('layout')
@section('titile')
edit borrower information
@endsection
@section('content')
<section class="section Editing">
    <div class="card">
        <div class="card-body pt-3">
                                <!-- Default Tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active text-black" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                    type="button" role="tab" aria-controls="home"
                                    aria-selected="true">แนบหลักฐานแก้ไขข้อมูลผู้กู้</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <br>
                                        <div class="row-cols-auto">
                                            <div class="col-md-6">
                                                <label for="file" class="text-secondary">เอกสารแก้ไขข้อมูลผู้กู้</label>
                                            </div>
                                            <br>
                                            <div class="col-md-8">
                                                <div>
                                                    <input name="file" type="file" class="form-control" id="file">
                                                </div>
                                        </div>                         
                            </div>
                        </div>
                            <!-- Large Modal -->
                            <div align="right">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largeModal">
                                    ถัดไป
                                </button>
                            </div>

                        <div class="modal fade" id="largeModal" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title">ยืนยันการส่งเอกสาร</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                            <div class="container bg-light">
                                                <div align="center">
                                                    <br><br>
                                                    เอกสารแก้ไขข้อมูลผู้กู้ &nbsp; <img src="{{asset('assets/img/pngwing.com.png')}}" alt="" height="20px">
                                                    <br><br><br><br>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                <button type="button" class="btn btn-primary">ยืนยัน</button>
                                </div>
                            </div>
                            </div>
                        </div>
                        <!-- End Large Modal-->
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