<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when detecting a recursion
 */
class Recursion extends \RuntimeException implements ExceptionInterface
{
    use ExceptionTrait;

    public const NORMALIZED_MESSAGE = 'Recursion detected';
}
