<?php

namespace Tests\ApiResponseShape;

use App\Models\Airport;
use App\Models\User;
use Tests\TestCase;

/**
 * Locks in the JSON response shape of GET /api/airports.
 *
 * This is the contract external API consumers (ACARS clients, pilot apps,
 * third-party integrations) depend on. Must remain stable across the
 * repository-removal refactor (Phases 1-7).
 *
 * Unlike Characterization tests, this file STAYS — it's the permanent
 * contract test for the public API.
 */
final class AirportListShapeTest extends TestCase
{
    public function test_airport_list_returns_expected_json_structure(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        Airport::factory()->count(3)->create();

        $this->user = $user;
        $response = $this->get('/api/airports');

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'iata',
                    'icao',
                    'name',
                    'country',
                    'lat',
                    'lon',
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
