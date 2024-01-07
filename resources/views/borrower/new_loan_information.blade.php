
      <!-- start card toggle -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">กรอกข้อมูล</h5>

          <ul class="nav nav-tabs" id="borderedTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="borrower-information-tab" data-bs-toggle="tab" data-bs-target="#borrower-information" type="button" role="tab" aria-controls="borrower-information" aria-selected="true">ข้อมูลผู้กู้</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="parent-information-tab" data-bs-toggle="tab" data-bs-target="#parent-information" type="button" role="tab" aria-controls="parent-information" aria-selected="false">ข้อมูลผู้ปกครอง</button>
            </li>
          </ul>
          <!-- toggle content -->
          <div class="tab-content" id="borderedTabContent">
            <!-- borrower information toggle -->
            <div class="tab-pane fade show active" id="borrower-information" role="tabpanel" aria-labelledby="borrower-information-tab">
              @include('borrower/information/borrower')
            </div>
            <!-- end borrower information toggle -->
            <!-- parent information toggle -->
            <div class="tab-pane fade" id="parent-information" role="tabpanel" aria-labelledby="parent-information-tab">
              @include('borrower/information/parent')
            </div>
            <!-- end parent information toggle -->

          </div>
          <!-- end toggle content -->

        </div>
        <!-- end card body -->

      </div>
      <!-- end card toggle -->