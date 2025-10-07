<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a relative path is given where an absolute one
 * would be needed
 *
 * @date Last reviewed 2025-10-07
 */
class AbsolutePathNeeded extends \UnexpectedValueException implements
    ExceptionInterface
{
    use ExceptionTrait;

    public const NORMALIZED_MESSAGE =
        'Relative path {path} given where absolute path is needed';
}
