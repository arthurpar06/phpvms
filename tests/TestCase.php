<?php

declare(strict_types=1);

namespace Tests;

use App\Services\DatabaseService;
use App\Services\Installer\SeederService;
use Database\Seeders\ShieldSeeder;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Override;

abstract class TestCase extends BaseTestCase
{
    #[Override]
    protected function setUp(): void
    {
        $start = microtime(true);
        parent::setUp();
        /*
                Filament::setCurrentPanel('admin');

                $this->seed(ShieldSeeder::class);

                $seederSvc = app(SeederService::class);
                $seederSvc->syncAllSeeds();

                $databaseSvc = app(DatabaseService::class);
                $databaseSvc->seed_from_yaml_file(base_path('tests/data/base.yml'));
        */
        dump('Boot: '.round(microtime(true) - $start, 3).'s');
    }
}
