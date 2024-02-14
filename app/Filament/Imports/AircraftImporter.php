<?php

namespace App\Filament\Imports;

use App\Models\Aircraft;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class AircraftImporter extends Importer
{
    protected static ?string $model = Aircraft::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('subfleet')
                ->relationship(resolveUsing: 'type')
                ->requiredMapping(),

            ImportColumn::make('iata'),
            ImportColumn::make('icao'),
            ImportColumn::make('hub_id'),
            ImportColumn::make('airport_id'),
            ImportColumn::make('name')
                ->requiredMapping(),

            ImportColumn::make('registration')
                ->requiredMapping(),

            ImportColumn::make('fin'),
            ImportColumn::make('hex_code'),
            ImportColumn::make('selcal'),
            ImportColumn::make('dow')
                ->numeric(),

            ImportColumn::make('zfw')
                ->numeric(),

            ImportColumn::make('mtow')
                ->numeric(),

            ImportColumn::make('mlw')
                ->numeric(),

            ImportColumn::make('status'),
            ImportColumn::make('simbrief_type'),
        ];
    }

    public function resolveRecord(): ?Aircraft
    {
        return Aircraft::firstOrNew([
             // Update existing records, matching them by `$this->data['column_name']`
             'registration' => $this->data['registration'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your aircraft import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
