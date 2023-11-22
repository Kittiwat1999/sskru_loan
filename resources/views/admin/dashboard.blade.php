@extends('layout')
@section('title')
admin index
@endsection
@section('content')
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-5">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">ยอดผู้กู้</h5>
                        <!-- pink 255, 99, 132;  primay 54, 162, 235 ;warning 255, 205, 86-->
                      <!-- Pie Chart -->
                      <canvas id="pieChart" style="max-height: 360px;"></canvas>
                      <script>
                        document.addEventListener("DOMContentLoaded", () => {
                          new Chart(document.querySelector('#pieChart'), {
                            type: 'pie',
                            data: {
                              labels: [
                                'อนุมัติแล้ว',
                                'ต้องแก้ใข',
                                'รออนุมัติ'
                              ],
                              datasets: [{
                                label: 'My First Dataset',
                                data: [300, 50, 100],
                                backgroundColor: [
                                  'rgb(54, 162, 235)',
                                  'rgb(255, 99, 132)',
                                  'rgb(255, 205, 86)'
                                ],
                                hoverOffset: 4
                              }]
                            }
                          });
                        });
                      </script>
                      <!-- End Pie CHart -->
        
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Filter</h5>
                        <form class="row" action="">
                            <div class="col-md-6">
                                <label for="borrower-type" class="col-form-label text-secondary">ประเภทผู้กู้</label>
                                <select id="borrower-type" class="form-select" aria-label="Default select example" name="borrower-type">
                                    <option disabled selected>ทั้งหมด</option>
                                    <option value="1">รายใหม่</option>
                                    <option value="2">รายเก่า</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="borrower-character" class="col-form-label text-secondary">สักษณะผู้กู้</label>
                                <select id="borrower-character" class="form-select" aria-label="Default select example" name="borrower-character">
                                    <option disabled selected>ทั้งหมด</option>
                                    <option value="1">ขาดแคลนคุณทรัพย์</option>
                                    <option value="2">สาขาที่เป็นความต้องการหลัก</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="faculty" class="col-form-label text-secondary">ภาคเรียน</label>
                                <select id="faculty" class="form-select" aria-label="Default select example" name="faculty">
                                    <option disabled selected>เลือกภาคเรียน</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                            </div>
                            <div class="col-md-3 mt-2">
                                <label for="yearStadies" class="form-label text-secondary">ปีการศึกษา</label>
                                <input type="text" class="form-control" id="yearStadies" name="yearStadies">
                            </div>
                            <div class="col-md-3 mt-2">
                                <label for="yearStadies" class="form-label text-secondary">ถึงปีการศึกษา</label>
                                <input type="text" class="form-control" id="yearStadies" name="yearStadies">
                            </div>
                            <div class="col-md-6">
                                <label for="faculty" class="col-form-label text-secondary">คณะ</label>
                                <select id="faculty" class="form-select" aria-label="Default select example" name="faculty">
                                    <option disabled selected>ทั้งหมด</option>
                                    <option value="1">ศิลปศาสตร์</option>
                                    <option value="2">วิศวกรรมศาสตร์</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="faculty" class="col-form-label text-secondary">สาขา</label>
                                <select id="faculty" class="form-select" aria-label="Default select example" name="faculty">
                                    <option disabled selected>ทั้งหมด</option>
                                    <option value="1">วิศวกรรมโยธา</option>
                                    <option value="2">วิศวกรรมยาโธ</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="grade" class="col-form-label text-secondary">ชั้นปี</label>
                                <select id="grade" class="form-select" aria-label="Default select example" name="grade">
                                    <option selected value="*">ทั้งหมด</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option></option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="text-end mt-3">
                            <!-- reset Modal-->
                                <button type="reset" class="btn btn-secondary">reset</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="card-title">จำนวนเงินที่เบิก</div>
                  <canvas id="lineChart" style="max-height: 400px;"></canvas>
                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new Chart(document.querySelector('#lineChart'), {
                        type: 'line',
                        data: {
                          labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                          datasets: [{
                            label: 'Line Chart',
                            data: [65, 59, 80, 81, 56, 55, 40],
                            fill: false,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                          }]
                        },
                        options: {
                          scales: {
                            y: {
                              beginAtZero: true
                            }
                          }
                        }
                      });
                    });
                  </script>
                  <!-- End Line CHart -->
                </div>
              </div>
            </div>
        </div>
    </section>
@endsection
