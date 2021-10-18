<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown by an attempt to write to a readonly object
 */
class ReadonlyViolation extends \LogicException implements ExceptionInterface
{
    use ExceptionTrait;

    public const NORMALIZED_MESSAGE =
        'Attempt to modify readonly object {object}';
}
