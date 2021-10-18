<?php

namespace alcamo\exception;

/// Exception thrown when an underflow occurs in an object.^
class Underflow extends AbstractObjectStateException
{
    NORMALIZED_MESSAGE = 'Underflow in {object}';
}
