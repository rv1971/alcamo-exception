<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a relative URI is given where an absolute one
 * would be needed
 */
class AbsoluteUriNeeded extends \UnexpectedValueException
    implements ExceptionInterface
{
    use ExceptionTrait;

    NORMALIZED_MESSAGE =
        'Relative URI {uri} given where absolute URI is needed';
}
