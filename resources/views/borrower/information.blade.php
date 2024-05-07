@extends('layout')
@section('title')
@endsection
@section('content')
    <!-- start card toggle -->
    <div class="card">
        <div class="card-body">
        {{-- <h5 class="card-title">กรอกข้อมูล</h5> --}}
            <div class="col-md-12 my-4">
                <h5 class="text-primary">ข้อมูลผู้กู้</h5>
                <div class="col-md-11 line-section mt-2"></div>
            </div>

            @if(isset($borrower))
                @include('borrower/information/borrower_have_data')
            @else
                @include('borrower/information/input_information')
            @endif

        </div>
        <!-- end card body -->

    </div>
    <!-- end card toggle -->

@endsection
@section('script')
    <script>
        //check if no data ckecked

    const faculty = document.getElementById('faculty');
    faculty.addEventListener('change', async function() {

        fetch(`/borrower/major_by_faculty/${this.value}`)
        .then((response) => response.json())
        .then((data) => {
            majorOprionChange(data);// Process the data here
        })
        .catch((error) => {
            console.error("Error fetching data:", error);
        });
    });

    function majorOprionChange(majors){
        const major = document.getElementById('major');
        major.innerHTML = '<option disabled selected value="">เลือกสาขา</option>';
        major.innerHTML += majors.map(major =>{
            return `<option value="${major.major_name}">${major.major_name}</option>`;
        }).join("");
    }

    function parenat2NoData(){
        const parent2_no_data = document.getElementById('parent2_no_data');
        var parent2_element = document.querySelectorAll(`#parent2_is_thai, 
                                                #parent2_not_thai, 
                                                #parent2_is_alive,
                                                #parent2_no_alive,
                                                #parent2_relational,
                                                #parent2_prefix,
                                                #parent2_firstname,
                                                #parent2_lastname,
                                                #parent2_birthday,
                                                #parent2_age,
                                                #parent2_citizen_id,
                                                #parent2_phone,
                                                #parent2_occupation,
                                                #parent2_income,
                                                #parent2_is_main_parent
                                                `);

        // disable of required
        if(parent2_no_data.checked){
            parent2_element.forEach((e)=>{
                e.disabled = true;
                e.required = false;
            });
        }else{
            parent2_element.forEach((e)=>{
                e.disabled = false;
                e.required = true;
            });
        }
    }

    function ageCal(role) {
        var inputBirthday = document.getElementById(role + '_birthday');
        // Get the input value (assuming it's in the format "d-m-y")
        var birthDate = inputBirthday.value;

        // Parse the selected date
        var dateParts = birthDate.split('-');
        var selectedDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]); // Month is 0-based

        // Calculate the current date
        var currentDate = new Date();

        // Convert the current year to the Buddhist calendar (543 years ahead)
        var buddhistCurrentYear = currentDate.getFullYear() + 543;

        // Calculate the age
        var age = buddhistCurrentYear - (selectedDate.getFullYear());

        // Check if the birthday has already occurred this year
        if (currentDate.getMonth() < selectedDate.getMonth() || (currentDate.getMonth() === selectedDate.getMonth() && currentDate.getDate() < selectedDate.getDate())) {
            age--;
        }

        if (age < 0) {
            document.getElementById(role + '_age').value = "สวัสดีผู้มาจากอนาคต";
        } else {
            document.getElementById(role + '_age').value = age;
        }
    }

    // var idCardNumber = document.getElementById('idCardNumber');
    // idCardNumber.onkeyup = () =>{
    //   document.getElementById('formattedNumber').innerHTML = idCardNumber.value;
    //   }
    
    var moreProps = document.getElementById('morePropCheck');
    moreProps.onchange = () => {
        const moreProp = document.getElementById('moreProp');
        moreProp.value = "";
        moreProp.disabled = !moreProp.disabled;
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
            // else if(response.length == 0){
            //     console.log('no data');
            // }
            return response.json();
        })
        .then(data => {
            if(data.length == 0){
                console.log('no data');
            }
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
            selectElement.innerHTML+='<option disabled selected value="">เลือกตำบล</option>';
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
        if(isthai == `${parentNo}_not_thai`){
            document.querySelector(`#div_${parentNo}_citizen_id`).innerHTML=`<input type="text" class="form-control" id="${parentNo}_citizen_id" name="${parentNo}_citizen_id" required>`
            document.querySelector(`#${parentNo}_nationality`).disabled = false;
            document.querySelector(`#${parentNo}_nationality`).required = true;
        }else{
            document.querySelector(`#div_${parentNo}_citizen_id`).innerHTML=`<input type="text" class="form-control" id="${parentNo}_citizen_id" name="${parentNo}_citizen_id" maxlength="17" oninput="formatThaiID(this)" required>`
            document.querySelector(`#${parentNo}_nationality`).disabled = true;
            document.querySelector(`#${parentNo}_nationality`).required = false;
        }

    }

    const MaritalStat = document.getElementById('maritalStatusId');
    MaritalStat.onchange = () =>{
        const otherMaritalStat = document.getElementById('other');
        if(otherMaritalStat.checked){
            document.getElementById('otherText').disabled = false;
            document.getElementById('otherText').required = true;
        }else{
            document.getElementById('otherText').disabled = true;
            document.getElementById('otherText').required = false;

        }
        
        const devorce = document.getElementById('devorce');
        if(devorce.checked){
            document.getElementById('devorceFile').disabled = false;
            document.getElementById('devorceFile').required = true;
        }else{
            document.getElementById('devorceFile').disabled = true;
            document.getElementById('devorceFile').required = false;

        }
    }

    const address_currently_with_borrower = document.getElementById('address_currently_with_borrower');
    address_currently_with_borrower.addEventListener("change", function() {
        if (address_currently_with_borrower.checked) {
            console.log('checked')
            const address_input = document.querySelectorAll('.fake-class');
            address_input.forEach((e)=>{
                e.disabled = true;
                e.required = false;
                e.value = "";
            });
        } else {
            const address_input = document.querySelectorAll('.fake-class');
            address_input.forEach((e)=>{
                e.disabled = false;
                e.required = true;
                e.value = "";
            });
        }
    });


    function mainparent_label(value,parent){
        const label_element = document.getElementById(`label_${parent}_is_main_parent`);
        const parent_prefix = document.getElementById(`${parent}_prefix`).value;
        if(parent_prefix != undefined){
            label_element.innerText = `${parent_prefix}${value}`;
        }else{
            label_element.innerText = `${value}`;
        }
    }

    function disabledMainParentRadio(alive,parent){
        const parent_element = document.getElementById(`${parent}_is_main_parent`)
        if(alive){
            parent_element.disabled = false;
        }else{
            parent_element.disabled = true;
            parent_element.checked = false;
        }
    }

    function formatThaiID(input) {
        if(input.name == 'citizen_id'){
            const digits = input.value.replace(/\D/g, '');
            const formatted = digits.replace(
                /^(\d{1})(\d{4})(\d{5})(\d{2})(\d{1})$/,
                '$1-$2-$3-$4-$5'
            );
            input.value = formatted;
        }else{
            var parent = (input.name == 'parent1_citizen_id') ? "1" : "2";
            var parent_is_thai = document.getElementById(`parent${parent}_is_thai`).checked;
            console.log(parent);

            if(parent_is_thai){
                input.maxlength = '17';
                const digits = input.value.replace(/\D/g, '');
                const formatted = digits.replace(
                    /^(\d{1})(\d{4})(\d{5})(\d{2})(\d{1})$/,
                    '$1-$2-$3-$4-$5'
                );
                input.value = formatted;
            }
        }
    }

    function formatIncome(input) {
        // ลบตัวอักษรที่ไม่ใช่ตัวเลขและคอมมา
        const digits = input.value.replace(/[^\d]/g, '');

        // แบ่งกลุ่มตัวเลขเป็นสามหลักจากขวาไปซ้ายและใส่คอมมา
        const formatted = digits.replace(
            /\B(?=(\d{3})+(?!\d))/g,
            ','
        );

        // อัพเดตค่าของ input
        input.value = formatted;
    }
    function parentRelational(parent,relation){
        if(relation == 'อื่นๆ'){
            document.getElementById(`${parent}_cutiom_relational`).disabled = false;
            document.getElementById(`${parent}_cutiom_relational`).required = true;
            document.getElementById(`${parent}_relational`).value = '';
        }else{
            document.getElementById(`${parent}_cutiom_relational`).disabled = true;
            document.getElementById(`${parent}_cutiom_relational`).required = false;
            document.getElementById(`${parent}_relational`).value = relation;
        }
    }

    function setCustomRelational(parent,customRelation){
        document.getElementById(`${parent}_relational`).value = customRelation;
    }

    $("#borrower_birthday").datetimepicker({
        disabled:false,
        format: 'd-m-Y', 
        timepicker: false, 
        yearOffset: 543, 
        closeOnDateSelect: true,
    });
    $("#parent1_birthday").datetimepicker({
        disabled:false,
        format: 'd-m-Y', 
        timepicker: false, 
        yearOffset: 543, 
        closeOnDateSelect: true,
    });
    $("#parent2_birthday").datetimepicker({
        disabled:false,
        format: 'd-m-Y', 
        timepicker: false, 
        yearOffset: 543, 
        closeOnDateSelect: true,
    });

    
    </script>
      
@endsection
