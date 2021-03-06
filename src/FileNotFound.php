<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a file was not found
 *
 * Beware of confusion with FileLoadFailed (see there).
 */
class FileNotFound extends AbstractIoException
{
    public const NORMALIZED_MESSAGE = 'File {filename} not found';
}
