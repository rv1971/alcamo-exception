<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a file could not be loaded
 *
 * Beware of confusion with FileNotFound. FileNotFound is meant to be thrown
 * when it has come out that a file does not exist. FileLoadFailed is meant to
 * be thrown when a file probably exists but nonetheless could not be loaded,
 * typically because it could not be parsed.
 *
 * @date Last reviewed 2025-10-07
 */
class FileLoadFailed extends AbstractIoException
{
    public const NORMALIZED_MESSAGE = 'Failed to load {filename}';
}
