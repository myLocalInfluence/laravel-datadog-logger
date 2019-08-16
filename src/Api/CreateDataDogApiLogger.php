<?php

namespace Myli\DatadogLogger\Api;

use Exception;
use Monolog\Handler\MissingExtensionException;
use Monolog\Logger;
use Myli\DatadogLogger\ApiKeyNotFoundException;

/**
 * Class CreateDataDogApiLogger
 *
 * @package   Myli\DatadogLogger\Api
 * @author    Aurélien SCHILTZ <aurelien@myli.io>
 * @copyright 2016-2019 Myli
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class CreateDataDogApiLogger
{
    /**
     * Create the DataDog Api Logger
     *
     * @param array $config
     *
     * @return Logger
     * @throws ApiKeyNotFoundException
     * @throws MissingExtensionException
     */
    public function __invoke(array $config)
    {
        $isEuropeRegion = false;
        if (!empty($config['region']) && $config['region'] === 'eu') {
            $isEuropeRegion = true;
        }
        if (empty($config['apiKey'])) {
            throw new ApiKeyNotFoundException();
        }
        $dataDogHandler = new DataDogApiHandler(
            $config['apiKey'],
            $isEuropeRegion,
            $config['level'] ?? Logger::DEBUG,
            $config['bubble'] ?? true
        );

        return (new Logger('datadog-api'))->pushHandler($dataDogHandler);
    }
}
