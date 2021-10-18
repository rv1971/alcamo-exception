<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a directory was not found
 */
class DirectoryNotFound extends AbstractIoException
{
    public const NORMALIZED_MESSAGE = 'Directory {path} not found';
}
