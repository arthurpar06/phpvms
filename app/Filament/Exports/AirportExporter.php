<?php

namespace App\Filament\Exports;

use App\Models\Airport;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class AirportExporter extends Exporter
{
    protected static ?string $model = Airport::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('icao')->label('icao'),
            ExportColumn::make('iata')->label('iata'),
            ExportColumn::make('name')->label('name'),
            ExportColumn::make('location')->label('location'),
            ExportColumn::make('region')->label('region'),
            ExportColumn::make('country')->label('country'),
            ExportColumn::make('timezone')->label('timezone'),
            ExportColumn::make('hub')->label('hub'),
            ExportColumn::make('lat')->label('lat'),
            ExportColumn::make('lon')->label('lon'),
            ExportColumn::make('elevation')->label('elevation'),
            ExportColumn::make('ground_handling_cost')->label('ground_handling_cost'),
            ExportColumn::make('fuel_100ll_cost')->label('fuel_100ll_cost'),
            ExportColumn::make('fuel_jeta_cost')->label('fuel_jeta_cost'),
            ExportColumn::make('fuel_mogas_cost')->label('fuel_mogas_cost'),
            ExportColumn::make('notes')->label('notes'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your airport export has completed and '.number_format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
