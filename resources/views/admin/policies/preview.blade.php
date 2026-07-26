@extends('layout')
@section('title')
ดูตัวอย่างนโยบาย
@endsection
@section('content')
    <div class="section dashboard">
        <div class="card">
            <div class="card-header">
                <h4>
                    {{ $policy->title }}
                </h4>
                <div>

                    Version:
                    {{ $policy->version }}

                </div>
            </div>
            <div class="card-body">
                {!! $policy->content_html !!}
                <a href="{{ route('admin.policies.index') }}" class="btn btn-secondary">
                    ย้อนกลับ
                </a>
            </div>
        </div>
    </div>
@endsection
