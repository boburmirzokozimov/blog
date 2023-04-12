<?php

namespace App\Controller;

use DomainException;
use Psr\Log\LoggerInterface;

class ErrorHandler
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function handle(DomainException $exception): void
    {
        $this->logger->warning($exception->getMessage(), [
            $exception->getCode(),
            $exception->getLine(),
            $exception->getTraceAsString(),
            $exception->getPrevious() ? $exception->getPrevious()->getMessage() : null,
        ]);
    }
}