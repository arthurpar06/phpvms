<?php

namespace App\Models\Observers;

use App\Models\Journal;
use App\Support\Money;

/**
 * Class JournalObserver
 */
class JournalObserver
{
    /**
     * @param Journal $journal
     *
     * @throws \UnexpectedValueException
     * @throws \InvalidArgumentException
     */
    public function creating(Journal $journal): void
    {
        $journal->balance = Money::createFromAmount(0);
    }
}
