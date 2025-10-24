<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown by an attempt to open an already opened object
 *
 * @date Last reviewed 2025-10-07
 */
class Opened extends AbstractObjectStateException
{
    /** @copybrief alcamo::exception::AbsolutePathNeeded::NORMALIZED_MESSAGE */
    public const NORMALIZED_MESSAGE =
        'Attempt to open already opened {objectType} {object}';
}
