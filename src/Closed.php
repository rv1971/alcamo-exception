<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown by an attempt to use an already closed object
 *
 * @date Last reviewed 2025-10-07
 */
class Closed extends AbstractObjectStateException
{
    public const NORMALIZED_MESSAGE =
        'Attempt to use closed {objectType} {object}';
}
