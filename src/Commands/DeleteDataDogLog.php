<?php

/*
 *
 *     MyWorkers by myli.io
 *
 */

namespace Myli\DatadogLogger\Commands;

use Illuminate\Console\Command;
use Illuminate\Log\Logger;

/**
 * Class DeleteDataDogLog
 *
 * @package   App\Console\Commands
 * @author    Aurélien SCHILTZ <aurelien@myli.io>
 * @copyright 2016-2019 Myli
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class DeleteDataDogLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:datadog:log';

    /**
     * The console command description
     *
     * @var string
     */
    protected $description = 'Delete all datadog logs, advice to set this command in a cron at midnight.';

    const FILENAME_KEY = 'filename';

    /**
     * @var Logger $logger
     */
    protected $logger;

    /**
     * Short description here
     *
     * @param Logger $logger
     *
     * @return void
     */
    public function handle(Logger $logger)
    {
        $this->logger = $logger;
        $this->logger->info(__FUNCTION__ . '()' . __CLASS__);

        $dataDogAgentPath = config('logging.channels.datadog-agent.path');
        // Check if the path to data dog agent log file is not empty AND
        // the env value of the file to store logs in is not also empty
        if ($dataDogAgentPath !== null && substr($dataDogAgentPath, - 7) !== 'storage') {
            $this->logger->info(__FUNCTION__ . '()' . __CLASS__ . ' checking for deletion...');
            $this->deleteLog($dataDogAgentPath);
        }
    }

    private function deleteLog(string $filePath)
    {
        $pathInfo    = pathinfo($filePath);
        $fileNameCli = str_replace(
            $pathInfo[self::FILENAME_KEY],
            $pathInfo[self::FILENAME_KEY] . '-cli',
            $filePath
        );
        $fileNameFpm = str_replace(
            $pathInfo[self::FILENAME_KEY],
            $pathInfo[self::FILENAME_KEY] . '-fpm-fcgi',
            $filePath
        );
        if (\file_exists($fileNameCli)) {
            $this->logger->info(__FUNCTION__ . '()' . __CLASS__ . ' Deleted CLI file', [
                'path' => $fileNameCli
            ]);
            unlink($fileNameCli);
        }
        if (\file_exists($fileNameFpm)) {
            $this->logger->info(__FUNCTION__ . '()' . __CLASS__ . ' Deleted FPM file', [
                'path' => $fileNameFpm
            ]);
            unlink($fileNameFpm);
        }
    }
}
