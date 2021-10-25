<?php

namespace alcamo\exception;

/// Exception message factory interface
interface MessageFactoryInterface
{
    public function createMessage(
        string $normalizedMessage,
        array $context
    ): string;
}
