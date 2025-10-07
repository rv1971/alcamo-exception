<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when an underflow occurs in an object.^
 *
 * @date Last reviewed 2025-10-07
 */
class Underflow extends AbstractObjectStateException
{
    public const NORMALIZED_MESSAGE = 'Underflow in {objectType} {object}';
}
