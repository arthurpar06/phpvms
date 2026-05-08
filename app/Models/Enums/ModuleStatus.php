<?php

namespace App\Models\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ModuleStatus: string implements HasColor, HasLabel
{
    case Installed = 'installed';
    case Available = 'available';
    case UpdateAvailable = 'update_available';
    case LocalOnly = 'local_only';

    public function getLabel(): string
    {
        return match ($this) {
            self::Installed       => __('module.status.installed'),
            self::Available       => __('module.status.available'),
            self::UpdateAvailable => __('module.status.update_available'),
            self::LocalOnly       => __('module.status.local_only'),
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Installed       => 'success',
            self::Available       => 'gray',
            self::UpdateAvailable => 'warning',
            self::LocalOnly       => 'info',
        };
    }
}
