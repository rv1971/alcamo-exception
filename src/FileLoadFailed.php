<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a file was not found
 *
 * Beware of confusion with FileNotFound. FileNotFound is thrown when it has
 * come out that a file does not exist. FileLoadFailed is thrown if a file
 * probably exists but nonetheless could not be loaded.
 */
class FileLoadFailed extends AbstractIoException
{
    public const NORMALIZED_MESSAGE = 'Failed to load {filename}';
}
