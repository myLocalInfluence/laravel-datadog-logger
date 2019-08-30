<?php

namespace Myli\DatadogLogger\Agent;

use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class CreateDataDogAgentLogger
 *
 * @package   Myli\DatadogLogger
 * @author    Aurélien SCHILTZ <aurelien@myli.io>
 * @copyright 2016-2019 Myli
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class CreateDataDogAgentLogger
{
    /**
     * Create DataDog Agent Logger
     *
     * @param array $config
     *
     * @return Logger
     * @throws Exception
     */
    public function __invoke(array $config)
    {
        if ($config['path'] === storage_path()) {
            $config['path'] = storage_path('logs/laravel-json-datadog.log');
        }

        $pathInfo       = pathinfo($config['path']);
        $config['path'] = str_replace(
            $pathInfo['filename'],
            $pathInfo['filename'] . '-' . php_sapi_name(),
            $config['path']
        );

        $streamHandler = new StreamHandler(
            $config['path'],
            $config['level'] ?? Logger::DEBUG,
            $config['bubble'] ?? true,
            $config['permission'] ?? null,
            $config['lock'] ?? false
        );

        $streamHandler->setFormatter(new DataDogAgentFormatter());

        return (new Logger('datadog-agent'))->pushHandler($streamHandler);
    }
}
