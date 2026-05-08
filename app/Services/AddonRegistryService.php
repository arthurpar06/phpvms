<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Service;
use App\Support\Dto\AddonRegistry\PackageDetailDto;
use App\Support\Dto\AddonRegistry\PackageDto;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Nwidart\Modules\Facades\Module;

class AddonRegistryService extends Service
{
    private const string BASE_URL = 'https://api.registry.phpvms.net';

    /**
     * @throws ConnectionException
     */
    public function getPackages(): array
    {
        $response = Http::get(self::BASE_URL.'/v1/packages');

        if (!$response->successful()) {
            return PackageDto::collect([]);
        }

        return PackageDto::collect($response->json());
    }

    public function getPackageDetails(string $name): ?PackageDetailDto
    {
        $version = app(VersionService::class)->getCurrentVersion(false);
        $hostId = hash('sha256', (string) config('app.key', config('app.url')));
        $addonsCount = count(Module::all());

        $response = Http::post(self::BASE_URL.'/v1/packages/'.$name, [
            'host_id' => $hostId,
            'host'    => [
                'version'      => $version,
                'php'          => PHP_VERSION,
                'addons_count' => $addonsCount,
            ],
        ]);

        if (!$response->successful()) {
            return null;
        }

        return PackageDetailDto::from($response->json());
    }
}
