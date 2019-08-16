<?php

namespace Myli\DatadogLogger;

class ApiKeyNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('apiKey not set for DataDogLogger', 500, null);
    }
}
