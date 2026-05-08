<?php

declare(strict_types=1);

use App\Models\Enums\ModuleStatus;

it('returns correct labels for module status', function (): void {
    expect(ModuleStatus::Installed->getLabel())->toBe(__('module.status.installed'))
        ->and(ModuleStatus::Available->getLabel())->toBe(__('module.status.available'))
        ->and(ModuleStatus::UpdateAvailable->getLabel())->toBe(__('module.status.update_available'))
        ->and(ModuleStatus::LocalOnly->getLabel())->toBe(__('module.status.local_only'));
});

it('returns correct colors for module status', function (): void {
    expect(ModuleStatus::Installed->getColor())->toBe('success')
        ->and(ModuleStatus::Available->getColor())->toBe('gray')
        ->and(ModuleStatus::UpdateAvailable->getColor())->toBe('warning')
        ->and(ModuleStatus::LocalOnly->getColor())->toBe('info');
});
