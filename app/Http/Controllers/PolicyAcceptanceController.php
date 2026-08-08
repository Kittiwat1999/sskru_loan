<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use Illuminate\View\View;
use App\Enums\PolicyStatus;
use App\Services\PublishedPolicyCacheService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PolicyAcceptance;
use App\Services\PolicyAcceptanceService;

class PolicyAcceptanceController extends Controller
{
    private PublishedPolicyCacheService $cacheService;

    public function __construct(
        PublishedPolicyCacheService $cacheService,
        private PolicyAcceptanceService $acceptanceService
    ) {
        $this->cacheService = $cacheService;
        $this->acceptanceService = $acceptanceService;
    }

    /**
     * ST3-002
     */
    public function index(): View
    {
        $published = $this->cacheService->getAll();

        $policies = Policy::query()
            ->whereIn(
                'id',
                collect($published)
                    ->pluck('id')
            )
            ->orderByRaw("
                FIELD(type, 'terms', 'privacy', 'pdpa')
            ")
            ->get();

        if(!$policies->count()) {
            abort(404);
        }

        return view(
            'policies.acceptance',
            [
                'policies' => $policies,
            ]
        );
    }

    /**
     * ST3-003
     */
    public function show(): View
    {
        $published = $this->cacheService->getAll();

        $policies = Policy::query()
            ->whereIn(
                'id',
                collect($published)
                    ->pluck('id')
            )
            ->orderByRaw("
                FIELD(type, 'terms', 'privacy', 'pdpa')
            ")
            ->get();
        
        if(!$policies->count()) {
            abort(404);
        }

        return view(
            'policies.show',
            [
                'policies' => $policies,
            ]
        );
    }

    public function accept(Request $request)
    {
        $request->validate([
            'accepted' => [
                'required',
                'accepted'
            ],
        ]);

        $userId = $request->session()->get('user_id');

        if (!$userId) {

            return redirect()
                ->route('login');

        }

        $this->acceptanceService->accept(
            $userId,
            $request->ip(),
            $request->userAgent()
        );

        return redirect()
            ->to('/');
    }
}
