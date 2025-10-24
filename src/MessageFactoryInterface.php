<?php

namespace alcamo\exception;

/**
 * @brief Exception message factory interface
 *
 * @date Last reviewed 2025-10-07
 */
interface MessageFactoryInterface
{
    /// Create a message string by replacing placeholders
    public function createMessage(
        string $normalizedMessage,
        array $context
    ): string;
}
