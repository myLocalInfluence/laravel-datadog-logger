<?php

namespace Myli\Testing;

use Monolog\Handler\MissingExtensionException;
use Monolog\Logger;
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
     * @throws ApiKeyNotFoundException
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
        self::assertEquals(Logger::class, get_class($dataDogLoggerCreator->__invoke($configFile)));
    }

    /**
     * Short description here
     *
     * @return void
     * @throws ApiKeyNotFoundException
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

        self::assertEquals(Logger::class, get_class($dataDogLoggerCreator->__invoke($configFile)));
    }

    /**
     * Short description here
     *
     * @return void
     * @throws ApiKeyNotFoundException
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
        self::assertEquals(Logger::class, get_class($dataDogLoggerCreator->__invoke($configFile)));
    }

    /**
     * Short description here
     *
     * @return void
     * @throws ApiKeyNotFoundException
     * @throws MissingExtensionException
     */
    public function testConfigFileNoConfigExceptApiKey()
    {
        $dataDogLoggerCreator = new CreateDataDogApiLogger();
        $configFile           = [
            'apiKey' => 'apiKey',
        ];
        self::assertEquals(Logger::class, get_class($dataDogLoggerCreator->__invoke($configFile)));
    }

    /**
     * Short description here
     *
     * @return void
     * @throws ApiKeyNotFoundException
     * @throws MissingExtensionException
     */
    public function testConfigFileNoApiKey()
    {
        $dataDogLoggerCreator = new CreateDataDogApiLogger();
        self::expectException(ApiKeyNotFoundException::class);
        self::expectExceptionMessage('apiKey not set for DataDogLogger');
        self::expectExceptionCode(500);
        $dataDogLoggerCreator->__invoke([]);
    }

}
