<?php

namespace App\Support\Modules;

use Exception;
use Illuminate\Config\Repository as Config;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Nwidart\Modules\Contracts\ActivatorInterface;
use Nwidart\Modules\Module;

class DatabaseActivator implements ActivatorInterface
{
    /**
     * Laravel config instance
     *
     * @var Config
     *
     * private $config;*/

    /**
     * @var Filesystem
     *
     * private $files;
     */

    /**
     * The module path.
     *
     * @var string|null
     */
    protected $path;

    /**
     * The scanned paths.
     *
     * @var array
     */
    protected $paths = [];

    /*
    /**
     * Array of modules activation statuses
     *
     * @var array
     *
    private $modulesStatuses;
    */

    public function __construct($path = null)
    {
        //$this->config = $app['config'];
        //$this->files = $app['files'];
        //$this->modulesStatuses = $this->getModulesStatuses();
        $this->path = $path;
    }

    /**
     * @param string $name
     *
     * @return \App\Models\Module|null
     */
    public function getModuleByName(string $name): ?\App\Models\Module
    {
        try {
            if (app()->environment('production')) {
                $cache = config('cache.keys.MODULES');
                return Cache::remember($cache['key'].'.'.$name, $cache['time'], function () use ($name) {
                    /** @var ?\App\Models\Module */
                    return \App\Models\Module::where(['name' => $name])->first();
                });
            } else {
                /** @var ?\App\Models\Module */
                return \App\Models\Module::where(['name' => $name])->first();
            }
        } catch (Exception $e) { // Catch any database/connection errors
            return null;
        }
    }

    /**
     * Get modules statuses, from the database
     *
     * @return array
     */
    /*
    private function getModulesStatuses(): array
    {
        try {
            if (app()->environment('production')) {
                $cache = config('cache.keys.MODULES');
                $retVal = Cache::remember($cache['key'], $cache['time'], function () {
                    /** @var Collection<int, \App\Models\Module> $modules *
                    $modules = \App\Models\Module::select('name', 'enabled')->get();

                    $retValCache = [];
                    foreach ($modules as $i) {
                        $retValCache[$i->name] = $i->enabled;
                    }

                    return $retValCache;
                });
            } else {
                /** @var Collection<int, \App\Models\Module> $modules *
                $modules = \App\Models\Module::select('name', 'enabled')->get();

                $retVal = [];
                foreach ($modules as $i) {
                    $retVal[$i->name] = $i->enabled;
                }
            }
            return $retVal;
        } catch (Exception $e) {
            return [];
        }
    }
    */

    /**
     * {@inheritdoc}
     */
    public function reset(): void
    {
        (new \App\Models\Module())->truncate();
    }

    /**
     * {@inheritdoc}
     */
    public function enable(Module $module): void
    {
        $this->setActive($module, true);
    }

    /**
     * {@inheritdoc}
     */
    public function disable(Module $module): void
    {
        $this->setActive($module, false);
    }

    /**
     * \Nwidart\Modules\Module instance passed
     * {@inheritdoc}
     */
    public function hasStatus(Module $module, bool $status): bool
    {
        $module = $this->getModuleByName($module->getName());
        if (!$module) {
            return false;
        }

        return $module->enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function setActive(Module $module, bool $active): void
    {
        $DBModule = $this->getModuleByName($module->getName());
        if (!$DBModule) {
            /** @var \App\Models\Module $DBModule */
            $DBModule = \App\Models\Module::create([
                'name' => $module->getName(),
            ]);
        }

        $DBModule->enabled = $active;
        $DBModule->save();
    }

    /**
     * {@inheritdoc}
     */
    public function setActiveByName(string $name, bool $status): void
    {
        $module = $this->getModuleByName($name);
        if (!$module) {
            return;
        }

        $module->enabled = $status;
        $module->save();
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Module $module): void
    {
        $name = $module->getName();

        try {
            (new \App\Models\Module())->where([
                'name' => $name,
            ])->delete();
        } catch (Exception $e) {
            Log::error('Module '.$module.' Delete failed! Exception : '.$e->getMessage());
            return;
        }
    }
}
