<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when encountering an unknown namespace prefix
 *
 * @date Last reviewed 2025-10-07
 */
class UnknownNamespacePrefix extends \UnexpectedValueException implements
    ExceptionInterface
{
    use ExceptionTrait;

    public const NORMALIZED_MESSAGE = 'Unknown namespace prefix {prefix}';
}
