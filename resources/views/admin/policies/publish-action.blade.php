@if($policy->isDraft())
<form action="{{ route('admin.policies.publish',$policy->id) }}"
    method="POST"
    class="d-inline">
    @csrf
    <button class="btn btn-sm btn-success">
        เผยแพร่
    </button>
</form>
@endif

@if($policy->isPublished())
<button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#archiveModal" data-policy-id="{{ $policy->id }}" data-policy-title="{{ $policy->title }}">
    เก็บถาวร
</button>
@endif

@if($policy->isArchived())
<form action="{{ route('admin.policies.restore',$policy->id) }}"
    method="POST"
    class="d-inline">
    @csrf
    <button class="btn btn-sm btn-primary">
        คืนค่า
    </button>
</form>
@endif