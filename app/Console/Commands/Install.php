<?php

namespace App\Console\Commands;

use App\Services\Installer\InstallerService;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\form;
use function Laravel\Prompts\info;
use function Laravel\Prompts\text;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phpvms:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up your phpvms application';

    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Return the stub file path based on the user's choices
     * @param array $responses
     * @return string
     */
    public function getStubPath(array $responses): string
    {
        $filename = 'env_'.$responses['environment'].'.stub';
        return resource_path("stubs/installer/".$filename);
    }

    /**
     * Map the stub variables present in the stub to its value
     *
     * @param  array  $responses
     * @return array
     */
    public function getStubVariables(array $responses): array
    {
        return [

        ];
    }

    /**
     * Get the stub path and the stub variables
     *
     * @param array $responses
     * @return mixed
     */
    public function getSourceFile(array $responses): mixed
    {
        return $this->getStubContents($this->getStubPath($responses), $this->getStubVariables($responses));
    }


    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param  string  $stub
     * @param  array  $stubVariables
     * @return mixed
     */
    public function getStubContents(string $stub , array $stubVariables = []): mixed
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace)
        {
            $contents = str_replace('$'.$search.'$' , $replace, $contents);
        }

        return $contents;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        info('Installing phpVMS...');

        info('1. Environment setup');

        $responses = form()
            ->select('What environment do you want to use?', ['local', 'production'], name: 'environment')
            ->select('Which database connection do you want to use?', [
                'sqlite' => 'SQLite (recommended for local)',
                'mysql' => 'MySQL (recommended for production)',
                'mariadb' => 'MariaDB (recommended for production)',
            ], name: 'database')
            ->add(function ($responses) {
                // We don't ask about docker in production because this should be configured manually
                if ($responses['environment'] === 'production') return false;

                return confirm('Do you want to use docker?');
            }, name: 'docker')
            ->text('What\'s your Virtual Airline name?', name: 'name')
            ->add(function ($responses) {
                // Only store the website url if we are in production
                if ($responses['environment'] === 'local') {
                    return null;
                }

                return text('What\'s your website url?');
            }, name: 'url')
            ->add(function ($responses) {
                if ($responses['database'] === 'sqlite') {
                    // no creds required for sqlite just sample
                    return [
                        'host' => '127.0.0.1',
                        'port' => 3306,
                        'database' => 'phpvms',
                        'username' => 'root',
                        'password' => '',
                        'prefix' => '',
                        ];
                }

                if ($responses['docker'] === true) {
                    // sail creds
                    return [
                        'host' => 'mariadb',
                        'port' => 3306,
                        'database' => 'testing',
                        'username' => 'root',
                        'password' => '',
                        'prefix' => '',
                    ];
                }

                return form()
                    ->text('What\'s your mysql host?', default: '127.0.0.1', name: 'host')
                    ->text('What\'s your mysql port?', default: 3306, name: 'port')
                    ->text('What\'s your database name?', name: 'database')
                    ->text('What\'s your mysql user?', name: 'user')
                    ->text('What\'s your mysql password?', name: 'password')
                    ->text('What\'s your database prefix?', name: 'prefix')
                    ->submit();
            }, name: 'db')
            ->submit();

        info('Creating .env');

        $contents = $this->getSourceFile($responses);
        $this->files->put(base_path('.env'), $contents);

        info('.env file created');

        info('2. Generating app key');
        Artisan::call('key:generate');

        info('Install completed');
    }

}
