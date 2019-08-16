<?php

namespace Myli\Testing;

use Monolog\Handler\MissingExtensionException;
use Myli\DatadogLogger\CreateDataDogLogger;
use Myli\DatadogLogger\DataDogHandler;
use PHPUnit\Framework\TestCase;


/**
 * Class DataDogLoggerTest
 *
 * @author    Aurélien SCHILTZ <aurelien@myli.io>
 * @copyright 2016-2019 Myli
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class CreateDataDogLoggerTest extends TestCase
{

    /**
     * Short description here
     *
     * @return void
     * @throws MissingExtensionException
     */
    public function testConfigFileEuRegion()
    {
        $dataDogLoggerCreator = new CreateDataDogLogger();
        $configFile           = [
            'apiKey' => 'apiKey',
            'level'  => 200,
            'region' => 'eu',
            'bubble' => false
        ];
        $dataDogLogger        = $dataDogLoggerCreator->__invoke($configFile);
        /**
         * @var DataDogHandler $dataDogHandler
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
        $dataDogLoggerCreator = new CreateDataDogLogger();
        $configFile           = [
            'apiKey' => 'apiKey',
            'level'  => 200,
            'region' => 'us',
            'bubble' => false
        ];
        $dataDogLogger        = $dataDogLoggerCreator->__invoke($configFile);
        /**
         * @var DataDogHandler $dataDogHandler
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
        $dataDogLoggerCreator = new CreateDataDogLogger();
        $configFile           = [
            'apiKey' => 'apiKey',
            'level'  => 200,
            'bubble' => false
        ];
        $dataDogLogger        = $dataDogLoggerCreator->__invoke($configFile);
        /**
         * @var DataDogHandler $dataDogHandler
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
        $dataDogLoggerCreator = new CreateDataDogLogger();
        $configFile           = [
            'apiKey' => 'apiKey',
        ];
        $dataDogLogger        = $dataDogLoggerCreator->__invoke($configFile);
        /**
         * @var DataDogHandler $dataDogHandler
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
        $dataDogLoggerCreator = new CreateDataDogLogger();
        self::expectException(\Exception::class);
        self::expectExceptionMessage('apiKey not set for DataDogLogger');
        $dataDogLogger = $dataDogLoggerCreator->__invoke([]);
        /**
         * @var DataDogHandler $dataDogHandler
         */
        $dataDogHandler = $dataDogLogger->getHandlers()[0];
    }

}
