<?php

use App\Services\AddonRegistryService;
use App\Support\Dto\AddonRegistry\PackageDto;
use Illuminate\Support\Facades\Http;

it('fetches packages from the registry', function (): void {
    Http::fake([
        'api.registry.phpvms.net/v1/packages' => Http::response([
            [
                'name'        => 'phpvms/smoke-test',
                'description' => 'A test package',
                'category'    => 'dev-tools',
                'official'    => true,
                'release'     => '1.0.0',
                'stats'       => [
                    'installs_total' => 10,
                    'installs_30d'   => 5,
                ],
            ],
        ], 200),
    ]);

    $service = app(AddonRegistryService::class);
    $packages = $service->getPackages();

    expect($packages)->toBeArray()
        ->and($packages)->toHaveCount(1)
        ->and($packages[0])->toBeInstanceOf(PackageDto::class)
        ->and($packages[0]->name)->toBe('phpvms/smoke-test')
        ->and($packages[0]->official)->toBeTrue()
        ->and($packages[0]->stats->installs_total)->toBe(10);
});

it('fetches package details from the registry with host telemetry', function (): void {
    Http::fake([
        'api.registry.phpvms.net/v1/packages/phpvms/smoke-test' => Http::response([
            'name'           => 'phpvms/smoke-test',
            'repository_url' => 'https://github.com',
            'version'        => '1.0.0',
            'zip_url'        => 'https://github.com/zip',
            'sha256'         => 'dummyhash',
        ], 200),
    ]);

    $service = app(AddonRegistryService::class);
    $packageDetails = $service->getPackageDetails('phpvms/smoke-test');

    expect($packageDetails)->not->toBeNull()
        ->and($packageDetails->name)->toBe('phpvms/smoke-test')
        ->and($packageDetails->version)->toBe('1.0.0')
        ->and($packageDetails->sha256)->toBe('dummyhash');

    Http::assertSent(function ($request): bool {
        $body = $request->data();

        return $request->url() == 'https://api.registry.phpvms.net/v1/packages/phpvms/smoke-test' &&
               $request->method() == 'POST' &&
               isset($body['host_id']) &&
               isset($body['host']['version']) &&
               isset($body['host']['php']) &&
               isset($body['host']['addons_count']);
    });
});
