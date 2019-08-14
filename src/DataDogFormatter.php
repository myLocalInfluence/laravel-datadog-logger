<?php

namespace Myli\DatadogLogger;

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

        return parent::format($record);
    }
}
