<?php

namespace App\Filament\Resources\AirportResource\Pages;

use App\Filament\Exports\AirportExporter;
use App\Filament\Imports\AirportImporter;
use App\Filament\Resources\AirportResource;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListAirports extends ListRecords
{
    protected static string $resource = AirportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(AirportExporter::class)
                ->icon('heroicon-o-document-arrow-down')
                ->color('primary')
                ->label('Export to CSV'),

            ImportAction::make()
                ->importer(AirportImporter::class)
                ->icon('heroicon-o-document-arrow-up')
                ->color('primary')
                ->label('Import from CSV'),

            Actions\CreateAction::make()->label('Add Airport')->icon('heroicon-o-plus-circle'),
        ];
    }
}
