@extends('layout')
@section('title')
@endsection
@section('content')
      <!-- start card toggle -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">กรอกข้อมูล</h5>
          @include('borrower/information/input_information')

        </div>
        <!-- end card body -->

      </div>
      <!-- end card toggle -->
      <script>
        function ageCal(role){
        if(role == "")role = "";
        var inputBirthday = document.getElementById(role+'birthday');
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
          document.getElementById(role+'age').value = "สวัสดีผู้มาจากอนาคต";
        }else{
          document.getElementById(role+'age').value = age;
          // if(age>=20){
          //   document.getElementById('representative-tab').disabled = true;

          // }else{
          //   document.getElementById('representative-tab').disabled = false;
          // }
        }

      }

        // var idCardNumber = document.getElementById('idCardNumber');
        // idCardNumber.onkeyup = () =>{
        //   document.getElementById('formattedNumber').innerHTML = idCardNumber.value;
        //   }
        
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


      function submitInformation(){
        document.querySelector('#form-information').submit();
      }

      function generateSelectProvince(elementId){
        console.log(elementId);
      }

      //who call address zipcode


      function addressWithZipcode(zip_code_input, caller){
        fetch('https://raw.githubusercontent.com/kongvut/thai-province-data/master/api_tambon.json')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // console.log(zip_code_input);
            var tambons = [];
            var aumphureId = '';
            for(tambon of data){
                if(zip_code_input == tambon.zip_code){
                    // console.log(tambon.name_th)
                    tambons.push(tambon.name_th.toString());
                    if(aumphureId == '')aumphureId = tambon.amphure_id;
                }
            }
            // console.log(tambons);
            var selectElement = document.getElementById(`${caller}_tambon`);
            for(tb of tambons){
                var newOption = document.createElement('option');

                newOption.value = tb;
                newOption.text = tb;

                selectElement.add(newOption);
            }
            
            getAumphure(aumphureId,caller)
            

        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
      }
      function getAumphure(amphure_id,caller){
          // console.log(amphure_id);
          fetch('https://raw.githubusercontent.com/kongvut/thai-province-data/master/api_amphure.json')
              .then(response => {
                  if (!response.ok) {
                      throw new Error('Network response was not ok');
                  }
                  return response.json();
              })
              .then(aumphures => {
                  var province_id = '';
                  for(aumphure of aumphures){
                      if(amphure_id == aumphure.id){
                      document.getElementById(`${caller}_aumphure`).value = aumphure.name_th;
                      if(province_id == '')province_id = aumphure.province_id;
                      }
                  }
                  getProvince(province_id,caller);
              })
              .catch(error => {
                  console.error('Fetch error:', error);
              });
      }

      function getProvince(province_id,caller){
          // console.log(province_id);
          fetch('https://raw.githubusercontent.com/kongvut/thai-province-data/master/api_province.json')
              .then(response => {
                  if (!response.ok) {
                      throw new Error('Network response was not ok');
                  }
                  return response.json();
              })
              .then(provinces => {
                  for(province of provinces){
                      if(province_id == province.id)document.getElementById(`${caller}_province`).value = province.name_th;
                  }
                  
              })
              .catch(error => {
                  console.error('Fetch error:', error);
              });
      }

      function enableInputCountry(parentNo,isthai){
        console.log(parentNo)
        if(isthai == `${parentNo}_not_thai`){
            document.querySelector(`#${parentNo}_nationality`).disabled = false;
        }else{
            document.querySelector(`#${parentNo}_nationality`).disabled = true;
        }

      }

      const MaritalStat = document.getElementById('maritalStatusId');
      MaritalStat.onchange = () =>{
          const otherMaritalStat = document.getElementById('other');
          if(otherMaritalStat.checked){
              document.getElementById('otherText').disabled = false;
          }else{
              document.getElementById('otherText').disabled = true;
          }
          
          const devorce = document.getElementById('devorce');
          if(devorce.checked){
              document.getElementById('devorceFile').disabled = false;
          }else{
              document.getElementById('devorceFile').disabled = true;
          }
      }

      const address_currently_with_borrower = document.getElementById('address_currently_with_borrower');
      address_currently_with_borrower.addEventListener("change", function() {
          if (address_currently_with_borrower.checked) {
              console.log('checked')
              const address_input = document.querySelectorAll('.fake-class');
              address_input.forEach((e)=>{
                  e.disabled = true;
                  e.value = "";
              });
          } else {
              const address_input = document.querySelectorAll('.fake-class');
              address_input.forEach((e)=>{
                  e.disabled = false;
                  e.value = "";
              });
          }
      });
      </script>
@endsection
