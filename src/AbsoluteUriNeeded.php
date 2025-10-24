<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a relative URI is given where an absolute one
 * would be needed
 *
 * @date Last reviewed 2025-10-07
 */
class AbsoluteUriNeeded extends \UnexpectedValueException implements
    ExceptionInterface
{
    use ExceptionTrait;

    /** @copybrief alcamo::exception::AbsolutePathNeeded::NORMALIZED_MESSAGE */
    public const NORMALIZED_MESSAGE =
        'Relative URI {uri} given where absolute URI is needed';
}
