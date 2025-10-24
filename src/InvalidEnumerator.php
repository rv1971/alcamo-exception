<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a value was not in the expected enumeration
 *
 * @date Last reviewed 2025-10-07
 */
class InvalidEnumerator extends \UnexpectedValueException implements
    ExceptionInterface
{
    use ExceptionTrait;

    /** @copybrief alcamo::exception::AbsolutePathNeeded::NORMALIZED_MESSAGE */
    public const NORMALIZED_MESSAGE = 'Invalid value {value}';
}
