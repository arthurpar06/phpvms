<?php

namespace App\Filament\Resources\AircraftResource\Pages;

use App\Filament\Exports\AircraftExporter;
use App\Filament\Imports\AircraftImporter;
use App\Filament\Resources\AircraftResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;

class ListAircraft extends ListRecords
{
    protected static string $resource = AircraftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(AircraftExporter::class)
                ->icon('heroicon-o-document-arrow-down')
                ->color('primary')
                ->label('Export to CSV'),
            ImportAction::make()
                ->importer(AircraftImporter::class)
                ->icon('heroicon-o-document-arrow-up')
                ->color('primary')
                ->label('Import from CSV'),
            Actions\CreateAction::make()->label('Add Aircraft')->icon('heroicon-o-plus-circle'),
        ];
    }
}
