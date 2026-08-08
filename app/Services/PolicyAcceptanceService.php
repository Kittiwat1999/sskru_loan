<?php

namespace App\Services;

use App\Models\Policy;
use App\Models\PolicyAcceptance;
use App\DTO\PublishedPolicyVersionData;
use Illuminate\Support\Facades\DB;

class PolicyAcceptanceService
{
    public function accept(
        int $userId,
        ?string $ipAddress = null,
        ?string $userAgent = null
    ): void {

        DB::transaction(function () use ($userId, $ipAddress, $userAgent) {
            $policies = Policy::query()
                ->published()
                ->get();

            foreach ($policies as $policy) {

                PolicyAcceptance::firstOrCreate(
                    [
                        'user_id' => $userId,
                        'policy_id' => $policy->id,
                        'policy_version' => $policy->version,
                    ],
                    [
                        'policy_type' => $policy->type,
                        'ip_address'     => $ipAddress,
                        'user_agent'     => $userAgent,
                        'accepted_at' => now(),
                    ]
                );
            }
        });
    }

    public function hasAccepted(
        int $userId,
        PublishedPolicyVersionData $policy
    ): bool {
        return PolicyAcceptance::query()
            ->where('user_id', $userId)
            ->where('policy_id', $policy->id)
            ->where('policy_version', $policy->version)
            ->exists();
    }

    public function getAcceptance(
        int $userId,
        PublishedPolicyVersionData $policy
    ): ?PolicyAcceptance {
        return PolicyAcceptance::query()
            ->where('user_id', $userId)
            ->where('policy_id', $policy->id)
            ->where('policy_version', $policy->version)
            ->first();
    }

    public function acceptOne(
        int $userId,
        PublishedPolicyVersionData $policy
    ): void {
        PolicyAcceptance::firstOrCreate(
            [
                'user_id' => $userId,
                'policy_id' => $policy->id,
                'policy_version' => $policy->version,
            ],
            [
                'policy_type' => $policy->type,
                'accepted_at' => now(),
            ]
        );
    }
}
