<?php

namespace Myli\Testing;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase;
use Monolog\Handler\StreamHandler;
use Myli\DatadogLogger\Agent\CreateDataDogAgentLogger;


/**
 * Class CreateDataDogAgentLoggerTest
 *
 * @package   Myli\Testing
 * @author    Aurélien SCHILTZ <aurelien@myli.io>
 * @copyright 2016-2019 Myli
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class CreateDataDogAgentLoggerTest extends TestCase
{
    /**
     * Creates the application.
     * Needs to be implemented by subclasses.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $app = new Application(
            $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
        );

        return $app;
    }

    /**
     * Short description here
     *
     * @return void
     * @throws \Exception
     */
    public function testNoPathProvided()
    {
        $dataDogLoggerCreator = new CreateDataDogAgentLogger();
        $pathEnvValue         = '';
        $configFile           = [
            'path'       => storage_path($pathEnvValue),
            'level'      => 200,
            'bubble'     => false,
            'permission' => 0644,
            'lock'       => false,
        ];
        $dataDogLogger        = $dataDogLoggerCreator->__invoke($configFile);
        /**
         * @var StreamHandler $streamHandler
         */
        $dataDogHandler = (array) $dataDogLogger->getHandlers()[0];
        self::assertEquals(false, $dataDogHandler["\x00*\x00bubble"]);
        self::assertEquals(200, $dataDogHandler["\x00*\x00level"]);
        self::assertEquals(0644, $dataDogHandler["\x00*\x00filePermission"]);
        self::assertEquals(storage_path() . '/logs/laravel-json-datadog-cli.log', $dataDogHandler["\x00*\x00url"]);
        self::assertEquals(false, $dataDogHandler["\x00*\x00useLocking"]);
    }

    /**
     * Short description here
     *
     * @return void
     * @throws \Exception
     */
    public function testPathProvided()
    {
        $dataDogLoggerCreator = new CreateDataDogAgentLogger();
        $pathEnvValue         = 'the/test/file.log';
        $configFile           = [
            'path'       => storage_path($pathEnvValue),
            'level'      => 200,
            'bubble'     => true,
            'permission' => 0644,
            'lock'       => true,
        ];
        $dataDogLogger        = $dataDogLoggerCreator->__invoke($configFile);
        /**
         * @var StreamHandler $streamHandler
         */
        $dataDogHandler = (array) $dataDogLogger->getHandlers()[0];
        self::assertEquals(true, $dataDogHandler["\x00*\x00bubble"]);
        self::assertEquals(200, $dataDogHandler["\x00*\x00level"]);
        self::assertEquals(0644, $dataDogHandler["\x00*\x00filePermission"]);
        self::assertEquals(storage_path() . '/the/test/file-cli.log', $dataDogHandler["\x00*\x00url"]);
        self::assertEquals(true, $dataDogHandler["\x00*\x00useLocking"]);

    }

}
