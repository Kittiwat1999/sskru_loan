<?php

namespace App\Services;

use App\Enums\PolicyAction;
use App\Models\PolicyChangeLog;
use InvalidArgumentException;

class PolicyChangeLogger
{
    public function log(
        int $policyId,
        string $action,
        string $createdBy,
        ?string $description = null
    ): PolicyChangeLog {

        if (! in_array($action, array_column(PolicyAction::cases(), 'value'))) {
            throw new InvalidArgumentException("Invalid policy action [$action].");
        }

        return PolicyChangeLog::create([
            'policy_id'  => $policyId,
            'action'     => $action,
            'description'=> $description,
            'created_by' => $createdBy,
        ]);
    }
}