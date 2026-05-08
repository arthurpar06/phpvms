<?php

declare(strict_types=1);

namespace App\Support\Dto\AddonRegistry;

use Spatie\LaravelData\Dto;

final class PackageStatsDto extends Dto
{
    public function __construct(
        public int $installs_total,
        public int $installs_30d,
        public ?string $last_install = null
    ) {}
}
