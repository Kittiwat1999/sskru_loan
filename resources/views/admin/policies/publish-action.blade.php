@if($policy->status == 'draft')
<form action="{{ route('admin.policies.publish',$policy->id) }}"
      method="POST"
      class="d-inline">
    @csrf
    <button class="btn btn-sm btn-success">
        เผยแพร่
    </button>
</form>
@endif

@if($policy->status == 'published')
<form action="{{ route('admin.policies.archive',$policy->id) }}"
      method="POST"
      class="d-inline">
    @csrf
    <button class="btn btn-sm btn-secondary">
        เก็บถาวร
    </button>
</form>
@endif

@if($policy->status == 'archived')
<form action="{{ route('admin.policies.restore',$policy->id) }}"
      method="POST"
      class="d-inline">
    @csrf
    <button class="btn btn-sm btn-primary">
        คืนค่า
    </button>
</form>
@endif