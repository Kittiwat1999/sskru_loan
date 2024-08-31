@extends('layout')
@section('title')
รายงานผลการเรียนผู้กู้
@endsection
@section('style')
<style>
        iframe {
        width: 100%;
        border: none;
        }
        @media (max-width: 600px) {
        iframe {
            height: 400px;
        }
        }
        @media (min-width: 601px) and (max-width: 1200px) {
        iframe {
            height: 500px;
        }
        }
        @media (min-width: 1201px) {
        iframe {
            height: 1000px;
        }
        }
    </style>
@endsection

@section('content')
<section class="section Editing">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{$child_document['child_document_title']}}</h5>
            <div class="container">
                <iframe src="{{route("check.document.preview.file", ['borrower_child_document_id' => $borrower_child_document['id'] ])}}"></iframe>
            </div>

            <fieldset class="row mb-3 mt-3 mx-2">
                <legend class="col-form-label col-sm-2 pt-0 fw-bold">ให้ความเห็น</legend>
                <div class="col-sm-10">

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status-approve" value="approve" checked="" onchange="enableCheckbox(this.value)">
                        <label class="form-check-label" for="status-approve">
                        เอกสารถูกต้อง
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status-reject" value="reject" onchange="enableCheckbox(this.value)">
                        <label class="form-check-label" for="status-reject">
                        เอกสารไม่ถูกต้อง
                        </label>
                    </div>

                </div>
            </fieldset>

            <div class="row mb-3 mt-2 text-dark text-start mx-2">

                <div class="col-sm-2"></div>
                <div class="col-sm-5">

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gpa_comment_1" disabled="">
                        <label class="form-check-label" for="gpa_comment_1" name="gpa_comment_1">
                            เอกสารไม่ชัดเจน
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gpa_comment_2" disabled="">
                        <label class="form-check-label" for="gpa_comment_2" name="gpa_comment_2">
                            บัตรประชาชนหมดอายุ
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gpa_more_radio" disabled="" onchange="enableInputArea('gpa_')">
                        <label class="form-check-label" for="gpa_more_radio">
                            อื่นๆ
                        </label>
                    </div>
                    <div class="input-group">
                        <label for="gpa_moreText"></label>
                        <textarea class="form-control" name="gpa_moreText" id="gpa_moreText" cols="30" rows="4" disabled=""></textarea>
                    </div>

                </div>

                <div class="col-sm-5">

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gpa_comment_3" disabled="">
                        <label class="form-check-label" for="gpa_comment_3" name="gpa_comment_3">
                            ลายมือชื่อในเอกสารกับสำเนาบัตรไม่ตรงกัน
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gpa_comment_4" disabled="">
                        <label class="form-check-label" for="gpa_comment_4" name="gpa_comment_4">
                            สำเนาบัตรประชาชนไม่ถูกต้อง
                        </label>
                    </div>

                </div>

                <div class="text-end mt-3">
                    <a class="btn btn-primary col-4 col-md-2" href="{{url('check_document/check_documents_test')}}">บันทึก</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scirpt')
<script>

</script>
@endsection
