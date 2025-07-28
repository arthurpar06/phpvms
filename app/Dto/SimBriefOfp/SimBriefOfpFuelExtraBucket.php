<?php

namespace App\Dto\SimBriefOfp;

use Spatie\LaravelData\Dto;

final class SimBriefOfpFuelExtraBucket extends Dto
{
    public function __construct(
        public string $label,
        public int $fuel,
        public int $time,
        public bool $required
    ) {}
}
