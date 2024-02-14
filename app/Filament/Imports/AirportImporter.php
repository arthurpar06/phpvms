<?php

namespace App\Filament\Imports;

use App\Models\Airport;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class AirportImporter extends Importer
{
    protected static ?string $model = Airport::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('icao')
                ->rules(['required'])
                ->requiredMapping()
                ->fillRecordUsing(function (Airport $record, string $state) {
                    $record->id = $state;
                    $record->icao = $state;
                }),

            ImportColumn::make('iata'),
            ImportColumn::make('name')
                ->rules(['required'])
                ->requiredMapping(),

            ImportColumn::make('location'),
            ImportColumn::make('region'),
            ImportColumn::make('country'),
            ImportColumn::make('timezone'),
            ImportColumn::make('hub')
                ->boolean(),

            ImportColumn::make('lat')
                ->rules(['required'])
                ->requiredMapping()
                ->numeric(),

            ImportColumn::make('lon')
                ->rules(['required'])
                ->requiredMapping()
                ->numeric(),

            ImportColumn::make('elevation')
                ->numeric(),

            ImportColumn::make('ground_handling_cost')
                ->numeric()
                ->fillRecordUsing(function (Airport $record, ?float $state) {
                    $record->ground_handling_cost = $state ?: (float) setting('airports.default_ground_handling_cost');
                }),

            ImportColumn::make('fuel_100ll_cost')
                ->numeric(),

            ImportColumn::make('fuel_jeta_cost')
                ->numeric()
                ->fillRecordUsing(function (Airport $record, ?float $state) {
                    $record->fuel_jeta_cost = $state ?: (float) setting('airports.default_jet_a_fuel_cost');
                }),

            ImportColumn::make('fuel_mogas_cost')
                ->numeric(),

            ImportColumn::make('notes'),
        ];
    }

    public function resolveRecord(): ?Airport
    {
        return Airport::firstOrNew([
            // Update existing records, matching them by `$this->data['column_name']`
            'id' => $this->data['icao'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your airport import has completed and '.number_format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }
}
