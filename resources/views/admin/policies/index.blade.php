@extends('layouts.app')
@section('title')
นโยบาย
@endsection
@section('content')
<div class="section dashboard">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4>
            การจัดการนโยบาย
        </h4>

        <a href="{{ route('admin.policies.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i>
            ร่างนโยบาย
        </a>

    </div>

    <div class="card">
        <div class="card-body pt-4 pb-2">
            <div class="table-responsive">
                <table class="table table-bordered"
                    id="policy-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ประเภท</th>
                            <th>นโยบาย</th>
                            <th>เวอร์ชั่น</th>
                            <th>สถานะ</th>
                            <th>ผู้สร้าง</th>
                            <th>ดู/แก้ไข</th>
                            <th>เผยแพร่/เก็บถาวร</th>

                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="archiveModal" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="archiveModalLabel">จัดเก็บนโยบาย</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ท่านต้องการจัดเก็บนโยบาย <span class="text-danger"></span> หรือไม่
                </div>
                <div class="modal-footer">
                    <form id="archiveForm" action=""
                        method="POST"
                        class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-secondary">
                            จัดเก็บ
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ยกเลิก</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
        $('#policy-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.policies.data') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'version',
                    name: 'version'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'created_by',
                    name: 'created_by'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'published',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });

    $('#archiveModal').on('show.bs.modal', function(event) {
        let button = $(event.relatedTarget);
        let policyId = button.data('policy-id');
        let policyTitle = button.data('policy-title');
        let form = $('#archiveForm');
        let modalBody = $('#archiveModal').find('.modal-body .text-danger');
        let actionUrl = "{{ route('admin.policies.archive', 'POLICY_ID') }}";

        actionUrl = actionUrl.replace('POLICY_ID', policyId);
        form.attr('action', actionUrl);
        modalBody.text(policyTitle);
    });
</script>
@endsection