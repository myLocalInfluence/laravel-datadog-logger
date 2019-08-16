<?php

namespace Myli\Testing;

use Monolog\Handler\MissingExtensionException;
use Myli\DatadogLogger\Api\CreateDataDogApiLogger;
use Myli\DatadogLogger\Api\DataDogApiHandler;
use Myli\DatadogLogger\ApiKeyNotFoundException;
use PHPUnit\Framework\TestCase;


/**
 * Class CreateDataDogApiLoggerTest
 *
 * @package   Myli\Testing
 * @author    Aurélien SCHILTZ <aurelien@myli.io>
 * @copyright 2016-2019 Myli
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class CreateDataDogApiLoggerTest extends TestCase
{

    /**
     * Short description here
     *
     * @return void
     * @throws MissingExtensionException
     */
    public function testConfigFileEuRegion()
    {
        $dataDogLoggerCreator = new CreateDataDogApiLogger();
        $configFile           = [
            'apiKey' => 'apiKey',
            'level'  => 200,
            'region' => 'eu',
            'bubble' => false
        ];
        $dataDogLogger        = $dataDogLoggerCreator->__invoke($configFile);
        /**
         * @var DataDogApiHandler $dataDogHandler
         */
        $dataDogHandler = $dataDogLogger->getHandlers()[0];
        self::assertEquals(false, $dataDogHandler->getBubble());
        self::assertEquals(200, $dataDogHandler->getLevel());
        self::assertEquals('eu', $dataDogHandler->getRegion());
        self::assertEquals('apiKey', $dataDogHandler->getToken());
    }

    /**
     * Short description here
     *
     * @return void
     * @throws MissingExtensionException
     */
    public function testConfigFileUsRegion()
    {
        $dataDogLoggerCreator = new CreateDataDogApiLogger();
        $configFile           = [
            'apiKey' => 'apiKey',
            'level'  => 200,
            'region' => 'us',
            'bubble' => false
        ];
        $dataDogLogger        = $dataDogLoggerCreator->__invoke($configFile);
        /**
         * @var DataDogApiHandler $dataDogHandler
         */
        $dataDogHandler = $dataDogLogger->getHandlers()[0];
        self::assertEquals(false, $dataDogHandler->getBubble());
        self::assertEquals(200, $dataDogHandler->getLevel());
        self::assertEquals('us', $dataDogHandler->getRegion());
        self::assertEquals('apiKey', $dataDogHandler->getToken());
    }

    /**
     * Short description here
     *
     * @return void
     * @throws MissingExtensionException
     */
    public function testConfigFileNoRegion()
    {
        $dataDogLoggerCreator = new CreateDataDogApiLogger();
        $configFile           = [
            'apiKey' => 'apiKey',
            'level'  => 200,
            'bubble' => false
        ];
        $dataDogLogger        = $dataDogLoggerCreator->__invoke($configFile);
        /**
         * @var DataDogApiHandler $dataDogHandler
         */
        $dataDogHandler = $dataDogLogger->getHandlers()[0];
        self::assertEquals(false, $dataDogHandler->getBubble());
        self::assertEquals(200, $dataDogHandler->getLevel());
        self::assertEquals('us', $dataDogHandler->getRegion());
        self::assertEquals('apiKey', $dataDogHandler->getToken());
    }

    /**
     * Short description here
     *
     * @return void
     * @throws MissingExtensionException
     */
    public function testConfigFileNoConfigExceptApiKey()
    {
        $dataDogLoggerCreator = new CreateDataDogApiLogger();
        $configFile           = [
            'apiKey' => 'apiKey',
        ];
        $dataDogLogger        = $dataDogLoggerCreator->__invoke($configFile);
        /**
         * @var DataDogApiHandler $dataDogHandler
         */
        $dataDogHandler = $dataDogLogger->getHandlers()[0];
        self::assertEquals(true, $dataDogHandler->getBubble());
        self::assertEquals(100, $dataDogHandler->getLevel());
        self::assertEquals('us', $dataDogHandler->getRegion());
        self::assertEquals('apiKey', $dataDogHandler->getToken());
    }

    /**
     * Short description here
     *
     * @return void
     * @throws MissingExtensionException
     */
    public function testConfigFileNoApiKey()
    {
        $dataDogLoggerCreator = new CreateDataDogApiLogger();
        self::expectException(ApiKeyNotFoundException::class);
        self::expectExceptionMessage('apiKey not set for DataDogLogger');
        self::expectExceptionCode(500);
        $dataDogLogger = $dataDogLoggerCreator->__invoke([]);
        /**
         * @var DataDogApiHandler $dataDogHandler
         */
        $dataDogHandler = $dataDogLogger->getHandlers()[0];
    }

}
