<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when detecting a recursion
 *
 * @date Last reviewed 2025-10-07
 */
class Recursion extends \RuntimeException implements ExceptionInterface
{
    use ExceptionTrait;

    /** @copybrief alcamo::exception::AbsolutePathNeeded::NORMALIZED_MESSAGE */
    public const NORMALIZED_MESSAGE = 'Recursion detected';
}
