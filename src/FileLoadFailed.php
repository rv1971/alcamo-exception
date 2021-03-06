<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a file could not be loaded
 *
 * Beware of confusion with FileNotFound. FileNotFound is thrown when it has
 * come out that a file does not exist. FileLoadFailed is thrown if a file
 * probably exists but nonetheless could not be loaded, typically because it
 * could not be parsed.
 */
class FileLoadFailed extends AbstractIoException
{
    public const NORMALIZED_MESSAGE = 'Failed to load {filename}';
}
