<?php

namespace alcamo\exception;

/**
 * @brief Exception typically thrown when validation of structured data such
 * as JSON or XML failed.
 *
 * Beware of confusion with SyntaxError. SyntaxError is thrown when data could
 * not even be parsed (e.g. when XML data is not
 * well-formed). DataValidationFailed is thrown when data could be parsed but
 * the parsed content is invalid (e.g. when XML data is not valid).
 */
class DataValidationFailed extends AbstractDataException
{
    public const NORMALIZED_MESSAGE = 'Validation failed';
}
