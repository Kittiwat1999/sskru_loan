<?php

namespace App\Http\Controllers;

use App\Enums\PolicyAction;
use App\Enums\PolicyStatus;
use App\Enums\PolicyType;
use App\Http\Controllers\Controller;
use App\Models\Policy;
use App\Models\PolicyChangeLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Psy\Util\Json;
use Yajra\DataTables\Facades\DataTables;

use function Laravel\Prompts\select;

class PolicyController extends Controller
{
    /**
     * Display list of policies
     */
    public function index()
    {
        return view('admin.policies.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $policies = Policy::with('creator')->orderBy('created_at', 'desc')
                ->select('policies.*');

            return DataTables::of($policies)
                ->addIndexColumn()
                ->addColumn('type', fn($policy) => PolicyType::from($policy->type)->label())
                ->addColumn('status', function ($policy) {
                    return PolicyStatus::from($policy->status)->badge();
                })
                ->addColumn('created_by', function ($policy) {
                    return optional($policy->creator)->firstname . ' ' . optional($policy->creator)->lastname;
                })
                ->addColumn('action', function ($policy) {
                    return view('admin.policies.action', compact('policy'))->render();
                })->addColumn('published', function ($policy) {
                    return view('admin.policies.publish-action', compact('policy'))->render();
                })
                ->rawColumns(['status', 'action', 'published'])
                ->make(true);
        }

        return response()->json(['error' => 'Not Found.'], 404);
    }
    /**
     * Show create form
     */
    public function create()
    {
        return view(
            'admin.policies.create'
        );
    }


    /**
     * Store new policy
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => [
                'required',
                Rule::enum(PolicyType::class)
            ],

            'title' => [
                'required',
                'string',
                'max:255'
            ],

            'version' => [
                'required',
                'string',
                'max:20'
            ],

            'content_html' => [
                'required'
            ]

        ], [
            'type.required' => 'กรุณาเลือกประเภทนโยบาย',
            'type.in' => 'ประเภทนโยบายไม่ถูกต้อง',

            'title.required' => 'กรุณาระบุชื่อนโยบาย',
            'title.string' => 'ชื่อนโยบายต้องเป็นข้อความ',
            'title.max' => 'ชื่อนโยบายต้องไม่เกิน 255 ตัวอักษร',

            'version.required' => 'กรุณาระบุเวอร์ชัน',
            'version.string' => 'เวอร์ชันต้องเป็นข้อความ',
            'version.max' => 'เวอร์ชันต้องไม่เกิน 20 ตัวอักษร',

            'content_html.required' => 'กรุณาระบุเนื้อหานโยบาย'
        ]);


        DB::transaction(function () use ($validated, &$policy, $request) {

            $policy = Policy::create([
                ...$validated,
                'status' => PolicyStatus::DRAFT->value,
                'created_by' => $request->session()->get('user_id'),
                'updated_by' => $request->session()->get('user_id')
            ]);


            PolicyChangeLog::create([
                'policy_id' => $policy->id,
                'action' => PolicyAction::CREATE->value,
                'description' => 'Create new Policy',
                'created_by' => $request->session()->get('user_id')
            ]);
        });

        return redirect()
            ->route('admin.policies.index')
            ->with(
                'success',
                'สร้างนโยบายสำเร็จ'
            );
    }


    /**
     * Show edit form
     */
    public function edit(Policy $policy)
    {
        return view(
            'admin.policies.edit',
            compact('policy')
        );
    }

    /**
     * Update policy
     */
    public function update(
        Request $request,
        Policy $policy
    ) {
        $validated = $request->validate([
            'type' => [
                'required',
                Rule::enum(PolicyType::class)
            ],

            'title' => [
                'required',
                'string',
                'max:255'
            ],

            'version' => [
                'required',
                'string',
                'max:20'
            ],

            'content_html' => [
                'required'
            ]

        ], [
            'type.required' => 'กรุณาเลือกประเภทนโยบาย',
            'type.in' => 'ประเภทนโยบายไม่ถูกต้อง',

            'title.required' => 'กรุณาระบุชื่อนโยบาย',
            'title.string' => 'ชื่อนโยบายต้องเป็นข้อความ',
            'title.max' => 'ชื่อนโยบายต้องไม่เกิน 255 ตัวอักษร',

            'version.required' => 'กรุณาระบุเวอร์ชัน',
            'version.string' => 'เวอร์ชันต้องเป็นข้อความ',
            'version.max' => 'เวอร์ชันต้องไม่เกิน 20 ตัวอักษร',

            'content_html.required' => 'กรุณาระบุเนื้อหานโยบาย'
        ]);


        DB::transaction(function () use ($validated, $policy, $request) {
            $policy->update([
                ...$validated,
                'updated_by' => $request->session()->get('user_id')
            ]);

            PolicyChangeLog::create([
                'policy_id' => $policy->id,
                'action' => PolicyAction::UPDATE->value,
                'description' => 'Update Policy',
                'created_by' => $request->session()->get('user_id')
            ]);
        });

        return redirect()
            ->route(
                'admin.policies.index'
            )
            ->with(
                'success',
                'แก้ไขนโยบายสำเร็จ'
            );
    }


    /**
     * Preview policy
     */
    public function preview(
        Policy $policy
    ) {
        return view(
            'admin.policies.preview',
            compact('policy')
        );
    }


    /**
     * Publish policy
     */
    public function publish(Request $request, Policy $policy)
    {
        if ($policy->status !== PolicyStatus::DRAFT->value) {
            return redirect()
                ->route('admin.policies.index')
                ->with(
                    'error',
                    'สามารถ Publish ได้เฉพาะ Draft'
                );
        }
        
        DB::transaction(function () use ($policy, $request) {
            Policy::where('type', $policy->type)
                ->where('status', PolicyStatus::PUBLISHED->value)
                ->update([
                    'status' => PolicyStatus::ARCHIVED->value,
                    'updated_by' => $request->session()->get('user_id')
                ]);

            $policy->update([
                'status' => PolicyStatus::PUBLISHED->value,
                'published_at' => now(),
                'effective_at' => now(),
                'updated_by' => $request->session()->get('user_id')
            ]);

            PolicyChangeLog::create([
                'policy_id' => $policy->id,
                'action' => PolicyAction::PUBLISH->value,
                'description' => 'Policy Published',
                'created_by' => $request->session()->get('user_id')
            ]);
        });

        return redirect()
            ->route('admin.policies.index')
            ->with('success', 'เผยแพร่นโยบายสำเร็จ');
    }

    /**
     * Archive policy
     */
    public function archive(Request $request, Policy $policy)
    {
        if ($policy->status !== PolicyStatus::PUBLISHED->value) {
            return redirect()
                ->route('admin.policies.index')
                ->with(
                    'error',
                    'สามารถ Archive ได้เฉพาะ Published'
            );
        }

        DB::transaction(function () use ($policy, $request) {
            $policy->update([
                'status' => PolicyStatus::ARCHIVED->value,
                'updated_by' => $request->session()->get('user_id')
            ]);
            PolicyChangeLog::create([
                'policy_id' => $policy->id,
                'action' => PolicyAction::ARCHIVE->value,
                'description' => 'Archive Policy',
                'created_by' => $request->session()->get('user_id')
            ]);
        });
        return redirect()
            ->route('admin.policies.index')
            ->with(
                'success',
                'จัดเก็บนโยบายสำเร็จ'
            );
    }

    public function restore(Request $request, Policy $policy) {
        if($policy->status !== PolicyStatus::ARCHIVED->value) {
            return redirect()
                ->route('admin.policies.index')
                ->with(
                    'error',
                    'สามารถ Restore ได้เฉพาะ Archived'
            );
        }

        DB::transaction(function () use ($policy, $request) {
            $policy->update([
                'status' => PolicyStatus::DRAFT->value,
                'updated_by' => $request->session()->get('user_id')
            ]);

            PolicyChangeLog::create([
                'policy_id' => $policy->id,
                'action' => PolicyAction::RESTORE,
                'description' => 'Restore Archived Policy to Draft',
                'created_by' => $request->session()->get('user_id')
            ]);
        });

        return redirect()
            ->route('admin.policies.index')
            ->with(
                'success',
                'คืนค่านโยบายสำเร็จ'
            );
    }
}
