<?php

namespace App\Filament\Pages;

use App\Models\Enums\ModuleStatus;
use App\Models\Enums\NavigationGroup;
use App\Services\AddonRegistryService;
use App\Services\ModuleService;
use App\Support\Dto\AddonRegistry\PackageDto;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\EmbeddedTable;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Nwidart\Modules\Facades\Module;

class Modules extends Page implements Tables\Contracts\HasTable
{
    use HasPageShield;
    use Tables\Concerns\InteractsWithTable;

    #[Url(as: 'tab')]
    public ?string $activeTab = 'installed';

    protected static string|\UnitEnum|null $navigationGroup = NavigationGroup::Developers;

    protected static ?int $navigationSort = 1;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    #[\Override]
    public static function getNavigationLabel(): string
    {
        return Str::of(__('common.module'))->plural();
    }

    #[\Override]
    public static function getNavigationBadge(): ?string
    {
        $count = static::getUpdateCount();

        return $count > 0 ? (string) $count : null;
    }

    #[\Override]
    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getUpdateCount(): int
    {
        return Cache::flexible('modules-update-count', [3600, 3600 * 24], function (): int {
            try {
                $packages = app(AddonRegistryService::class)->getPackages();
                $registryPackages = array_map(fn (PackageDto $p): array => $p->toArray(), $packages);
            } catch (\Exception) {
                return 0; // If offline
            }

            $registryMap = [];
            foreach ($registryPackages as $package) {
                $parts = explode('/', (string) $package['name']);
                $localName = Str::studly(end($parts));
                $registryMap[$localName] = $package;
            }

            $updates = 0;
            foreach (Module::all() as $module) {
                $localName = $module->getName();
                $localVersion = ltrim($module->json()->get('version') ?? '0.0.0', 'v');

                if (isset($registryMap[$localName])) {
                    $registryVersion = ltrim($registryMap[$localName]['release'] ?? '0.0.0', 'v');

                    if (version_compare($registryVersion, $localVersion, '>')) {
                        $updates++;
                    }
                }
            }

            return $updates;
        });
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('display_name')
                    ->icon(fn (array $record): ?Heroicon => $record['official'] ? Heroicon::OutlinedCheckBadge : null)
                    ->iconColor('info')
                    ->iconPosition(IconPosition::After)
                    ->label(__('common.name'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('description')
                    ->label(__('common.description'))
                    ->limit(50),

                TextColumn::make('status')
                    ->label(__('common.status'))
                    ->badge(),

                ToggleColumn::make('enabled')
                    ->label(__('common.enabled'))
                    ->offIcon(Heroicon::XCircle)
                    ->offColor('danger')
                    ->onIcon(Heroicon::CheckCircle)
                    ->onColor('success')
                    ->disabled(fn (array $record): bool => !in_array($record['status'],
                        [ModuleStatus::Installed, ModuleStatus::UpdateAvailable, ModuleStatus::LocalOnly], true))
                    ->updateStateUsing(function (array $record, bool $state): void {
                        app(ModuleService::class)->updateModule($record['id'], $state);
                        $this->redirectRoute('filament.admin.pages.modules');
                    })
                    ->sortable(),

                TextColumn::make('local_version')
                    ->label(__('common.version'))
                    ->formatStateUsing(fn (?string $state, array $record): string => $state ? $state.($record['status'] === ModuleStatus::UpdateAvailable ? ' ➔ '.$record['registry_version'] : '') : ($record['registry_version'] ?? '-')
                    ),
            ])
            ->searchable()
            ->recordActions([
                Action::make('install')
                    ->label(__('module.actions.install'))
                    ->color('success')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->visible(fn (array $record): bool => $record['status'] === ModuleStatus::Available)
                    ->action(function (array $record): void {
                        try {
                            app(ModuleService::class)->installFromRegistry($record['registry_name']);
                            Notification::make()->title(__('module.notifications.installed_success'))->success()->send();
                            Cache::forget('modules_update_count');
                        } catch (\Exception $exception) {
                            Notification::make()->title(__('module.notifications.install_failed'))->body($exception->getMessage())->danger()->send();

                            return;
                        }

                        $this->redirectRoute('filament.admin.pages.modules');
                    }),

                Action::make('update')
                    ->label(__('module.actions.update'))
                    ->color('warning')
                    ->icon(Heroicon::OutlinedArrowPath)
                    ->visible(fn (array $record): bool => $record['status'] === ModuleStatus::UpdateAvailable)
                    ->action(function (array $record): void {
                        try {
                            app(ModuleService::class)->installFromRegistry($record['registry_name'], true);
                            Notification::make()->title(__('module.notifications.updated_success'))->success()->send();
                            Cache::forget('modules_update_count');
                        } catch (\Exception $exception) {
                            Notification::make()->title(__('module.notifications.update_failed'))->body($exception->getMessage())->danger()->send();

                            return;
                        }

                        $this->redirectRoute('filament.admin.pages.modules');
                    }),

                Action::make('uninstall')
                    ->label(__('module.actions.uninstall'))
                    ->color('danger')
                    ->icon(Heroicon::OutlinedTrash)
                    ->visible(fn (array $record): bool => in_array($record['status'], [ModuleStatus::Installed, ModuleStatus::UpdateAvailable, ModuleStatus::LocalOnly]) && !$record['enabled'])
                    ->requiresConfirmation()
                    ->action(function (array $record): void {
                        try {
                            app(ModuleService::class)->deleteModule($record['id']);
                            Notification::make()->title(__('module.notifications.uninstalled_success'))->success()->send();
                            Cache::forget('modules_update_count');
                        } catch (\Exception $exception) {
                            Notification::make()->title(__('module.notifications.uninstall_failed'))->body($exception->getMessage())->danger()->send();

                            return;
                        }

                        $this->redirectRoute('filament.admin.pages.modules');
                    }),
            ])
            ->records(fn (?string $sortColumn, ?string $sortDirection, ?string $search): Collection => $this->getModulesRecords()
                ->when(
                    filled($sortColumn),
                    fn (Collection $data): Collection => $data->sortBy(
                        $sortColumn,
                        SORT_REGULAR,
                        $sortDirection === 'desc',
                    )
                )
                ->when(
                    filled($search),
                    fn (Collection $data): Collection => $data->filter(
                        fn (array $record): bool => str_contains(
                            Str::lower($record['display_name']),
                            Str::lower($search),
                        ) || str_contains(
                            Str::lower((string) $record['description']),
                            Str::lower($search)
                        ),
                    ),
                )
            );
    }

    #[\Override]
    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->livewireProperty('activeTab')
                    ->contained(false)
                    ->tabs([
                        'installed' => Tab::make('installed')
                            ->label(__('module.tabs.installed'))
                            ->badge(static::getUpdateCount() > 0 ? (string) static::getUpdateCount() : null)
                            ->badgeColor('warning'),
                        'available' => Tab::make('available')
                            ->label(__('module.tabs.available')),
                    ]),
                EmbeddedTable::make(),
            ]);
    }

    public function getModulesRecords(): Collection
    {
        try {
            $packages = app(AddonRegistryService::class)->getPackages();
            $registryPackages = array_map(fn ($p) => $p->toArray(), $packages);
        } catch (\Exception) {
            $registryPackages = [];
        }

        $registryMap = [];
        foreach ($registryPackages as $package) {
            $name = $package['name'];
            $registryMap[$name] = $package;
        }

        $records = [];

        foreach (Module::all() as $module) {
            $localName = $module->getName();
            $enabled = $module->isEnabled();

            $localVersion = ltrim($module->json()->get('version') ?? '0.0.0', 'v');
            $registryData = $registryMap[$module->json()->get('alias') ?? $localName] ?? null;

            $status = ModuleStatus::LocalOnly;
            $registryVersion = null;
            if ($registryData) {
                $status = ModuleStatus::Installed;
                $registryVersion = ltrim($registryData['release'] ?? '0.0.0', 'v');
                if (version_compare($registryVersion, $localVersion, '>')) {
                    $status = ModuleStatus::UpdateAvailable;
                }
            }

            $records[] = [
                'id'               => $localName,
                'registry_name'    => $registryData ? $registryData['name'] : null,
                'display_name'     => $registryData ? $registryData['name'] : $localName,
                'description'      => $registryData['description'] ?? $module->json()->get('description') ?? '',
                'official'         => $registryData ? $registryData['official'] : false,
                'enabled'          => $enabled,
                'status'           => $status,
                'local_version'    => $localVersion,
                'registry_version' => $registryVersion,
            ];

            if ($registryData) {
                unset($registryMap[$registryData['name']]);
            }
        }

        foreach ($registryMap as $localName => $package) {
            $registryVersion = ltrim($package['release'] ?? '0.0.0', 'v');
            $records[] = [
                'id'               => $localName,
                'registry_name'    => $package['name'],
                'display_name'     => $package['name'],
                'description'      => $package['description'] ?? '',
                'enabled'          => false,
                'official'         => $package['official'],
                'status'           => ModuleStatus::Available,
                'local_version'    => null,
                'registry_version' => $registryVersion,
            ];
        }

        return collect($records)->filter(function (array $record): bool {
            if ($this->activeTab === 'installed') {
                return in_array($record['status'], [ModuleStatus::Installed, ModuleStatus::UpdateAvailable, ModuleStatus::LocalOnly], true);
            }

            if ($this->activeTab === 'available') {
                return $record['status'] === ModuleStatus::Available;
            }

            return true;
        });
    }
}
