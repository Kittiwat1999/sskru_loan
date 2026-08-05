<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\PolicyAcceptanceService;
use App\Services\PublishedPolicyCacheService;

class CheckPolicyAcceptance
{
    private PolicyAcceptanceService $acceptanceService;
    private PublishedPolicyCacheService $cacheService;

    public function __construct(
        PolicyAcceptanceService $acceptanceService,
        PublishedPolicyCacheService $cacheService
    ) {
        $this->acceptanceService = $acceptanceService;
        $this->cacheService = $cacheService;
    }

    public function handle(Request $request, Closure $next) {
        $userId = $request->session()->get('user_id');

        if (!$userId) {
            return redirect()
                ->route('login');
        }

        $policies = $this->cacheService->getAll();

        foreach ($policies as $policy) {

            $accepted = $this->acceptanceService->hasAccepted(
                $userId,
                $policy
            );

            if (!$accepted) {
                return redirect()
                    ->route('policies.acceptance');
            }
        }
        return $next($request);
    }
}
