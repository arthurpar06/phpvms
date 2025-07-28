<?php

namespace App\Dto\SimBriefOfp;

use Spatie\LaravelData\Dto;

class SimBriefOfpTlr extends Dto
{
    public function __construct(
        SimBriefOfpTlrTakeoff $takeoff,
        SimBriefOfpTlrLanding $landing,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            takeoff: SimBriefOfpTlrTakeoff::from($data['takeoff'] ?? []),
            landing: SimBriefOfpTlrLanding::from($data['landing'] ?? []),
        );
    }
}
