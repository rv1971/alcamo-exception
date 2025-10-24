<?php

namespace alcamo\exception;

/**
 * @brief Exception typically thrown when validation of structured data such
 * as JSON or XML failed.
 *
 * Beware of confusion with SyntaxError. SyntaxError is meant to be thrown
 * when data could not even be parsed (e.g. when XML data is not
 * well-formed). DataValidationFailed is meant to be thrown when data could be
 * parsed but the parsed content is invalid (e.g. when XML data is not valid
 * according to an XML Schema).
 *
 * @date Last reviewed 2025-10-07
 */
class DataValidationFailed extends AbstractDataException
{
    /** @copybrief alcamo::exception::AbsolutePathNeeded::NORMALIZED_MESSAGE */
    public const NORMALIZED_MESSAGE = 'Validation failed';
}
