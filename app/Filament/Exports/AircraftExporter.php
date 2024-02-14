<?php

namespace App\Filament\Exports;

use App\Models\Aircraft;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class AircraftExporter extends Exporter
{
    protected static ?string $model = Aircraft::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('subfleet.type')->label('subfleet'),
            ExportColumn::make('iata')->label('iata'),
            ExportColumn::make('icao')->label('icao'),
            ExportColumn::make('hub_id')->label('hub_id'),
            ExportColumn::make('airport_id')->label('airport_id'),
            ExportColumn::make('name')->label('name'),
            ExportColumn::make('registration')->label('registration'),
            ExportColumn::make('fin')->label('fin'),
            ExportColumn::make('hex_code')->label('hex_code'),
            ExportColumn::make('selcal')->label('selcal'),
            ExportColumn::make('dow')->label('dow'),
            ExportColumn::make('zfw')->label('zfw'),
            ExportColumn::make('mtow')->label('mtow'),
            ExportColumn::make('mlw')->label('mlw'),
            ExportColumn::make('status')->label('status'),
            ExportColumn::make('simbrief_type')->label('simbrief_type'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your aircraft export has completed and '.number_format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
