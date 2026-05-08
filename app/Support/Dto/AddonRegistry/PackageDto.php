<?php

declare(strict_types=1);

namespace App\Support\Dto\AddonRegistry;

use Spatie\LaravelData\Data;

final class PackageDto extends Data
{
    /**
     * @param string[] $keywords
     */
    public function __construct(
        public string $name,
        public ?string $description = null,
        public ?string $category = null,
        public ?string $license = null,
        public ?array $keywords = [],
        public ?string $repository_url = null,
        public bool $official = false,
        public ?string $release = null,
        public ?PackageStatsDto $stats = null
    ) {}
}
