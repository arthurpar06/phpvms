<?php

namespace Tests\Characterization;

use App\Models\Aircraft;
use App\Models\Airline;
use App\Models\Airport;
use App\Models\Flight;
use App\Models\Subfleet;
use App\Models\Typerating;
use App\Repositories\FlightRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Tests\TestCase;

/**
 * Locks in current FlightRepository::searchCriteria behavior.
 *
 * Purpose: Phase 0 safety net for the repository-removal refactor.
 * In Phase 6, the arrange section using $repo->searchCriteria will be
 * swapped for `(new FlightSearchQuery($request))->build()`. Assertions
 * must stay identical.
 *
 * Delete this file in Phase 6 after FlightSearchQuery is in production
 * and these same assertions have been migrated into FlightTest.php.
 */
final class FlightSearchCharacterizationTest extends TestCase
{
    private FlightRepository $repo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = app(FlightRepository::class);
    }

    /**
     * Run a search through the repo and return the full result collection.
     *
     * Uses ->all() rather than ->paginate() for simpler assertions — the
     * underlying WhereCriteria application is identical either way.
     */
    private function search(array $params, bool $only_active = true): Collection
    {
        $request = Request::create('/api/flights/search', 'GET', $params);

        $this->repo->resetCriteria();

        /** @var Collection $results */
        $results = $this->repo->searchCriteria($request, $only_active)->all();

        return $results;
    }

    public function test_filter_by_airline_id_only(): void
    {
        /** @var Airline $target_airline */
        $target_airline = Airline::factory()->create();
        /** @var Airline $noise_airline */
        $noise_airline = Airline::factory()->create();

        /** @var Flight $target */
        $target = Flight::factory()->create(['airline_id' => $target_airline->id]);
        Flight::factory()->create(['airline_id' => $noise_airline->id]);
        Flight::factory()->create(['airline_id' => $noise_airline->id]);

        $results = $this->search(['airline_id' => $target_airline->id]);

        $this->assertCount(1, $results);
        /** @var Flight $first */
        $first = $results->first();
        $this->assertEquals($target->id, $first->id);
    }

    public function test_filter_by_dep_icao_uppercases_and_filters(): void
    {
        // Create the target airport with a known ICAO id; factory normally creates random ICAOs.
        Airport::factory()->create(['id' => 'KLAX']);
        Airport::factory()->create(['id' => 'KJFK']);

        /** @var Flight $target */
        $target = Flight::factory()->create(['dpt_airport_id' => 'KLAX']);
        Flight::factory()->create(['dpt_airport_id' => 'KJFK']);

        // Pass lowercase — repo must strtoupper before matching.
        $results = $this->search(['dep_icao' => 'klax']);

        $this->assertCount(1, $results);
        /** @var Flight $first */
        $first = $results->first();
        $this->assertEquals($target->id, $first->id);
        $this->assertEquals('KLAX', $first->dpt_airport_id);
    }

    public function test_filter_by_distance_range_dgt_and_dlt(): void
    {
        Flight::factory()->create(['distance' => 500]);
        /** @var Flight $middle */
        $middle = Flight::factory()->create(['distance' => 1000]);
        Flight::factory()->create(['distance' => 2000]);

        $results = $this->search(['dgt' => 800, 'dlt' => 1500]);

        $this->assertCount(1, $results);
        /** @var Flight $first */
        $first = $results->first();
        $this->assertEquals($middle->id, $first->id);
    }

    public function test_filter_by_subfleet_id_via_relation(): void
    {
        /** @var Subfleet $subfleet */
        $subfleet = Subfleet::factory()->create();

        /** @var Flight $attached */
        $attached = Flight::factory()->create();
        $attached->subfleets()->attach($subfleet->id);

        // Noise flight with no subfleet attached.
        Flight::factory()->create();

        $results = $this->search(['subfleet_id' => $subfleet->id]);

        $this->assertCount(1, $results);
        /** @var Flight $first */
        $first = $results->first();
        $this->assertEquals($attached->id, $first->id);
    }

    public function test_filter_by_type_rating_id_joins_through_subfleets(): void
    {
        /** @var Subfleet $subfleet */
        $subfleet = Subfleet::factory()->create();

        $typerating = Typerating::create([
            'name' => 'B737 Type Rating',
            'type' => 'B737',
        ]);
        $typerating->subfleets()->attach($subfleet->id);

        /** @var Flight $attached */
        $attached = Flight::factory()->create();
        $attached->subfleets()->attach($subfleet->id);

        // Noise: a flight with a different subfleet, not linked to the type rating.
        /** @var Subfleet $other_subfleet */
        $other_subfleet = Subfleet::factory()->create();
        /** @var Flight $noise */
        $noise = Flight::factory()->create();
        $noise->subfleets()->attach($other_subfleet->id);

        $results = $this->search(['type_rating_id' => $typerating->id]);

        $this->assertCount(1, $results);
        /** @var Flight $first */
        $first = $results->first();
        $this->assertEquals($attached->id, $first->id);
    }

    public function test_filter_by_icao_type_joins_through_aircraft(): void
    {
        /** @var Subfleet $subfleet */
        $subfleet = Subfleet::factory()->create();
        Aircraft::factory()->create([
            'subfleet_id' => $subfleet->id,
            'icao'        => 'B738',
        ]);

        /** @var Flight $attached */
        $attached = Flight::factory()->create();
        $attached->subfleets()->attach($subfleet->id);

        // Noise: subfleet with a different aircraft icao.
        /** @var Subfleet $other_subfleet */
        $other_subfleet = Subfleet::factory()->create();
        Aircraft::factory()->create([
            'subfleet_id' => $other_subfleet->id,
            'icao'        => 'A320',
        ]);
        /** @var Flight $noise */
        $noise = Flight::factory()->create();
        $noise->subfleets()->attach($other_subfleet->id);

        $results = $this->search(['icao_type' => 'B738']);

        $this->assertCount(1, $results);
        /** @var Flight $first */
        $first = $results->first();
        $this->assertEquals($attached->id, $first->id);
    }

    public function test_only_active_true_excludes_inactive_flights(): void
    {
        /** @var Flight $active_visible */
        $active_visible = Flight::factory()->create([
            'active'  => true,
            'visible' => true,
        ]);
        Flight::factory()->create([
            'active'  => false,
            'visible' => true,
        ]);
        Flight::factory()->create([
            'active'  => true,
            'visible' => false,
        ]);

        $results = $this->search([], only_active: true);

        $this->assertCount(1, $results);
        /** @var Flight $first */
        $first = $results->first();
        $this->assertEquals($active_visible->id, $first->id);
    }

    public function test_only_active_false_includes_inactive_flights(): void
    {
        /** @var Flight $active_visible */
        $active_visible = Flight::factory()->create([
            'active'  => true,
            'visible' => true,
        ]);
        /** @var Flight $inactive_visible */
        $inactive_visible = Flight::factory()->create([
            'active'  => false,
            'visible' => true,
        ]);
        /** @var Flight $active_hidden */
        $active_hidden = Flight::factory()->create([
            'active'  => true,
            'visible' => false,
        ]);

        $results = $this->search([], only_active: false);

        $this->assertCount(3, $results);

        // Cast to string on both sides: Flight::$keyType === 'string', so
        // hydrated models return ids as strings, while factory-returned models
        // hold them as ints.
        $ids = $results->pluck('id')->map(fn ($id) => (string) $id)->all();
        $this->assertContains((string) $active_visible->id, $ids);
        $this->assertContains((string) $inactive_visible->id, $ids);
        $this->assertContains((string) $active_hidden->id, $ids);
    }
}
