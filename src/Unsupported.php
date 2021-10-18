<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when attempting to use an unsupported feature
 */
class Unsupported extends \LogicException implements ExceptionInterface
{
    use ExceptionTrait;

    public const NORMALIZED_MESSAGE = '{feature} not supported';
}
