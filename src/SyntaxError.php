<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a syntax error occurred
 *
 * Beware of confusion with DataValidationFailed (see there).
 *
 * @date Last reviewed 2025-10-07
 */
class SyntaxError extends AbstractDataException
{
    public const NORMALIZED_MESSAGE = 'Syntax error';
}
