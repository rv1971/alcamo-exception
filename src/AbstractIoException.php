<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown due to I/O issues
 *
 * @date Last reviewed 2025-10-07
 */
class AbstractIoException extends \RuntimeException implements
    ExceptionInterface
{
    use ExceptionTrait;
}
