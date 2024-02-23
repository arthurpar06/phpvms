<?php

use App\Contracts\Migration;
use App\Services\Installer\ConfigService;

/**
 * Migrate the configuration files
 */
return new class() extends Migration {
    public function up()
    {
        //$configSvc = app(ConfigService::class);
        //$configSvc->rewriteConfigFiles();
    }

    public function down()
    {
    }
};
