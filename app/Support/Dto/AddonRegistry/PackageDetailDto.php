<?php

declare(strict_types=1);

namespace App\Support\Dto\AddonRegistry;

use Spatie\LaravelData\Dto;

final class PackageDetailDto extends Dto
{
    public function __construct(
        public string $name,
        public string $repository_url,
        public string $version,
        public string $zip_url,
        public string $sha256,
        public ?bool $archived = false,
        public ?string $archived_reason = null
    ) {}
}
