<?php

namespace Myli\Testing;

use Illuminate\Support\Carbon;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Myli\DatadogLogger\DataDogFormatter;


/**
 * Class DataDogFormatterTest
 *
 * @author    Aurélien SCHILTZ <aurelien@myli.io>
 * @copyright 2016-2019 Myli
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class DataDogFormatterTest extends \PHPUnit\Framework\TestCase
{
    use \phpmock\phpunit\PHPMock;

    /**
     * @dataProvider recordProvider
     *
     * @param array  $inputRecord
     * @param string $expectedRecord
     *
     * @return void
     */
    public function testFormatRecord(array $inputRecord, string $expectedRecord)
    {
        $gethostnameFunction = $this->getFunctionMock('\Myli\DatadogLogger', "gethostname");
        $configFunction = $this->getFunctionMock('\Myli\DatadogLogger', "config");
        $gethostnameFunction->expects($this->any())->willReturn('foohostname');
        $configFunction->expects($this->any())->willReturn('laravel-datadog-logger');
        $dataDogFormatter = new \Myli\DatadogLogger\DataDogFormatter();

        $record = $dataDogFormatter->format($inputRecord);

        self::assertEquals($expectedRecord, $record);
    }

    /**
     * Test Invoke DataDogFormatter
     *
     * @return void
     * @throws \Exception
     */
    public function testInvoke()
    {
        $loggerMock = $this->createMock(Logger::class);
        $streamHandler = new StreamHandler('foourl');
        $loggerMock->method('getHandlers')->willReturn([$streamHandler]);
        $laravelLogger = new \Illuminate\Log\Logger($loggerMock);
        $dataDogFormatter = new \Myli\DatadogLogger\DataDogFormatter();
        $dataDogFormatter->__invoke($laravelLogger);
        self::assertEquals(DataDogFormatter::class, get_class($streamHandler->getFormatter()));
    }

    public function recordProvider()
    {
        return [
            [
                [
                    "message"    => "test",
                    "context"    => [],
                    "level"      => 200,
                    "level_name" => "INFO",
                    "channel"    => null,
                    "datetime"   => new Carbon('2019-08-14 09:58:10.764107', 'UTC'),
                    "extra"      => []
                ],
                '{"message":"test","context":[],"level":200,"level_name":"INFO","channel":null,"datetime":"2019-08-14T09:58:10.764107Z","extra":[],"published_date":"2019-08-14T09:58:10+0000","status":"INFO","ddsource":"php-cli","service":"laravel-datadog-logger","hostname":"foohostname"}' . PHP_EOL
            ],
            [
                [
                    "message"    => "test",
                    "context"    => [
                        'toto' => 'tata'
                    ],
                    "level"      => 100,
                    "level_name" => "DEBUG",
                    "channel"    => null,
                    "datetime"   => new Carbon('2019-08-14 09:58:10.764107', 'UTC'),
                    "extra"      => []
                ],
                '{"message":"test","context":{"toto":"tata"},"level":100,"level_name":"DEBUG","channel":null,"datetime":"2019-08-14T09:58:10.764107Z","extra":[],"published_date":"2019-08-14T09:58:10+0000","status":"DEBUG","ddsource":"php-cli","service":"laravel-datadog-logger","hostname":"foohostname"}' . PHP_EOL
            ]
        ];

    }
}
