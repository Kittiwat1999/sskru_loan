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
                        <div align="right">
                            <button type="button" class="btn btn-primary">
                                ถัดไป
                            </button>
                        </div>
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