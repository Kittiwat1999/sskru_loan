@extends('borrower_layout')
@section('title')
index borrower
@endsection
@section('content')
    
    <section class="section dashboard">

            <!-- start card toggle -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">กรอกข้อมูล</h5>

          <ul class="nav nav-tabs" id="borderedTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link  active" id="borrower-information-tab" data-bs-toggle="tab" data-bs-target="#borrower-information" type="button" role="tab" aria-controls="borrower-information" aria-selected="true">ข้อมูลผู้กู้</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="parent-information-tab" data-bs-toggle="tab" data-bs-target="#parent-information" type="button" role="tab" aria-controls="parent-information" aria-selected="false">ข้อมูลผู้ปกครอง</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="representative-tab" data-bs-toggle="tab" data-bs-target="#representative" type="button" role="tab" aria-controls="representative" aria-selected="false">ผู้แทนโดยชอบธรรม</button>
            </li>
          </ul>
          <!-- toggle content -->
          <div class="tab-content" id="borderedTabContent">
            <!-- borrower information toggle -->
            <div class="tab-pane fade show active" id="borrower-information" role="tabpanel" aria-labelledby="borrower-information-tab">
              @include('loan_request/borrower_inform')
            </div>
            <!-- end borrower information toggle -->
            <!-- parent information toggle -->
            <div class="tab-pane fade" id="parent-information" role="tabpanel" aria-labelledby="parent-information-tab">
              @include('loan_request/parent_inform')
            </div>
            <!-- end parent information toggle -->

            <div class="tab-pane fade" id="representative" role="tabpanel" aria-labelledby="representative-tab">
              content
            </div>

          </div>
          <!-- end toggle content -->

        </div>
        <!-- end card body -->

      </div>
      <!-- end card toggle -->

    </section>

    <script>
      function ageCal(role){
        var inputBirthday = document.getElementById(role+'_birthday');
        // Get the input value
        var birthDate = inputBirthday.value;

        // Parse the selected date
        var selectedDate = new Date(birthDate);

        // Calculate the current date
        var currentDate = new Date();

        // Calculate the age
        var age = currentDate.getFullYear() - selectedDate.getFullYear();

        // Check if the birthday has already occurred this year
        if (currentDate.getMonth() < selectedDate.getMonth() || (currentDate.getMonth() === selectedDate.getMonth() && currentDate.getDate() < selectedDate.getDate())) {
            age--;
        }
        if(age<0){
          document.getElementById(role+'_age').value = "สวัสดีผู้มาจากอนาคต";
        }else{
          document.getElementById(role+'_age').value = age;
          if(age>=20){
            document.getElementById('representative-tab').disabled = true;
          }else{
            document.getElementById('representative-tab').disabled = false;

          }
        }

      }

        var idCardNumber = document.getElementById('idCardNumber');
        idCardNumber.onkeyup = () =>{
          document.getElementById('formattedNumber').innerHTML = idCardNumber.value;
          }
        
        var moreProps = document.getElementById('morePropCheck');
        moreProps.onchange = () => {
          const isdisabled = document.getElementById('moreProp').disabled;
          document.getElementById('moreProp').disabled = !isdisabled;
        }
    </script>
@endsection
