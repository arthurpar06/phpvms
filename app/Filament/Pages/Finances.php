<?php

namespace App\Filament\Pages;

use App\Repositories\AirlineRepository;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Illuminate\Support\Facades\Auth;

class Finances extends BaseDashboard
{
    use HasFiltersForm;
    use HasPageShield;

    protected static ?string $navigationGroup = 'Operations';
    protected static ?int $navigationSort = 5;

    protected static ?string $title = 'Finances';

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $routePath = '/finances';

    //protected static string $view = 'filament.pages.finances';

    public function mount(): void
    {
        $this->filters = [
            'start_date' => $this->filters['start_date'] ?? now()->subYear(),
            'end_date'   => $this->filters['end_date'] ?? now(),
            'airline_id' => $this->filters['airline_id'] ?? Auth::user()->airline_id,
        ];
    }

    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Filters')->schema([
                Forms\Components\DatePicker::make('start_date')->native(false)->maxDate(fn (Get $get) => $get('end_date')),
                Forms\Components\DatePicker::make('end_date')->native(false)->minDate(fn (Get $get) => $get('start_date'))->maxDate(now()),
                Forms\Components\Select::make('airline_id')->label('Airline')->options(app(AirlineRepository::class)->selectBoxList()),
            ])->columns(3),
        ]);
    }

    public function getVisibleWidgets(): array
    {
        return [
            \App\Filament\Widgets\AirlineFinanceChart::class,
            \App\Filament\Widgets\AirlineFinanceTable::class,
        ];
    }

    public function getColumns(): int
    {
        return 1;
    }
}
