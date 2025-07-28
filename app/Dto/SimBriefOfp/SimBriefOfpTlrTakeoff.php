<?php

namespace App\Dto\SimBriefOfp;

use Spatie\LaravelData\Dto;

final class SimBriefOfpTlrTakeoff extends Dto
{
    /**
     * @param SimBriefOfpTlrTakeoffRunway[] $runway
     */
    public function __construct(
        public SimBriefOfpTlrTakeoffConditions $conditions,
        public array $runway
    ) {}
}
