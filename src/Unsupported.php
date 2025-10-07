<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when attempting to use an unsupported feature
 *
 * @date Last reviewed 2025-10-07
 */
class Unsupported extends \LogicException implements ExceptionInterface
{
    use ExceptionTrait;

    public const NORMALIZED_MESSAGE = '{feature} not supported';
}
