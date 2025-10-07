<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown due to issues in data
 *
 * @date Last reviewed 2025-10-07
 */
class AbstractDataException extends \RuntimeException implements
    ExceptionInterface
{
    use ExceptionTrait;
}
