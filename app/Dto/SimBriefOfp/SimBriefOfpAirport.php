<?php

namespace App\Dto\SimBriefOfp;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Dto;

final class SimBriefOfpAirport extends Dto
{
    /**
     * @param SimBriefOfpAtis[]  $atis
     * @param SimBriefOfpNotam[] $notam
     */
    public function __construct(
        public string $icao_code,
        public string $iata_code,
        public string $faa_code,
        public string $icao_region,
        public int $elevation,
        public float $pos_lat,
        public float $pos_long,
        public string $name,
        public float $timezone,
        public string $plan_rwy,
        public int $trans_alt,
        public int $trans_level,
        public string $metar,
        #[Date]
        public CarbonImmutable $metar_time,
        public string $metar_category,
        public int $metar_visibility,
        public int $metar_ceiling,
        public string $taf,
        #[Date]
        public CarbonImmutable $taf_time,
        public array $atis,
        public array $notam
    ) {}
}
