<?php

namespace App\Kafka\Infrastructure;

class FailureCallback
{
    /**
     * @throws InfrastructureException
     */
    public static function fail($obj, $code, $message): void
    {
        throw new InfrastructureException($message, $code);
    }
}
