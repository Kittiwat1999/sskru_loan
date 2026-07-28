<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Policy;
use App\Models\PolicyChangeLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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


    private function translateTypeToThai(string $type): string
    {
        switch ($type) {
            case 'terms':
                $thaiText = 'ข้อตกลงและเงื่อนไขการใช้งานระบบ (Terms of Use)';
                break;
            case 'privacy':
                $thaiText = 'นโยบายความเป็นส่วนตัว (Privacy Policy)';
                break;
            case 'pdpa':
                $thaiText = 'ประกาศการคุ้มครองข้อมูลส่วนบุคคล (PDPA Notice)';
                break;
            default:
                $thaiText = 'ประเภทของนโยบายนี้ไม่รองรับ';
        }
        return $thaiText;
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $policies = Policy::with('creator')->orderBy('created_at', 'desc')
                ->select('policies.*');

            return DataTables::of($policies)
                ->addIndexColumn()
                ->addColumn('type', fn($policy) => $this->translateTypeToThai($policy->type))
                ->addColumn('status', function ($policy) {
                    return match ($policy->status) {
                        'published' => '<span class="badge bg-success">เผยแพร่แล้ว</span>',
                        'draft' => '<span class="badge bg-warning text-dark">ฉบับร่าง</span>',
                        'archived' => '<span class="badge bg-secondary">จัดเก็บแล้ว</span>',
                    };
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
                'in:terms,privacy,pdpa'
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
                'status' => 'draft',
                'created_by' => $request->session()->get('user_id'),
                'updated_by' => $request->session()->get('user_id')
            ]);


            PolicyChangeLog::create([
                'policy_id' => $policy->id,

                'action' => 'create',

                'description' =>
                'Create new Policy',

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
                'in:terms,privacy,pdpa'
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
                'action' => 'update',
                'description' =>
                'Update Policy',
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
        if ($policy->status !== 'draft') {
            return back()->withErrors([
                'publish' => 'สามารถ Publish ได้เฉพาะ Draft'
            ]);
        }
        
        DB::transaction(function () use ($policy, $request) {
            Policy::where('type', $policy->type)
                ->where('status', 'published')
                ->update([
                    'status' => 'archived',
                    'updated_by' => $request->session()->get('user_id')
                ]);

            $policy->update([
                'status' => 'published',
                'published_at' => now(),
                'effective_at' => now(),
                'updated_by' => $request->session()->get('user_id')
            ]);

            PolicyChangeLog::create([
                'policy_id' => $policy->id,
                'action' => 'publish',
                'description' => 'Policy Published',
                'created_by' => $request->session()->get('user_id')
            ]);
        });

        return redirect()->route('admin.policies.index')->with('success', 'เผยแพร่นโยบายสำเร็จ');
    }

    /**
     * Archive policy
     */
    public function archive(Request $request, Policy $policy)
    {
        if ($policy->status !== 'published') {
            return back()->withErrors([
                'archived' => 'สามารถ archived ได้เฉพาะ publish'
            ]);
        }

        DB::transaction(function () use ($policy, $request) {
            $policy->update([
                'status' => 'archived',
                'updated_by' => $request->session()->get('user_id')
            ]);
            PolicyChangeLog::create([
                'policy_id' => $policy->id,
                'action' => 'archive',
                'description' => 'Archive Policy',
                'created_by' => $request->session()->get('user_id')
            ]);
        });
        return redirect()
            ->back()
            ->with(
                'success',
                'จัดเก็บนโยบายสำเร็จ'
            );
    }

    public function restore(Request $request, Policy $policy) {
        if($policy->status !== 'archived') {
            return back()->withErrors([
                'archived' => 'สามารถ restore ได้เฉพาะ archived',
            ]);
        }

        DB::transaction(function () use ($policy, $request) {
            $policy->update([
                'status' => 'draft',
                'updated_by' => $request->session()->get('user_id')
            ]);

            PolicyChangeLog::create([
                'policy_id' => $policy->id,
                'action' => 'restore',
                'description' => 'Restore Archived Policy to Draft',
                'created_by' => $request->session()->get('user_id')
            ]);
        });

        return redirect()
            ->back()
            ->with(
                'success',
                'คืนค่านโยบายสำเร็จ'
            );
    }
}
