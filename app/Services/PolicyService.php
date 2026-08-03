<?php

namespace App\Services;

use App\Models\Policy;
use Illuminate\Support\Facades\DB;
use App\Enums\PolicyAction;
use App\Enums\PolicyStatus;
use App\Services\PublishedPolicyCacheService;

class PolicyService
{
    public function __construct(
        private PolicyChangeLogger $policyChangeLogger,
        private PublishedPolicyCacheService $publishedPolicyCacheService
    ) {}

    public function create(array $data, int $userId): Policy {

        return DB::transaction(function () use ($data, $userId) {
            $policy = Policy::create([
                ...$data,
                'status' => PolicyStatus::DRAFT->value,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]);

            $this->policyChangeLogger->log(
                $policy->id,
                PolicyAction::CREATE->value,
                $userId,
                'Create new Policy'
            );
            return $policy;
        });
    }

    public function update(array $data, Policy $policy, int $userId): Policy {
        DB::transaction(function () use ($data, $policy, $userId) {
            $policy->update([
                ...$data,
                'updated_by' => $userId
            ]);

            $this->policyChangeLogger->log(
                $policy->id,
                PolicyAction::UPDATE->value,
                $userId,
                'Update Policy'
            );
        });

        return $policy;
    }

    public function publish(Policy $policy, int $userId) : Policy {
        DB::transaction(function () use ($policy, $userId) {
            Policy::where('type', $policy->type)
                ->where('status', PolicyStatus::PUBLISHED->value)
                ->update([
                    'status' => PolicyStatus::ARCHIVED->value,
                    'updated_by' => $userId
                ]);

            $policy->update([
                'status' => PolicyStatus::PUBLISHED->value,
                'published_at' => now(),
                'effective_at' => now(),
                'updated_by' => $userId
            ]);

            $this->policyChangeLogger->log(
                $policy->id,
                PolicyAction::PUBLISH->value,
                $userId,
                'Policy Published'
            );
        });

        $this->publishedPolicyCacheService->forget();
        
        return $policy;
    }

    public function archive(Policy $policy, int $userId) : Policy {
        DB::transaction(function () use ($policy, $userId) {
            $policy->update([
                'status' => PolicyStatus::ARCHIVED->value,
                'updated_by' => $userId
            ]);
            $this->policyChangeLogger->log(
                $policy->id,
                PolicyAction::ARCHIVE->value,
                $userId,
                'Archive Policy'
            );
        });

        return $policy;
    }

    public function restore(Policy $policy, int $userId): Policy {
        DB::transaction(function () use ($policy, $userId) {
            $policy->update([
                'status' => PolicyStatus::DRAFT->value,
                'updated_by' => $userId
            ]);

            $this->policyChangeLogger->log(
                $policy->id,
                PolicyAction::RESTORE->value,
                $userId,
                'Restore Archived Policy to Draft'
            );
        });
        return $policy;
    }
}