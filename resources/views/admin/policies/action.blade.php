<a href="{{ route('admin.policies.preview',$policy->id) }}"
   class="btn btn-sm btn-primary text-white">
    ดูตัวอย่าง
</a>

@if($policy->isDraft())
<a href="{{ route('admin.policies.edit',$policy->id) }}"
   class="btn btn-sm btn-warning">
    แก้ไข
</a>
@endif