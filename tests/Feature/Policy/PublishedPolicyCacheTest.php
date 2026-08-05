<?php

namespace Tests\Feature\Policy;

use Tests\TestCase;
use App\Models\Policy;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Services\PublishedPolicyCacheService;
use App\Enums\PolicyType;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublishedPolicyCacheTest extends TestCase
{
    use RefreshDatabase;

    protected PublishedPolicyCacheService $service;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        $this->service = app(
            PublishedPolicyCacheService::class
        );
    }

    public function test_cache_miss_loads_published_policy_and_store_cache(): void
    {
        Policy::factory()
            ->published()
            ->create([
                'type' => PolicyType::TERMS->value,
                'version' => '1.0.0',
            ]);

        Policy::factory()
            ->published()
            ->create([
                'type' => PolicyType::PRIVACY->value,
                'version' => '1.2.0',
            ]);

        $result = $this->service->getAll();

        $this->assertArrayHasKey(
            'terms',
            $result
        );

        $this->assertEquals(
            '1.0.0',
            $result['terms']->version
        );

        $this->assertNotNull(
            Cache::get('policy:published:versions')
        );
    }

    public function test_cache_hit_does_not_query_database(): void
    {
        Cache::forever(
            'policy:published:versions',
            [
                'terms' => [
                    'id' => 1,
                    'type' => 'terms',
                    'version' => '9.9.9',
                ]
            ]
        );

        DB::enableQueryLog();
        $result = $this->service->getAll();
        $queries = DB::getQueryLog();

        $this->assertCount(
            0,
            $queries
        );

        $this->assertEquals(
            '9.9.9',
            $result['terms']->version
        );
    }

    public function test_forget_remove_published_policy_cache(): void
    {
        Cache::forever(
            'policy:published:versions',
            [
                'terms' => [
                    'id' => 1,
                    'version' => '1.0.0'
                ]
            ]
        );

        $this->service->forget();

        $this->assertNull(
            Cache::get(
                'policy:published:versions'
            )
        );
    }

    public function test_refresh_rebuild_cache(): void
    {
        Policy::factory()
            ->published()
            ->create([
                'type' => PolicyType::TERMS->value,
                'version' => '2.0.0'
            ]);


        Cache::forever(
            'policy:published:versions',
            [
                'terms' => [
                    'id' => 99,
                    'version' => 'old'
                ]
            ]
        );

        $result = $this->service->refresh();

        $this->assertEquals(
            '2.0.0',
            $result['terms']->version
        );

        $cached = Cache::get(
            'policy:published:versions'
        );

        $this->assertEquals(
            '2.0.0',
            $cached['terms']['version']
        );
    }

    public function test_get_specific_policy_type_from_cache(): void
    {
        Policy::factory()
            ->published()
            ->create([
                'type' => PolicyType::PDPA->value,
                'version' => '3.0.0'
            ]);


        $policy = $this->service->get(
            PolicyType::PDPA
        );

        $this->assertEquals(
            '3.0.0',
            $policy->version
        );
    }
}
