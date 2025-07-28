<?php

namespace App\Dto\SimBriefOfp;

use Spatie\LaravelData\Dto;

final class SimBriefOfpFiles extends Dto
{
    /**
     * @param SimBriefOfpFile[] $file
     */
    public function __construct(
        public string $directory,
        public SimBriefOfpFile $pdf,
        public array $file
    ) {}
}
