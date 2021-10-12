<?php

namespace alcamo\exception;

/// Exception thrown due to i/o issues
class AbstractIoException extends \RuntimeException
    implements ExceptionInterface
{
    use ExceptionTrait;
}
