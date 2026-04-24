<?php

namespace Tests\Characterization;

use App\Models\Journal;
use App\Models\JournalTransaction;
use App\Models\Pirep;
use App\Repositories\JournalRepository;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

/**
 * Locks in current JournalRepository::deleteAllForObject behavior.
 *
 * Purpose: Phase 0 safety net for the repository-removal refactor.
 * Phase 7 will absorb this method into JournalService::deleteAllForObject().
 * Assertions must stay identical.
 *
 * Delete this file in Phase 7 after JournalService is in production and
 * these same assertions have been migrated into the JournalService tests.
 */
final class JournalDeleteForObjectCharacterizationTest extends TestCase
{
    private JournalRepository $repo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = app(JournalRepository::class);
    }

    /**
     * Build a JournalTransaction pointing at the given ref model.
     *
     * Does not use the factory because the factory class name
     * (JournalTransactionsFactory — plural) does not match Laravel's
     * default resolver convention. Writing the row directly keeps
     * the fixture intent explicit.
     */
    private function makeTransaction(Journal $journal, Pirep $pirep): JournalTransaction
    {
        return JournalTransaction::create([
            'id'                => Uuid::uuid4()->toString(),
            'transaction_group' => Uuid::uuid4()->toString(),
            'journal_id'        => $journal->id,
            'credit'            => 100,
            'debit'             => 0,
            'currency'          => 'USD',
            'memo'              => 'char-test',
            'ref_model_type'    => Pirep::class,
            'ref_model_id'      => $pirep->id,
            'post_date'         => Carbon::now('UTC')->toDateTimeString(),
        ]);
    }

    /**
     * Count rows in journal_transactions matching a ref object.
     * Uses a raw query so post-delete state is read from the DB
     * rather than stale Eloquent instances.
     */
    private function countForPirep(Pirep $pirep, ?Journal $journal = null): int
    {
        $query = JournalTransaction::where('ref_model_type', Pirep::class)
            ->where('ref_model_id', $pirep->id);

        if ($journal instanceof Journal) {
            $query->where('journal_id', $journal->id);
        }

        return $query->count();
    }

    public function test_deletes_all_transactions_for_object_type_and_id(): void
    {
        /** @var Journal $journal */
        $journal = Journal::factory()->create();

        /** @var Pirep $pirep1 */
        $pirep1 = Pirep::factory()->create();
        /** @var Pirep $pirep2 */
        $pirep2 = Pirep::factory()->create();

        // 3 transactions for pirep1, 1 for pirep2 on the same journal.
        $this->makeTransaction($journal, $pirep1);
        $this->makeTransaction($journal, $pirep1);
        $this->makeTransaction($journal, $pirep1);
        $this->makeTransaction($journal, $pirep2);

        $this->assertEquals(3, $this->countForPirep($pirep1));
        $this->assertEquals(1, $this->countForPirep($pirep2));

        $this->repo->deleteAllForObject($pirep1);

        $this->assertEquals(0, $this->countForPirep($pirep1));
        $this->assertEquals(1, $this->countForPirep($pirep2));
    }

    public function test_deletes_only_transactions_for_given_journal_when_journal_provided(): void
    {
        /** @var Journal $journalA */
        $journalA = Journal::factory()->create();
        /** @var Journal $journalB */
        $journalB = Journal::factory()->create();

        /** @var Pirep $pirep */
        $pirep = Pirep::factory()->create();

        // One transaction for the same pirep on each journal.
        $this->makeTransaction($journalA, $pirep);
        $this->makeTransaction($journalB, $pirep);

        $this->assertEquals(1, $this->countForPirep($pirep, $journalA));
        $this->assertEquals(1, $this->countForPirep($pirep, $journalB));

        $this->repo->deleteAllForObject($pirep, $journalA);

        $this->assertEquals(0, $this->countForPirep($pirep, $journalA));
        $this->assertEquals(1, $this->countForPirep($pirep, $journalB));
    }
}
