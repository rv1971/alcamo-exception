<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a write operation was unsuccessful.
 *
 * @date Last reviewed 2026-01-07
 */
class WriteError extends AbstractIoException
{
    public const NORMALIZED_MESSAGE = 'Failed to {operation}';
}
