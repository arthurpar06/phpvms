<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Service;
use App\Exceptions\ModuleExistsException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
// use Madnest\Madzipper\Madzipper;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use ZipArchive;

class ModuleService extends Service
{
    protected static array $adminLinks = [];

    /**
     * @var array 0 == logged out, 1 == logged in
     */
    protected static array $frontendLinks = [
        0 => [],
        1 => [],
    ];

    /**
     * Add a module link in the frontend
     */
    public function addFrontendLink(string $title, string $url, string $icon = 'bi bi-people', bool $logged_in = true): void
    {
        self::$frontendLinks[$logged_in][] = [
            'title' => $title,
            'url'   => $url,
            'icon'  => $icon,
        ];
    }

    /**
     * Get all of the frontend links
     */
    public function getFrontendLinks(mixed $logged_in): array
    {
        return self::$frontendLinks[$logged_in];
    }

    /**
     * Add a module link in the admin panel
     */
    public function addAdminLink(string $title, string $url, string $icon = 'bi bi-people'): void
    {
        self::$adminLinks[] = [
            'title' => $title,
            'url'   => $url,
            'icon'  => $icon,
        ];
    }

    /**
     * Get all of the module links in the admin panel
     */
    public function getAdminLinks(): array
    {
        return self::$adminLinks;
    }

    /**
     * Get all of the modules from database but make sure they also exist on disk
     */
    public function getAllModules(): array
    {
        return Module::all();
    }

    /**
     * Determine if a module is active - also checks that the module exists properly
     */
    public function isModuleActive(string $name): bool
    {
        /** @var ?\Nwidart\Modules\Module $module */
        $module = Module::find($name);

        if (!$module) {
            return false;
        }

        if (!file_exists($module->getPath())) {
            return false;
        }

        return $module->isEnabled();
    }

    /**
     * @throws ConnectionException
     */
    public function installFromRegistry(string $registryName, bool $update = false): void
    {
        $packageDetails = app(AddonRegistryService::class)->getPackageDetails($registryName);

        if (!$packageDetails) {
            throw new \RuntimeException('Package not found in registry.');
        }

        $zipUrl = $packageDetails->zip_url;

        $tempPath = storage_path('app/tmp/modules/'.Str::uuid().'.zip');
        File::ensureDirectoryExists(dirname($tempPath));

        Http::sink($tempPath)->get($zipUrl);

        if (hash_file('sha256', $tempPath) !== $packageDetails->sha256) {
            unlink($tempPath);
            throw new \RuntimeException('Downloaded module failed integrity check.');
        }

        $zip = new ZipArchive();
        if ($zip->open($tempPath) === true) {
            $extractPath = storage_path('app/tmp/modules/extract_'.Str::uuid());
            $zip->extractTo($extractPath);
            $zip->close();

            $directories = File::directories($extractPath);
            $sourceDir = count($directories) === 1 ? $directories[0] : $extractPath;

            $jsonFile = $sourceDir.'/module.json';
            if (!File::exists($jsonFile)) {
                File::deleteDirectory($extractPath);
                unlink($tempPath);
                throw new \RuntimeException('Invalid module format. No module.json found.');
            }

            $json = json_decode(file_get_contents($jsonFile), true);
            $moduleName = $json['name'];

            $destDir = base_path('modules/'.$moduleName);
            if (File::exists($destDir)) {
                if ($update) {
                    File::deleteDirectory($destDir);
                } else {
                    File::deleteDirectory($extractPath);
                    unlink($tempPath);
                    throw new ModuleExistsException($moduleName);
                }
            }

            File::moveDirectory($sourceDir, $destDir);

            File::deleteDirectory($extractPath);
            unlink($tempPath);

            /** @var ?\Nwidart\Modules\Module $module */
            $module = Module::find($moduleName);
            $module?->enable();

            if (file_exists(base_path('bootstrap/cache/modules.php'))) {
                unlink(base_path('bootstrap/cache/modules.php'));
            }

            Artisan::call('module:migrate', ['module' => $moduleName, '--force' => true]);

        } else {
            unlink($tempPath);
            throw new \RuntimeException('Failed to extract zip file.');
        }
    }

    /**
     * Update module with the status passed by user.
     */
    public function updateModule(string $name, bool $enabled): void
    {
        /** @var ?\Nwidart\Modules\Module $module */
        $module = Module::find($name);

        if (!$module) {
            return;
        }

        $module->setActive($enabled);

        if ($enabled) {
            Artisan::call('module:migrate', ['module' => $name, '--force' => true]);
        }

        if (file_exists(base_path('bootstrap/cache/modules.php'))) {
            unlink(base_path('bootstrap/cache/modules.php'));
        }
    }

    /**
     * Delete Module from the Storage & Database.
     */
    public function deleteModule(string $name): void
    {
        /** @var ?\Nwidart\Modules\Module $module */
        $module = Module::find($name);

        if (!$module) {
            return;
        }

        $module->delete();

        if (file_exists(base_path('bootstrap/cache/modules.php'))) {
            unlink(base_path('bootstrap/cache/modules.php'));
        }
    }
}
