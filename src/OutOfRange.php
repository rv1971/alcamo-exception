<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a value was not in the expected range
 */
class OutOfRange extends \UnexpectedValueException
    implements ExceptionInterface
{
    use ExceptionTrait;

    NORMALIZED_MESSAGE =
        'Value {value} out of range [{lowerBound}, {upperBound}]';

    DEFAULT_MESSAGE_CONTEXT = [
        'lowerBound' => '-∞',
        'upperBound' => '∞'
    ];
}
