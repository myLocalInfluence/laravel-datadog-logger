<?php

namespace Myli\DatadogLogger\Agent;

use Illuminate\Log\Logger;
use Myli\DatadogLogger\DataDogFormatter;

/**
 * Class DataDogAgentFormatter
 *
 * @package   Myli\DatadogLogger\Agent
 * @author    Aurélien SCHILTZ <aurelien@myli.io>
 * @copyright 2016-2019 Myli
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class DataDogAgentFormatter extends DataDogFormatter
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
}
