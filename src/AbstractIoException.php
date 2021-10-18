<?php

namespace alcamo\exception;

/// Exception thrown due to I/O issues
class AbstractIoException extends \RuntimeException implements
    ExceptionInterface
{
    use ExceptionTrait;
}
