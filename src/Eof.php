<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when data ends prematurely
 *
 * @date Last reviewed 2025-10-07
 */
class Eof extends AbstractObjectStateException
{
    public const NORMALIZED_MESSAGE =
        'Failed to read {requestedUnits} unit(s) from {objectType} {object}';
}
