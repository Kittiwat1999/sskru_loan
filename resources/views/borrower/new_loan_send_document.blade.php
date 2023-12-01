<div class="card">
    <dic class="card-body">
        <h5 class="card-title">ส่งเอกสาร</h5>
        <form class="row">
            <div class="col-md-2 text-end pt-2">
                <label for="downdoadbutton" class="form-label text-secondary">ดาวน์โหลดไฟล์</label>
            </div>
            <div class="col-md-10">
                <button type="button" class="btn btn-primary w-50"name="downdoadbutton" id="downdoadbutton">ดาวน์โหลดไฟล์</button>
            </div>
            <div class="col-md-12 m-2"></div>
            <div class="col-md-2 text-end pt-2">
                <label for="examplefile" class="form-label text-secondary">เลือกไฟล์</label>
            </div>
            <div class="col-md-10">
                <input type="file" placeholder="helo" name="examplefile" id="examplefile">
            </div>
            <div class="text-end">
            <!-- reset Modal-->
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#basicModal">
                    ล้างข้อมูล
                </button>
                <div class="modal fade" id="basicModal" tabindex="-1">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">ล้างข้อมูล</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="text-center">
                                ท่านต้องการล้างขอมูลบนฟอร์มหรือไม่
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ไม่</button>
                            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">ล้างข้อมูล</button>
                        </div>
                    </div>
                    </div>
                </div><!-- End reset Modal-->
                <button type="button" class="btn btn-primary" onclick="nextPgae('')">บันทึกข้อมูล</button>
            </div>
        </form>
    </dic>
</div>