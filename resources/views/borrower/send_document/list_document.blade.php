@extends('layout')
@section('content')
    <section>
        <div class="row">
          @if(count($documents) == 0)
          <div class="col-md-4">
            <div class="card mb-3">
              <div class="row">
                <div class="col-sm-4">
                  <button class="button-missing">
                    <i class="bi bi-exclamation-square icon-missing"></i>
                  </button>
                </div>
                <div class="col-sm-8">
                  <div class="card-body">
                    <h5 class="card-title">ระบบยังไม่เปิดให้ส่งเอกสาร</h5>
                    <p><span class="text-secondary">ระบบอาจปิดรับเอกสารแล้ว</span></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endif
          @foreach ($documents as $document)
            @if ($document->borrower_status == 'sending')
              <div class="col-md-4 col-sm-12">
                <div class="card mb-3 card-menu-opening" onclick="gotoSendDoumnetPage('{{$document->id}}')">
                  <div class="row">
                    <div class="col-sm-4">
                      <button class="button-opening">
                        <i class="bi bi-file-earmark-text icon-opening"></i>
                      </button>
                    </div>
                    <div class="col-sm-8">
                      <div class="card-body">
                        <h5 class="card-title">{{$document->doctype_title}}</h5>
                        <p><span class="text-secondary">ส่งได้ถึงวันที่:</span> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $document->end_date)->format('d-m-Y')}}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <a href="{{route('borrower.upload.document.page',['document_id' => Crypt::encryptString($document->id)])}}" id="a-{{$document->id}}" class="d-none"></a>
            @else
              <div class="col-md-4 col-sm-12">
                <div class="card mb-3 card-menu-success">
                  <div class="row">
                    <div class="col-sm-4">
                      <button class="button-success">
                        <i class="bi bi-file-earmark-text icon-success"></i>
                      </button>
                    </div>
                    <div class="col-sm-8">
                      <div class="card-body">
                        <h5 class="card-title">{{$document->doctype_title}}</h5>
                        <p><span class="text-success">ส่งเอกสารแล้ว</span></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endif
          @endforeach
        </div>
    </section>
@endsection

@section('script')
<script>
  function gotoSendDoumnetPage(document_id){
    const a_link = document.getElementById('a-'+document_id)
    a_link.click();
  }
</script>
@endsection