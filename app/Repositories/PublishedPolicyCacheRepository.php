<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;

class PublishedPolicyCacheRepository
{
    private const CACHE_KEY = 'policy:published:versions';

    public function get(): ?array
    {
        return Cache::get(self::CACHE_KEY);
    }

    public function put(array $data): void
    {
        Cache::forever(
            self::CACHE_KEY,
            $data
        );
    }

    public function forget(): void
    {
        Cache::forget(
            self::CACHE_KEY
        );
    }
}