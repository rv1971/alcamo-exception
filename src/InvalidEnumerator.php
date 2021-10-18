<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a value was not in the expected enumeration
 */
class InvalidEnumerator extends \UnexpectedValueException implements
    ExceptionInterface
{
    use ExceptionTrait;

    public const NORMALIZED_MESSAGE = 'Invalid value {value}';
}
