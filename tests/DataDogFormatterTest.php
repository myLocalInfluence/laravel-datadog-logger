<?php

use Illuminate\Support\Carbon;


/**
 * Class DataDogFormatterTest
 *
 * @author    Aurélien SCHILTZ <aurelien@myli.io>
 * @copyright 2016-2019 Myli
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class DataDogFormatterTest extends \PHPUnit\Framework\TestCase
{

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
        $dataDogFormatter = new \Myli\DatadogLogger\DataDogFormatter();

        $record = $dataDogFormatter->format($inputRecord);

        self::assertEquals($expectedRecord, $record);
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
                '{"message":"test","context":[],"level":200,"level_name":"INFO","channel":null,"datetime":"2019-08-14T09:58:10.764107Z","extra":[],"published_date":"2019-08-14T09:58:10+0000","status":"INFO"}' . PHP_EOL
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
                '{"message":"test","context":{"toto":"tata"},"level":100,"level_name":"DEBUG","channel":null,"datetime":"2019-08-14T09:58:10.764107Z","extra":[],"published_date":"2019-08-14T09:58:10+0000","status":"DEBUG"}' . PHP_EOL
            ]
        ];

    }
}
