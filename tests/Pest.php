<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

use App\Services\DatabaseService;
use App\Services\Installer\SeederService;
use Database\Seeders\ShieldSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;

use function Pest\Laravel\seed;

pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->beforeEach(function (): void {
        // Only seed for the first test
        static $initialized = false;

        if (!$initialized) {
            app(SeederService::class)->syncAllSeeds();
            app(DatabaseService::class)->seed_from_yaml_file(base_path('tests/data/base.yml'));

            seed(ShieldSeeder::class);

            $initialized = true;
        }
    })
    ->in('Unit', 'Feature', 'Arch', '../resources/views');
// ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
