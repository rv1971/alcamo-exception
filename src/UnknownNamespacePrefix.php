<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when encountering an unknown namespace prefix
 */
class UnknownNamespacePrefix extends \UnexpectedValueException implements
    ExceptionInterface
{
    use ExceptionTrait;

    public const NORMALIZED_MESSAGE = 'Unknown namespace prefix {prefix}';
}
