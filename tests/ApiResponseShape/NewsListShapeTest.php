<?php

namespace Tests\ApiResponseShape;

use App\Models\News;
use Tests\TestCase;

/**
 * Locks in the JSON response shape of GET /api/news.
 *
 * This is the contract external API consumers (ACARS clients, pilot apps,
 * third-party integrations) depend on. Must remain stable across the
 * repository-removal refactor (Phases 1-7).
 *
 * Note: /api/news is a public endpoint (no auth middleware), but it still
 * returns a paginated collection of NewsResource objects.
 *
 * Unlike Characterization tests, this file STAYS — it's the permanent
 * contract test for the public API.
 */
final class NewsListShapeTest extends TestCase
{
    public function test_news_list_returns_expected_json_structure(): void
    {
        News::factory()->count(1)->create();

        $response = $this->get('/api/news');

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'user_id',
                    'subject',
                    'body',
                    'user' => [
                        'id',
                        'name',
                    ],
                ],
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next',
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'path',
                'per_page',
                'to',
                'total',
            ],
        ]);
    }
}
