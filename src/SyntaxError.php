<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a syntax error occurred
 *
 * Beware of confusion with DataValidationFailed (see there).
 */
class SyntaxError extends AbstractDataException
{
    NORMALIZED_MESSAGE = 'Syntax error';
}
