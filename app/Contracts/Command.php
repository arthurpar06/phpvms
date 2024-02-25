<?php

namespace App\Contracts;

use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

use function is_array;

/**
 * Class BaseCommand
 */
abstract class Command extends \Illuminate\Console\Command
{
    /**
     * @return mixed
     */
    abstract public function handle();

    /**
     * Adjust the logging depending on where we're running from
     */
    public function __construct()
    {
        parent::__construct();

        // Running in the console but not in the tests
        /*if (app()->runningInConsole() && env('APP_ENV') !== 'testing') {
            $this->redirectLoggingToFile('stdout');
        }*/
    }

    /**
     * Return the signature of the command
     *
     * @return string
     */
    public function getSignature(): string
    {
        return $this->signature;
    }

    /**
     * Splice the logger and replace the active handlers with the handlers from the
     * a stack in config/logging.php
     *
     * @param string $channel_name Channel name from config/logging.php
     */
    public function redirectLoggingToFile(string $channel_name): void
    {
        // If the channel exists in the logging config, redirect the logging to it
        if (array_key_exists($channel_name, config('logging.channels'))) {
            config(['logging.default' => $channel_name]);
        } else {
            Log::error('Failed to redirect logging to '.$channel_name);
        }
    }

    /**
     * Streaming file reader
     *
     * @param $filename
     *
     * @return \Generator
     */
    public function readFile($filename): ?\Generator
    {
        $fp = fopen($filename, 'rb');
        while (($line = fgets($fp)) !== false) {
            $line = rtrim($line, "\r\n");
            if ($line[0] === ';') {
                continue;
            }

            yield $line;
        }

        fclose($fp);
    }
}
