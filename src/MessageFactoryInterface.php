<?php

namespace alcamo\exception;

/**
 * @brief Exception message factory interface
 *
 * @date Last reviewed 2025-10-07
 */
interface MessageFactoryInterface
{
    public function createMessage(
        string $normalizedMessage,
        array $context
    ): string;
}
