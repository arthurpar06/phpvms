<?php

namespace App\Dto\SimBriefOfp;

use Spatie\LaravelData\Dto;

final class SimBriefOfpFuelExtra extends Dto
{
    /**
     * @param SimBriefOfpFuelExtraBucket[] $bucket
     */
    public function __construct(public array $bucket) {}
}
