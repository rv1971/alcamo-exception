<?php

namespace alcamo\exception;

/// Exception thrown due to issues in data
class AbstractDataException extends \RuntimeException implements
    ExceptionInterface
{
    use ExceptionTrait;
}
