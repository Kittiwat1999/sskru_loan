<?php

namespace App\Services;

use App\DTO\PublishedPolicyVersionData;
use App\Enums\PolicyType;
use App\Models\Policy;
use App\Repositories\PublishedPolicyCacheRepository;

class PublishedPolicyCacheService
{
    public function __construct(
        private PublishedPolicyCacheRepository $repository
    ) {}


    public function getAll(): array
    {
        $cache = $this->repository->get();

        if ($cache !== null) {

            return collect($cache)
                ->map(
                    fn($item) => PublishedPolicyVersionData::fromArray($item)
                )
                ->toArray();
        }

        $data = $this->loadPublishedPolicies();

        $this->repository->put(
            collect($data)
                ->map(
                    fn($item) => $item->toArray()
                )
                ->toArray()
        );

        return $data;
    }


    public function get(PolicyType $type): ?PublishedPolicyVersionData
    {

        return $this->getAll()[$type->value] ?? null;
    }


    public function forget(): void
    {
        $this->repository->forget();
    }


    private function loadPublishedPolicies(): array
    {
        return Policy::query()
            ->published()
            ->select([
                'id',
                'type',
                'version',
            ])
            ->get()
            ->mapWithKeys(function ($policy) {

                return [
                    $policy->type => new PublishedPolicyVersionData(
                        id: $policy->id,
                        type: $policy->type,
                        version: $policy->version
                    )
                ];
            })
            ->toArray();
    }

    public function refresh(): array
    {
        $this->forget();
        return $this->getAll();
    }
}
