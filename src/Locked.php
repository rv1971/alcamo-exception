<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown by an attempt to modify a locked object
 *
 * @date Last reviewed 2025-10-07
 */
class Locked extends AbstractObjectStateException
{
    /** @copybrief alcamo::exception::AbsolutePathNeeded::NORMALIZED_MESSAGE */
    public const NORMALIZED_MESSAGE =
        'Attempt to modify locked {objectType} {object}';
}
