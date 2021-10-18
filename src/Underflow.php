<?php

namespace alcamo\exception;

/// Exception thrown when an underflow occurs in an object.^
class Underflow extends AbstractObjectStateException
{
    public const NORMALIZED_MESSAGE = 'Underflow in {object}';
}
