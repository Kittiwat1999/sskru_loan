<?php

namespace App\Services;

use App\Models\Policy;
use App\Models\PolicyAcceptance;
use App\Models\Users;
use App\DTO\PublishedPolicyVersionData;

class PolicyAcceptanceService
{
    public function accept(
        int $userId,
        Policy $policy,
        ?string $ipAddress,
        ?string $userAgent
    ): PolicyAcceptance {
        return PolicyAcceptance::firstOrCreate(
            [
                'user_id'   => $userId,
                'policy_id' => $policy->id,
            ],
            [
                'policy_type'    => $policy->type,
                'policy_version' => $policy->version,
                'accepted_at'    => now(),
                'ip_address'     => $ipAddress,
                'user_agent'     => $userAgent,
            ]
        );
    }

    public function hasAccepted(
        int $userId,
        PublishedPolicyVersionData $policy
    ): bool {
        return PolicyAcceptance::query()
            ->where('user_id', $userId)
            ->where('policy_id', $policy->id)
            ->exists();
    }

    public function getAcceptance(
        int $userId,
        PublishedPolicyVersionData $policy
    ): ?PolicyAcceptance {
        return PolicyAcceptance::query()
            ->where('user_id', $userId)
            ->where('policy_id', $policy->id)
            ->first();
    }
}
