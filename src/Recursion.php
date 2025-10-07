<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when detecting a recursion
 *
 * @date Last reviewed 2025-10-07
 */
class Recursion extends \RuntimeException implements ExceptionInterface
{
    use ExceptionTrait;

    public const NORMALIZED_MESSAGE = 'Recursion detected';
}
