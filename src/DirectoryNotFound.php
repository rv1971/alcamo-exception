<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a directory was not found
 *
 * @date Last reviewed 2025-10-07
 */
class DirectoryNotFound extends AbstractIoException
{
    public const NORMALIZED_MESSAGE = 'Directory {path} not found';
}
