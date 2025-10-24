<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown by an attempt to access an uninitialized object
 *
 * @date Last reviewed 2025-10-07
 */
class Uninitialized extends AbstractObjectStateException
{
    /** @copybrief alcamo::exception::AbsolutePathNeeded::NORMALIZED_MESSAGE */
    public const NORMALIZED_MESSAGE =
        'Attempt to access uninitialized {objectType} {object}';
}
