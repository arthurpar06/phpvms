<?php

namespace App\Dto\SimBriefOfp;

use Spatie\LaravelData\Dto;

class SimBriefOfpFmsDownloads extends Dto
{
    /**
     * @param SimBriefOfpFile[] $files
     */
    public function __construct(
        public string $directory,
        public array $files,
    ) {}

    public static function fromArray(array $data): static
    {
        $directory = $data['directory'];
        $files = [];

        foreach ($data as $key => $value) {
            if ($key === 'directory') {
                continue;
            }

            if (is_array($value) && isset($value['name'], $value['link'])) {
                $files[$key] = SimBriefOfpFile::from($value);
            }
        }

        return new self(
            directory: $directory,
            files: $files
        );
    }
}
