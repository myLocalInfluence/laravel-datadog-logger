<?php

namespace Myli\DatadogLogger;

use Monolog\Handler\MissingExtensionException;
use Monolog\Logger;

/**
 * Class CreateDataDogLogger
 *
 * @package   Myli\DatadogLogger
 * @author    Aurélien SCHILTZ <aurelien@myli.io>
 * @copyright 2016-2019 Myli
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class CreateDataDogLogger
{
    /**
     * Create DataDogLogger
     *
     * @param array $config
     *
     * @return Logger
     * @throws MissingExtensionException
     */
    public function __invoke(array $config)
    {
        $isEuropeRegion = false;
        if (!empty($config['region']) && $config['region'] === 'eu') {
            $isEuropeRegion = true;
        }
        if (empty($config['apiKey'])) {
            throw new \Exception('apiKey not set for DataDogLogger');
        }
        $dataDogHandler = new DataDogHandler($config['apiKey'], $isEuropeRegion, $config['level'] ?? Logger::DEBUG, $config['bubble'] ?? true);

        return (new Logger('datadog'))->pushHandler($dataDogHandler);
    }
}
