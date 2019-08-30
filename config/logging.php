<?php

use Myli\DatadogLogger\Agent\CreateDataDogAgentLogger;
use Myli\DatadogLogger\Api\CreateDataDogApiLogger;

return [
    'datadog-agent' => [
        'driver'     => 'custom',
        'via'        => CreateDataDogAgentLogger::class,
        'path'       => storage_path(env('DATADOG_STORAGE_PATH')),
        'level'      => env('DATADOG_LEVEL', 'info'),  // choose your minimum level of logging.
        'permission' => env('DATADOG_PERMISSIONS', 0644),
        'bubble'     => env('DATADOG_BUBBLE', true),
    ],
    'datadog-api'   => [
        'driver' => 'custom',
        'via'    => CreateDataDogApiLogger::class,
        'apiKey' => env('DATADOG_API_KEY'),
        'region' => env('DATADOG_REGION', 'eu'),   // eu or us
        'level'  => env('DATADOG_LEVEL', 'info'),  // choose your minimum level of logging.
        'bubble' => env('DATADOG_BUBBLE', true),
    ],
];
