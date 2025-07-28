<?php

namespace App\Dto\SimBriefOfp;

use Spatie\LaravelData\Dto;

final class SimBriefOfpCrew extends Dto
{
    /**
     * @param string[] $fa
     */
    public function __construct(
        public int $pilot_id,
        public string $cpt,
        public string $fo,
        public string $dx,
        public string $pu,
        public array $fa
    ) {}
}
