<?php

namespace App\Filament\Widgets;

use App\Models\Airline;
use App\Models\JournalTransaction;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class AirlineFinanceTable extends Widget
{
    use HasWidgetShield;
    use InteractsWithPageFilters;

    protected static ?string $pollingInterval = null;
    protected static string $view = 'filament.widgets.airline_finance_table';

    public int $airline_journal_id;

    public Collection $transactions;
    public int $sum_all_credits;
    public int $sum_all_debits;

    public function mount(): void
    {
        $this->updateTransactions();
    }

    public function updateTransactions(): void
    {
        $this->airline_journal_id = Airline::find($this->filters['airline_id'] ?? Auth::user()->airline_id)->journal->id;
        $this->transactions = JournalTransaction::groupBy('transaction_group', 'currency')
        ->selectRaw('transaction_group, 
                     currency, 
                     SUM(credit) as sum_credits, 
                     SUM(debit) as sum_debits')
        ->where(['journal_id' => $this->airline_journal_id])
        ->whereBetween('created_at', [$this->filters['start_date'], $this->filters['end_date']], 'AND')
        ->orderBy('sum_credits', 'desc')
        ->orderBy('sum_debits', 'desc')
        ->orderBy('transaction_group', 'asc')
        ->get();

        // Summate it so we can show it on the footer of the table
        $this->sum_all_credits = 0;
        $this->sum_all_debits = 0;
        foreach ($this->transactions as $ta) {
            $this->sum_all_credits += $ta->sum_credits ?? 0;
            $this->sum_all_debits += $ta->sum_debits ?? 0;
        }
    }

    public static function canView(): bool
    {
        return false;
    }
}
