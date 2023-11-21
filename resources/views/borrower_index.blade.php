@extends('borrower_layout')
@section('title')
index borrower
@endsection
@section('content')
    
    <section class="section dashboard">
      <div class="alert alert-primary alert-dismissible fade show" role="alert">
        ท่านสามารถส่งแบบยืนยันได้ตั้งแต่วันนี้จนถึง {{date('Y-m-d')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <!-- end alert -->

      <!-- start card table -->
      <div class="card">
        <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-bordered">

          <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#all-document">เอกสารที่ส่งแล้ว</button>
          </li>

          <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#document-edit">เอกสารที่ต้องแก้ใข</button>
          </li>
        </ul>
        <div class="tab-content pt-2">
          <div class="tab-pane fade show active all-document table-responsive" id="all-document">
            <?php 
            date_default_timezone_set("Asia/Bangkok");

            $documents = array(
              array('docName'=>'แบบยืนยันการเบิกเงิน','year'=>'2566','term'=>'2','lastUpdate'=>date('Y-m-d H:i:s'),'status'=>'ฝ่ายทุนกำลังดำเนินการ','waitQue'=>'125','karTerm'=>'9,000','karkrongchip'=>'18,000'),
              array('docName'=>'แบบยืนยันการเบิกเงิน','year'=>'2566','term'=>'1','lastUpdate'=>date('Y-m-d H:i:s'),'status'=>'อนุมัติแล้ว','waitQue'=>'','karTerm'=>'9,000','karkrongchip'=>'18,000'),
              array('docName'=>'ยื่นกู้รายเก่า(ต่อเนื่อง)','year'=>'2566','term'=>'1','lastUpdate'=>date('Y-m-d H:i:s'),'status'=>'อนุมัติแล้ว','waitQue'=>'','karTerm'=>'','karkrongchip'=>''),
              array('docName'=>'แบบยืนยันการเบิกเงิน','year'=>'2565','term'=>'2','lastUpdate'=>date('Y-m-d H:i:s'),'status'=>'อนุมัติแล้ว','waitQue'=>'','karTerm'=>'9,000','karkrongchip'=>'18,000'),
              array('docName'=>'สัญญาและแบบยืนยัน','year'=>'2565','term'=>'1','lastUpdate'=>date('Y-m-d H:i:s'),'status'=>'อนุมัติแล้ว','waitQue'=>'','karTerm'=>'9,000','karkrongchip'=>'18,000'),
              array('docName'=>'แบบคำขอกู้ยืม','year'=>'2565','term'=>'1','lastUpdate'=>date('Y-m-d H:i:s'),'status'=>'อนุมัติแล้ว','waitQue'=>'','karTerm'=>'','karkrongchip'=>''),
            );
            $i = 1;
            ?>
            <!-- Dark Table -->
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">รายการเอกสาร</th>
                  <th scope="col">วันที่ส่ง</th>
                  <th scope="col">สถานะ</th>
                  <th scope="col">ค่าเทอม/ค่าครองชีพ</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($documents as $document)
                <tr>
                    <td>{{$i++}}</td>
                    <td>
                    <span class="">{{$document['docName']}}</span><br>
                    <span class="fw-light text-secondary">{{$document['year']}} / {{$document['term']}}</span>
                    </td>
                    <td>
                    <span class="text-secondary">
                        {{$document['lastUpdate']}}
                    </span>
                    </td>
                    <td>
                    @if($document['status'] == "ฝ่ายทุนกำลังดำเนินการ")
                        <button class="btn btn-sm btn-outline-warning">{{$document['status']}}</button>
                    @else
                        <button class="btn btn-sm btn-success">{{$document['status']}}</button>
                    @endif
                    @if($document['waitQue'] !='')
                        <span class="fw-light text-secondary">(คิวที่ {{$document['waitQue']}})</span>
                    @endif
                    </td>
                    <td>
                        @if($document['karTerm'] && $document['karkrongchip'])
                            <sapn class="text-dark">{{$document['karTerm']}} / {{$document['karkrongchip']}}</span>
                        @endif
                    </td>
                    <td class="text-center">
                      @if($document['status'] == "ฝ่ายทุนกำลังดำเนินการ")
                        <button type="button" class="btn btn-sm btn-warning">ยกเลิก</button>
                      @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
            <!-- End Dark Table -->
          </div>
          <?php 

            $editDocument = array(
              array('docName'=>'แบบยืนยันการเบิกเงิน','year'=>'2566','term'=>'2','lastUpdate'=>date('Y-m-d H:i:s'),'waitQue'=>'125','karTerm'=>'9,000','karkrongchip'=>'18,000','comment'=>array(['comname'=>'สำเนาบัตรประชาชน','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร'],['comname'=>'แบบยืนยันการเบิกเงิน','comdescript'=>'เอกสารไม่ชัดเจน']))
            );
            $i = 1;
          ?>
          <div class="tab-pane fade all-document table-responsive" id="document-edit">
            <!-- Dark Table -->
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">รายการเอกสาร</th>
                  <th scope="col">วันที่ส่ง</th>
                  <th scope="col">ค่าเทอม/ค่าครองชีพ</th>
                  <th scope="col">ส่วนที่ต้องแก้ใข</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($editDocument as $editDoc)
                <tr>
                    <td>{{$i++}}</td>
                    <td>
                    <span class="">{{$editDoc['docName']}}</span><br>
                    <span class="fw-light text-secondary">{{$editDoc['year']}} / {{$editDoc['term']}}</span>
                    </td>
                    <td>
                    <span class="text-secondary">
                        {{$editDoc['lastUpdate']}}
                    </span>
                    </td>

                    <td>
                        @if($editDoc['karTerm'] && $editDoc['karkrongchip'])
                            <sapn class="text-dark">{{$editDoc['karTerm']}} / {{$editDoc['karkrongchip']}}</span>
                        @endif
                    </td>
                    <td>
                      @foreach($editDoc['comment'] as $comment)
                        <span class="text-danger">{{$comment['comname']}}: {{$comment['comdescript']}}</span>
                      @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
            <!-- End Dark Table -->
          </div>

        </div>
        <!--  card -->

          

        </div>
      </div>
      <!-- end card table -->

    </section>
@endsection