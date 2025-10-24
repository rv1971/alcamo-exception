<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a call to popen() or proc_open() failed
 */
class PopenFailed extends ProcessFailed
{
    /** @copybrief alcamo::exception::AbsolutePathNeeded::NORMALIZED_MESSAGE */
    public const NORMALIZED_MESSAGE = 'Failed to open process {command}';
}
