@extends('layout')
@section('title')
index borrower
@endsection
@section('content')
    
    <section class="section dashboard">
      <div class="card pt-3">
        <div class="card-body">
            <div class="row">
            <div class="container-fluid align-items-center p-0 m-0">
                <div class="d-flex justify-content-around p-0 m-0">
                    <div class="d-flex flex-column">
                            <div class="text-center mb-1">
                                <button
                                    class="btn bg-primary text-white btn-sm rounded-pill"
                                    style="width: 2rem; height: 2rem"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#company3"
                                    aria-expanded="false"
                                    aria-controls="company3"
                                    onclick="stepFunction(event)"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </div>
                            <small class="text-primary text-center text-progress-step fw-bold">กรอกข้อมูล</small>
                        </div>
                        <span
                            class="bg-secondary w-25 rounded mt-3 me-1 ms-1"
                            style="height: 0.17rem"
                        >
                        </span>
                        <div class="d-flex flex-column">
                            <div class="text-center  mb-1">
                                <button
                                    class="btn bg-secondary text-white btn-sm rounded-pill"
                                    style="width: 2rem; height: 2rem"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#company3"
                                    aria-expanded="false"
                                    aria-controls="company3"
                                    onclick="stepFunction(event)"
                                >
                                  <i class="bi bi-file-earmark-arrow-down"></i>
                                </button>
                            </div>
                            <small class="text-secondary text-center text-progress-step fw-bold">ดาวน์โหลด</small>
                        </div>
                        <span
                            class="bg-secondary w-25 rounded mt-3 me-1 ms-1"
                            style="height: 0.17rem"
                        >
                        </span>
                        <div class="d-flex flex-column">
                            <div class="text-center  mb-1">
                                <button
                                    class="btn bg-secondary text-white btn-sm rounded-pill"
                                    style="width: 2rem; height: 2rem"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#company3"
                                    aria-expanded="false"
                                    aria-controls="company3"
                                    onclick="stepFunction(event)"
                                >
                                <i class="bi bi-file-earmark-arrow-up"></i>
                                </button>
                            </div>
                            <small class="text-secondary text-center text-progress-step fw-bold">ส่งเอกสาร</small>
                        </div>
                        
                        <span
                            class="bg-secondary w-25 rounded mt-3 me-1 ms-1"
                            style="height: 0.17rem"
                        >
                        </span>
                        <div class="d-flex flex-column">
                            <div class="text-center  mb-1">
                                <button
                                    class="btn bg-secondary text-white btn-sm rounded-pill"
                                    style="width: 2rem; height: 2rem"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#company3"
                                    aria-expanded="false"
                                    aria-controls="company3"
                                    onclick="stepFunction(event)"
                                >
                                    <i class="bi bi-check-circle"></i>
                                </button>
                            </div>
                            <small class="text-secondary text-center text-progress-step fw-bold">สถานะเอกสาร</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($page == "information")
      @include('borrower/new_loan_information')
    @elseif($page == "document")
      @include('borrower/new_loan_send_document')
    @elseif($page == "download")
      @include('borrower/new_loan_download_document')
    @elseif($page == "samary" || $page == "success")
      @include('borrower/new_loan_sammary')
    @endif
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
      function nextPgae(page){
        console.log(page);
        document.getElementById(page).click();
        window.scrollTo(0, 0);
      }

      function generateSelectProvince(elementId){
        console.log(elementId);
      }
    </script>
@endsection
