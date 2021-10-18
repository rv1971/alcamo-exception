<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when attempting to call a non-existent method.
 *
 * Typically used in the magic method __call().
 */
class MethodNotFound extends \BadMethodCallException implements
    ExceptionInterface
{
    use ExceptionTrait;

    public const NORMALIZED_MESSAGE = 'Method {method} not found';
}
