<?php

namespace Myli\DatadogLogger;

use Illuminate\Log\Logger;
use Monolog\Formatter\JsonFormatter;

/**
 * Class DataDogFormatter
 *
 * @package   DatadogLogger
 * @author    Aurélien SCHILTZ <aurelien@myli.io>
 * @copyright 2016-2019 Myli
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class DataDogFormatter extends JsonFormatter
{

    /**
     * Set this formatter to the logger
     *
     * @param $logger
     *
     * @return void
     */
    public function __invoke(Logger $logger)
    {
        /**
         * @var \Monolog\Logger $logger We can assume it's a monolog logger since
         * Laravel's Logger has _call function calling the logger directly
         */
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter($this);
        }
    }

    /**
     * Appends every variable needed by DataDog
     *
     * @TODO Handle trace_id for projects linked with DataDog APM
     *
     * @param array $record
     *
     * @return string
     * @see  \Monolog\Formatter\JsonFormatter::format()
     * @see  https://docs.datadoghq.com/logs/processing/#reserved-attributes
     */
    public function format(array $record)
    {
        if (isset($record['datetime']) && ($record['datetime'] instanceof \DateTime)) {
            /**
             * @var \DateTime $dateTimeObj
             */
            $dateTimeObj              = $record['datetime'];
            $record['published_date'] = $dateTimeObj->format(\DateTime::ISO8601);
        }

        if (isset($record['level_name'])) {
            $record['status'] = $record['level_name'];
        }
        $record['ddsource'] = 'php-' . php_sapi_name();
        $record['service']  = config('app.name');
        $record['hostname'] = gethostname();

        return parent::format($record);
    }
}
