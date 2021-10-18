<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when attempting to use an unsupported feature
 */
class Unsupported extends \LogicException implements ExceptionInterface
{
    use ExceptionTrait;

    NORMALIZED_MESSAGE = '{feature} not supported';
}
