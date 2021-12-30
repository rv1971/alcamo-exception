<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when data were not found
 *
 * Meant for situations where a piece of data was not found in a data storage
 * other than a file system.
 */
class DataNotFound extends AbstractDataException
{
    public const NORMALIZED_MESSAGE = 'Data not found';
}
