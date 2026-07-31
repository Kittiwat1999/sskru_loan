<?php

namespace App\Services;

use App\Enums\PolicyStatus;
use App\Models\Policy;

class PolicyWorkflow
{
    public function canPublish(Policy $policy): bool
    {
        return $policy->status === PolicyStatus::DRAFT->value;
    }

    public function canArchive(Policy $policy): bool
    {
        return $policy->status === PolicyStatus::PUBLISHED->value;
    }

    public function canRestore(Policy $policy): bool
    {
        return $policy->status === PolicyStatus::ARCHIVED->value;
    }
}
