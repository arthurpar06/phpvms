<?php

namespace App\Dto\SimBriefOfp;

use Spatie\LaravelData\Dto;

final class SimBriefOfpFile extends Dto
{
    public function __construct(public string $name, public string $link) {}
}
